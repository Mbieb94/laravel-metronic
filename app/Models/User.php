<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $rules = [
        'fullname' => ['required', 'string', 'max:255'],
        'username' => ['required', 'unique'],
        'email' => ['required', 'unique']
    ];

    protected $createRules = [
        'password' => ['required', 'confirmed'],
    ];

    protected $fillable = [
        'id',
        'photo',
        'fullname',
        'username',
        'email',
        'gender',
        'address',
        'phone_number',
        'password'
    ];

    protected $forms = [
        [
            'name' => 'photo',
            'required' => false,
            'column' => 3,
            'label' => 'Photo',
            'type' => 'thumbnail',
            'display' => false
        ],
        [
            'name' => 'fullname',
            'required' => true,
            'column' => 3,
            'label' => 'Full Name',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'username',
            'required' => true,
            'column' => 3,
            'label' => 'Username',
            'type' => 'text',
            'display' => false
        ],
        [
            'name' => 'email',
            'required' => true,
            'column' => 3,
            'label' => 'Email',
            'type' => 'email',
            'display' => true
        ],
        [
            'name' => 'gender',
            'required' => true,
            'column' => 2,
            'label' => 'Gender',
            'type' => 'sysparam',
            'options' => [
                'key' => 'key',
                'display' => 'value',
                'group' => 'Gender'
            ],
            'display' => true
        ],
        [
            'name' => 'address',
            'required' => false,
            'column' => 5,
            'label' => 'Address',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'phone_number',
            'required' => true,
            'column' => 3,
            'label' => 'Phone Number',
            'type' => 'text',
            'display' => true
        ],
        [
            'name' => 'password',
            'required' => true,
            'column' => 6, // max 9
            'label' => 'Password',
            'type' => 'password',
            'display' => false
        ],
        [
            'name' => 'status',
            'required' => true,
            'column' => 2,
            'label' => 'Status',
            'type' => 'sysparam',
            'options' => [
                'key' => 'key',
                'display' => 'value',
                'group' => 'Activation'
            ],
            'hidden' => true,
            'display' => true
        ],
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $reference = [
        'status',
        'gender',
        'roles',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRules()
    {
        return $this->rules;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getFields()
    {
        return $this->fillable;
    }

    public function getForms()
    {
        return $this->forms;
    }

    public function getTableName()
    {
        return $this->table;
    }

    public function checkTableExists($table_name)
    {
        return Schema::hasTable($table_name);
    }

    public function getTableFields()
    {
        return Schema::getColumnListing($this->getTable());
    }

    public function getFilesList()
    {
        return [];
    }

    public function status()
    {
        return $this->belongsTo(Sysparams::class, 'status', 'key')
            ->withTrashed()
            ->where('groups', 'Activation');
    }

    public function updateRules()
    {
        return false;
    }

    public function createRules()
    {
        return $this->createRules;
    }

    public function gender()
    {
        // dd();
        return $this->belongsTo(Sysparams::class, 'gender', 'key')
            ->withTrashed()
            // ->where('key', self::get()->first()->gender)
            ->where('groups', 'Gender');
    }

    public function roles()
    {
        return $this->hasMany(RoleUsers::class, 'users_id', 'id')->with('roles_id');
    }

    public function userRoles () {
        return $this->hasMany(RoleUsers::class, 'users_id', 'id')
            ->whereIn('roles_id', [3,4]);
    }

    public function userAttempts () {
        return $this->hasMany(Logs::class, 'created_by', 'id')
            ->where('url', env('APP_URL', 'http://localhost') . ':' . env('APP_PORT', 8000) . '/login');
    }

    public function lastLogin () {
        return $this->hasOne(Logs::class, 'created_by', 'id')
        ->where('url', env('APP_URL', 'http://localhost') . ':' . env('APP_PORT', 8000) . '/login')
        ->orderBy('id', 'desc');
    }
}
