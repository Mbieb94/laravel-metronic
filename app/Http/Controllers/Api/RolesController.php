<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Component;
use App\Models\Roles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    private $model;
    protected $reference;
    protected $forms;

    public function __construct(Request $request, Roles $model)
    {
        try {
            if (file_exists(app_path('Models/' . Str::studly('users')) . '.php')) {
                $this->model = app("App\Models\\" . Str::studly('users'));
            } else {
                if ($model->checkTableExists('users')) {
                    $this->model = $model;
                    $this->model->setTable('users');
                }
            }

            $this->reference = $this->model->getReference();
            $this->forms = $this->model->getForms();
        } catch (Exception $e) {
            //throw $th;
        }
    }

    public function dataTable(Request $request)
    {
        $reference = $this->reference;
        $offset = $request->get('start') ? $request->get('start') : 0;
        $limit = $request->get('length') ? $request->get('length') : 10;
        $search = $request->get('search');
        $params = $request->get('params');
        $status = $request->get('status');

        $model = $this->model;
        $fields = $model->getFields();

        $forms = ['id'];
        foreach ($this->forms as $items) {
            if ($items['display']) $forms[] = $items['name'];
        }
        
        if ($status == 2) $model = $model->onlyTrashed();

        $reference[] = 'getUsers';
        if (count($reference) > 0) $model = $model->with($reference);

        $model = $this->getSearch($model, $fields, $search);
        $model = $this->advanceSearch($model, $params);

        $total = $model->count();

        $order = 'desc';
        if ($request->get('order')[0]['column']) {
            $order = $request->get('order')[0]['dir'];
        }
        $model = $model->orderBy($forms[$request->get('order')[0]['column']], $order);

        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $model = $model->get();

        $forms = [];
        foreach ($this->forms as $items) {
            $forms[$items['name']]['name'] = $items['type'];
            if(in_array($items['type'], ['select2', 'multiselect2'])) 
                $forms[$items['name']]['options'] = $items['options'];
        }

        $dataTable = [];
        foreach ($model->toArray() as $key => $items) {
            $users = '<div class="symbol-group symbol-hover flex-nowrap">';
            $count = count($items['get_users']);
            $listUsers = '<div>';
            for ($i = 0; $i < $count; $i++) {
                if (!$items['get_users'][$i]['users_id']) continue;
                $username = $items['get_users'][$i]['users_id']['username'];
                $first_character = substr($username, 0, 2);
                if($i > 15) {
                    $listUsers .= '<span>'.$username.'</span><br>';
                    continue;
                }

                $img = json_decode($items['get_users'][$i]['users_id']['photo'], true);
                $img['filename'] = !empty($img['filename']) ? $img['filename'] : 'xxx.png';
                $image = asset('storage/avatar') . '/' . $img['filename'];
                $dom = '
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $items['get_users'][$i]['users_id']['username'] . '">
                            <img alt="Pic" src="' . $image . '">
                    </div>
                ';
                if (!file_exists(public_path('storage/avatar/' . $img['filename']))) {
                    $color = ["primary", "warning", "danger", "info", "success", "secondary"];
                    $rand_keys = array_rand($color);
                    $dom = '
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $items['get_users'][$i]['users_id']['username'] . '">
                                <span class="symbol-label bg-'.$color[$rand_keys].' text-inverse-'.$color[$rand_keys].' fs-8 fw-bold">'.strtoupper($first_character).'</span>
                        </div>
                    ';
                }

                $users .= $dom;
            }
            $listUsers .= '</div>';

            if(count($items['get_users']) > 15) {
                $leftNumber = count($items['get_users']) - 15;
                $users .= '
                    <div class="symbol symbol-35px symbol-circle"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right" title="'.$listUsers.'">
                        <span class="symbol-label bg-primary text-inverse-primary fs-8 fw-bold">+'.$leftNumber.'</span>
                    </div>
                ';
            }
            
            $users .= '</div>';
            $items['get_users'] = $users;
            foreach ($items as $q => $value) {
                $data = $value;
                if (isset($forms[$q]['name'])) {
                    $func = ucfirst($forms[$q]['name']);
                    $data = Component::$func($value, $forms[$q]);
                }
                $dataTable[$key][$q] = $data;
            }
        }

        $draw = 1;
        if (!empty($request->get('draw'))) $draw = $request->get('draw');

        $data = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $dataTable
        ];

        return response($data);
    }

    public function getSearch ($model, $fields, $search) {
        if (empty($search)) return $model;
        $model = $model->where(function ($model) use ($fields, $search) {
            foreach ($fields as $key => $item) {
                switch ($key) {
                    case 0:
                        $model->where($item, 'LIKE', '%' . $search . '%');
                        break;
                    default:
                        $model->orWhere($item, 'LIKE', '%' . $search . '%');
                        break;
                }
            }
        });

        return $model;
    }

    public function advanceSearch($model, $params) {
        if(empty($params)) return $model;
        foreach ($params as $key => $item) {
            if (empty($item['value'])) continue;
            $operator = explode('!', $item['name']);

            if(count($operator) <= 1) {
                $model = $model->where($item['name'], $item['value']);
                continue;
            }

            switch ($operator[1]) {
                case 'in':
                    $model = $model->whereIn($operator[0], json_decode($item['value'], true));
                    break;
                
                default:
                    $model = $model->where($operator[0], $item['value']);
                    break;
            }
        }

        return $model;
    }
}
