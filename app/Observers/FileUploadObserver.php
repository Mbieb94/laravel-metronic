<?php

namespace App\Observers;

use App\Models\Resources;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class FileUploadObserver
{
    /**
     * Handle the Resources "created" event.
     *
     * @param  \App\Models\Resources  $resources
     * @return void
     */
    protected $isNew = false;

    public function creating(Resources $resources)
    {
        if (request()->file()) {
            foreach (request()->file() as $key => $file) {
                $resources->$key = $this->writeFile($file);
            }
        }

        $this->isNew = true;
    }

    // public function created(Resources $resources)
    // {
    // }

    /**
     * Handle the Resources "updated" event.
     *
     * @param  \App\Models\Resources  $resources
     * @return void
     */

    public function saved(Resources $resources)
    {
        // $fileList = $resources->getFilesList();
        // if (!$this->isNew && $fileList) {
        //     for ($i = 0; $i < count($fileList); $i++) {
        //         $name = $fileList[$i] . '_desc';
        //         $this->updateFileDescription(request()->$name, $resources->file);
        //     }
        // }
    }

    public function updating(Resources $resources)
    {
        if (request()->file()) {
            foreach (request()->file() as $key => $file) {
                $resources->$key = $this->writeFile($file);
            }
        }
    }

    public function updated(Resources $resources)
    {
        if (request()->file()) {
            foreach (request()->file() as $key => $file) {
                if ($resources->isDirty($key)) {
                    $code = $resources->getOriginal($key);
                    $this->removeFile($code);
                }
            }
        }
    }

    public function writeFile($file, $desc = null)
    {
        $code = Str::random(15);
        $directory = public_path('storage/image/origin');

        if (!file_exists($directory)) {
            mkdir($directory, 0766, true);
        }

        $ext = $file->getClientOriginalExtension();
        $name = $code . '_org.' . $ext;
        $path = $directory . '/' . $name;
        $uploadFile = Image::make($file->getRealPath());
        $uploadFile->save($path);

        $dataFile = [
            'code' => $code,
            'name' => $file->getClientOriginalName(),
            'original_name' => $name,
            'compressed_name' => $this->writeFileCompress($file),
            'description' => $desc,
            'mimetype' => $file->getClientMimeType()
        ];

        DB::table('files')->insert($dataFile);

        return $code;
    }

    public function writeFileCompress($file)
    {
        $directory = public_path('storage/image/compress');

        if (!file_exists($directory)) {
            mkdir($directory, 0766, true);
        }

        $ext = $file->getClientOriginalExtension();
        $name = time() . '_compressed.' . $ext;
        $path = $directory . '/' . $name;
        $file = Image::make($file->getRealPath());
        $file->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path);

        return $name;
    }

    public function removeFile($code)
    {
        $file = DB::table('files')->where('code', $code);
        $data = $file->first();
        $originalFile = public_path('storage/image/origin/' . $data->original_name);
        $compressedFile = public_path('storage/image/compress/' . $data->compressed_name);

        if (File::exists($originalFile)) File::delete($originalFile);
        if (File::exists($compressedFile)) File::delete($compressedFile);

        $file->delete();
    }

    public function updateFileDescription($desc, $code)
    {
        $file = DB::table('files')->where('code', $code);
        $data = $file->first();
        if ($data->description == $desc) return false;

        $file->update(['description' => $desc]);
    }
}
