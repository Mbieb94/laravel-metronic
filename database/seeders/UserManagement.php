<?php

namespace Database\Seeders;

use App\Models\Priveleges;
use App\Models\RolePriveleges;
use App\Models\Roles;
use App\Models\RoleUsers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserManagement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            'name' => 'Developers'
        ];

        Roles::create($role);

        $privilege = [
            'module' => 'DEVELOPER',
            'sub_module' => 'ALL ACCESS',
            'module_name' => 'All Access',
            'namespace' => '*',
            'ordering' => 1
        ];

        Priveleges::create($privilege);

        $rolePrivilege = [
            'role' => '1',
            'namespace' => '*'
        ];

        RolePriveleges::create($rolePrivilege);
    }
}
