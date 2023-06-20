<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'logs';

    protected $rules = [
        'method' => ['required', 'string'],
        'method' => ['request', 'string'],
        'method' => ['response', 'string'],
    ];

    protected $forms = [
        [
            'name' => 'method',
            'required' => true,
            'column' => 3,
            'label' => 'Method',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'request',
            'required' => true,
            'column' => 5,
            'label' => 'Request',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'response',
            'required' => true,
            'column' => 5,
            'label' => 'Response',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'url',
            'required' => true,
            'column' => 5,
            'label' => 'URL',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'ip',
            'required' => true,
            'column' => 5,
            'label' => 'IP Address',
            'type' => 'text',
            'display' => true
        ],
    ];

    protected $fillable = [
        'id',
        'method',
        'request',
        'response',
        'url',
        'ip',
    ];

    public function getRules()
    {
        return $this->rules;
    }

    public function getFields()
    {
        return $this->fillable;
    }
}
