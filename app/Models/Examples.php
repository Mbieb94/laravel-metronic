<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examples extends Resources
{
    use HasFactory;
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'examples';

    protected $rules = [
        'name' => ['required', 'unique', 'string', 'max:50']
    ];

    protected $createRules = [
        'file' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'file_desc' => ['required', 'min:20', 'max:500']
    ];

    protected $updateRules = [
        'file' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'file_desc' => ['required', 'min:20', 'max:500']
    ];

    protected $forms = [
        [
            'name' => 'name',
            'required' => true,
            'column' => 7,
            'label' => 'Name',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'file',
            'required' => true,
            'column' => 5,
            'label' => 'Fileupload',
            'type' => 'fileupload',
            'display' => true,
            'size' => 1000,
            'acept' => '*'
        ]
    ];

    protected $fillable = [
        'id',
        'name',
        'file'
    ];

    protected $reference = [
        'file'
    ];

    protected $filesList = [
        'file'
    ];

    public function getReference()
    {
        return $this->reference;
    }

    public function getFields()
    {
        return $this->fillable;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function createRules()
    {
        return $this->createRules;
    }

    public function updateRules()
    {
        return $this->updateRules;
    }

    public function getFilesList()
    {
        return $this->filesList;
    }

    public function file()
    {
        return $this->belongsTo(Files::class, 'file', 'code');
    }
}
