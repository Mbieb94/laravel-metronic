<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banners extends Resources
{
    use HasFactory;
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'banners';

    protected $rules = [];

    protected $createRules = [
        'banner_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ];

    protected $updateRules = [
        'banner_image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
    ];

    protected $forms = [
        [
            'name' => 'banner_image',
            'required' => true,
            'column' => 5,
            'label' => 'Banner Image',
            'type' => 'fileupload',
            'display' => true,
            'size' => 5000000,
            'acept' => '*'
        ],
        [
            'name' => 'banner_title',
            'required' => true,
            'column' => 7,
            'label' => 'Banner Title',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'banner_description',
            'required' => false,
            'column' => 7,
            'label' => 'Banner Description',
            'type' => 'textarea',
            'display' => true
        ],
        [
            'name' => 'banner_link',
            'required' => false,
            'column' => 7,
            'label' => 'Banner Link',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'banner_position',
            'required' => false,
            'column' => 2,
            'label' => 'Banner Position',
            'type' => 'select',
            'options' => [
                'start' => 'Left',
                'center' => 'Middle',
                'end' => 'Right',
            ],
            'display' => true
        ],
    ];

    protected $fillable = [
        'id',
        'banner_image',
        'banner_title',
        'banner_description',
        'banner_link',
    ];

    protected $reference = [
        'banner_image'
    ];

    protected $filesList = [
        'banner_image'
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

    public function banner_image()
    {
        return $this->belongsTo(Files::class, 'banner_image', 'code');
    }
}
