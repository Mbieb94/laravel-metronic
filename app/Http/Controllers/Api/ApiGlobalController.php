<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Component;
use App\Library\Operator;
use App\Models\Files;
use App\Models\Resources;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ApiGlobalController extends Controller
{
    private $model;
    protected $reference;
    protected $forms;
    protected $segment;
    protected $table_name;

    public function __construct(Request $request, Resources $model)
    {
        try {
            $this->segment = $request->segment(3);
            if (file_exists(app_path('Models/' . Str::studly($this->segment)) . '.php')) {
                $this->model = app("App\Models\\" . Str::studly($this->segment));
            } else {
                if ($model->checkTableExists($this->segment)) {
                    $this->model = $model;
                    $this->model->setTable($this->segment);
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
        $orderBy = $request->get('order');
        $params = $request->get('params');
        $status = $request->get('status');
        
        $model = $this->model;
        $fields = $model->getFields();

        $forms = ['id'];
        foreach ($this->forms as $items) {
            if ($items['display']) $forms[] = $items['name'];
        }
        
        if ($status == 2) $model = $model->onlyTrashed();

        if (count($reference) > 0) $model = $model->with($reference);
        
        $total = $model->count();

        $model = $this->getSearch($model, $fields, $search);
        $model = $this->advanceSearch($model, $params);

        $totalFilterd = $model->count();
        $order = 'desc';
        if ($orderBy[0]['column']) {
            $order = $orderBy[0]['dir'];
        }

        $model = $model->orderBy($forms[$orderBy[0]['column']], $order);
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
            'recordsFiltered' => $totalFilterd,
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

            $opFunc = $operator[1];
            $model = Operator::$opFunc($model, $operator[0], $item['value']);
        }

        return $model;
    }

    public function list(Request $request)
    {
        dd(123);
    }

    public function thumbnail($value)
    {
        $file = asset('assets/media/avatars/blank.png');
        if (!empty($value)) {
            $image = json_decode($value, true);
            $file = url('storage/avatar/', $image['filename']);
        }

        $data = ['file' => $file];
        return view('_forms.thumbnail.plain', compact('data'))->render();
    }

    public function trash(Request $request)
    {
        try {
            $selectedId = explode(',', $request->id);
            for ($i = 0; $i < count($selectedId); $i++) {
                $model = $this->model->findOrFail($selectedId[$i]);
                $model->delete();
            }

            $data = [
                'status' => 200
            ];
            return response($data);
        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];

            return response($data);
        }
    }

    public function delete(Request $request)
    {
        try {
            $selectedId = explode(',', $request->id);
            $listFileCode = [];
            for ($i = 0; $i < count($selectedId); $i++) {
                $model = $this->model->onlyTrashed()->findOrFail($selectedId[$i]);

                if ($this->model->getFilesList()) {
                    $fileList = $this->model->getFilesList();
                    for ($x = 0; $x < count($fileList); $x++) {
                        $name = $fileList[$i];
                        $listFileCode[] = $model->$name;
                    }
                }

                $model->forceDelete();
            }

            if (count($listFileCode) > 0) $this->deleteFiles($listFileCode);

            $data = [
                'status' => 200,
                'message' => 'Rows Deleted'
            ];
            return response($data);
        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
            return response($data);
        }
    }

    public function deleteFiles($listCode)
    {
        Files::whereIn('code', $listCode)->each(function ($data, $items) {
            $originalFile = public_path('storage/image/origin/' . $data->original_name);
            $compressedFile = public_path('storage/image/compress/' . $data->compressed_name);

            if (File::exists($originalFile)) File::delete($originalFile);
            if (File::exists($compressedFile)) File::delete($compressedFile);

            $data->delete();
        });
    }

    public function restore(Request $request)
    {
        try {
            $model = $this->model->onlyTrashed()->findOrFail($request->id);
            $model->restore();
            $data = [
                'status' => 200,
                'message' => 'Rows Restored'
            ];
            return response($data);
        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
            return response($data);
        }
    }
}
