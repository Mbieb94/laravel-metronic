<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourcesRequest;
use Illuminate\Support\Str;
use App\Models\Resources;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AppController extends Controller
{
    protected $view;
    protected $model = null;
    protected $segment = null;
    protected $table_name = null;
    protected $segmentName;
    protected $forms;
    protected $reference;

    public function __construct(Request $request, Resources $model)
    {
        try {
            $this->segment = $request->segment(1);
            if (file_exists(app_path('Models/' . Str::studly($this->segment)) . '.php')) {
                $this->model = app("App\Models\\" . Str::studly($this->segment));
            } else {
                if ($model->checkTableExists($this->segment)) {
                    $this->model = $model;
                    $this->model->setTable($this->segment);
                }
            }

            if (!$this->model) abort(404);

            $this->view = 'backend.' . $this->segment;
            $this->table_name = $this->segment;
            $this->segmentName = Str::studly($this->segment);
            $this->forms = $this->model->getForms();
            $this->reference = $this->model->getReference();
        } catch (Exception $e) {
            //throw $th;
        }
    }

    public function list()
    {
        $model = $this->model;
        if (!$model) abort(404);
        try {
            $this->view = $this->checkView($this->view, 'list');
            return $this->view->with(
                [
                    'forms' => $this->forms,
                    'segmentName' => $this->segmentName,
                    'model' => $model
                ]
            );
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function create()
    {
        $this->view = $this->checkView($this->view, 'create');

        return $this->view->with(
            [
                'forms' => $this->forms
            ]
        );
    }

    public function store(ResourcesRequest $request)
    {
        try {
            $fields = $request->only($this->model->getTableFields());
            foreach ($fields as $key => $value) {
                $this->model->setAttribute($key, $value);
            }
            $this->model->save();
            if ($request->get('xsubmit') == 1) return redirect(url($this->table_name))->with('success', Str::title(Str::singular($this->table_name)) . ' Created!');
            return back()->withInput()->with('success', Str::title(Str::singular($this->table_name)) . ' Created!');
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Invalid Request!');
        }
    }

    public function detail(Request $request)
    {
        $reference = $this->reference;
        $breadcrumbs = $this->generateBreadcrumbs($request->segments(), $request->id);
        $model = $this->model;

        if (count($reference) > 0) {
            $model = $model->with($reference);
            // for ($i = 0; $i < count($reference); $i++) {
            //     $model = $model->with($reference[$i]);
            // }
        }
        $model = $model->findOrFail($request->id)->toArray();

        $newForms = [];
        foreach ($this->forms as $key => $value) {
            $value['value'] = null;
            if (isset($model[$value['name']])) $value['value'] = $model[$value['name']];
            $newForms[$key] = $value;
        }

        $this->view = $this->checkView($this->view, 'detail');
        return $this->view->with(
            [
                'forms' => $newForms,
                'breadcrumbs' => $breadcrumbs
            ]
        );
    }

    public function edit(Request $request)
    {
        $this->authorize('update', $this->model->findOrFail($request->id));

        $reference = $this->reference;
        $breadcrumbs = $this->generateBreadcrumbs($request->segments(), $request->id);
        $model = $this->model;

        if (count($reference) > 0) {
            for ($i = 0; $i < count($reference); $i++) {
                $model = $model->with($reference[$i]);
            }
        }
        $model = $model->findOrFail($request->id)->toArray();

        $newForms = [];
        foreach ($this->forms as $key => $value) {
            $name = str_replace('[]', '', $value['name']);
            $value['value'] = null;
            if (isset($model[$name])) $value['value'] = $model[$name];
            $newForms[$key] = $value;
        }

        $this->view = $this->checkView($this->view, 'edit');
        return $this->view->with(
            [
                'forms' => $newForms,
                'breadcrumbs' => $breadcrumbs
            ]
        );
    }

    public function update(ResourcesRequest $request)
    {
        try {
            $model = $this->model->findOrFail($request->id);
            $fields = $request->only($this->model->getTableFields());

            foreach ($fields as $key => $value) {
                $model->setAttribute($key, $value);
            }

            if (!$model->isDirty()) return back()->withInput()->with('warning', 'Nothing to update!');
            $model->save();

            return redirect(url($this->table_name))->with('success', Str::title(Str::singular($this->table_name)) . ' updated!');
        } catch (Exception $e) {
            return back()->withInput()->withError(Str::title(Str::singular($this->table_name)) . ' failed to update!');
        }
    }

    public function trash(Request $request)
    {
        try {
            $model = $this->model->findOrFail($request->id);
            $model->delete();

            return redirect($this->table_name)->with('success', Str::title(Str::singular($this->table_name)) . ' deleted!');
        } catch (Exception $th) {
            return redirect($this->table_name)->withError(Str::title(Str::singular($this->table_name)) . ' failed to delete!');
        }
    }

    public function trashed()
    {
        $model = $this->model;

        if (!$model) abort(404);
        try {
            $this->view = $this->checkView($this->view, 'trashed');
            return $this->view->with(
                [
                    'forms' => $this->forms,
                    'segmentName' => $this->segmentName
                ]
            );
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function delete(Request $request)
    {
        if (!$this->model) abort(404);
        try {
            $model = $this->model->onlyTrashed()->findOrFail($request->id);
            $model->forceDelete();
            return redirect($this->table_name . '/trashed')->with('success', Str::title(Str::singular($this->table_name)) . ' deleted!');
        } catch (Exception $e) {
            return redirect($this->table_name . '/trashed')->with('error', $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        if (!$this->model) abort(404);
        try {
            $model = $this->model->onlyTrashed()->findOrFail($request->id);
            $model->restore();
            return redirect($this->table_name)->with('success', Str::title(Str::singular($this->table_name)) . ' Restored!');
        } catch (Exception $e) {
            return redirect($this->table_name)->with('error', $e->getMessage());
        }
    }

    public function checkView($dir, $fileName)
    {
        $directory = $dir . '.' . $fileName;
        $dirname = str_replace('.', '/', $directory);
        $basePath = base_path('resources/views/') . $dirname . '.blade.php';
        if (file_exists($basePath)) return view($directory);
        return view('backend.shared.' . $fileName);
    }

    public function generateBreadcrumbs($segments = array(), $id)
    {
        $hirarcies = array();
        foreach ($segments as $item) {
            if ($item == $id) continue;
            $hirarcies[] = $item;
        }

        return $hirarcies;
    }

    public function export(Request $request)
    {
        $reference = $this->reference;
        $offset    = $request->get('start') ? $request->get('start') : 0;
        $limit     = $request->get('length') ? $request->get('length') : 10;
        $search    = $request->get('search');
        $orderBy   = $request->get('order');
        $params    = $request->get('params');
        $status    = $request->get('status');

        $model = $this->model;
        $fields = $model->getFields();

        $forms = ['id'];
        foreach ($this->forms as $items) {
            if ($items['display']) $forms[] = $items['name'];
        }

        if ($status == 2) {
            $model = $model->onlyTrashed();
        }

        if (count($reference) > 0) {
            $model = $model->with($reference);
        }

        if (!empty($search)) {
            $model = $model->where(function ($model) use ($fields, $search) {
                foreach ($fields as $key => $item) {
                    if ($key == 0) {
                        $model->where($item, 'LIKE', '%' . $search . '%');
                    } else {
                        $model->orWhere($item, 'LIKE', '%' . $search . '%');
                    }
                }
            });
        }

        if (!empty($params)) {
            foreach ($params as $key => $item) {
                if (!empty($item['value'])) $model = $model->where($item['name'], $item['value']);
            }
        }

        $total = $model->count();

        if ($total <= 0) return response(['status' => 201, 'message' => 'Nothing to export.']);

        $order = 'desc';
        if ($orderBy[0]['column']) {
            $order = $orderBy[0]['dir'];
        }

        $model = $model->orderBy($forms[$orderBy[0]['column']], $order);
        $model = $model->get();

        $spreadsheet = new Spreadsheet();

        $header = [
            'font' => [
                'size' => 14
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '1E90FF')
            ],
        ];

        $body = [
            'font' => [
                'size' => 12
            ]
        ];

        $forms = [];
        foreach ($this->forms as $key => $items) {
            $forms[$items['name']] = $items['type'];
            $spreadsheet->getActiveSheet()->getColumnDimension($this->getAlfabet($key))->setAutoSize(true);
            $spreadsheet->getActiveSheet()->SetCellValue($this->getAlfabet($key) . '1', $items['label']);
            $spreadsheet->getActiveSheet()->getStyle($this->getAlfabet($key) . '1')->applyFromArray($header);
        }

        $count = 2;
        foreach ($model->toArray() as $key => $items) {
            $no = 0;
            foreach ($forms as $key => $val) {
                $data = $items[$key];
                $spreadsheet->getActiveSheet()->SetCellValue($this->getAlfabet($no) . $count, $data);
                $spreadsheet->getActiveSheet()->getStyle($this->getAlfabet($no) . $count)->applyFromArray($body);
                $no++;
            }
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $path = public_path('storage/excel');

        if (!file_exists($path)) mkdir($path, 0766, true);

        $name = $request->segment(1) . '_' . date('Y-m-d') . '.xlsx';
        $directory = $path . '/' .  $name;
        $writer->save($directory);

        return response([
            'status' => 200,
            'message' => 'Data was exported successfully',
            'directory' => 'storage/excel/' . $name
        ]);
    }

    public function getAlfabet($number)
    {
        $result = "";
        while ($number >= 0) {
            $result = chr($number % 26 + 65) . $result;
            $number = floor($number / 26) - 1;
        }
        return $result;
    }

    public function downloadFile($path)
    {
        try {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($path)));
            // header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));

            // ob_clean();
            flush();
            readfile($path);
            die();
        } catch (Exception $e) {
            return response([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
