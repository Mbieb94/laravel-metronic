<?php

namespace Database\Seeders;

use App\Models\RoleUsers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
      /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userLists = [
            [
                'photo'        => null,
                'fullname'   => 'Super Admin',
                'username'     => 'Super Admin',
                'email'        => 'superadmin@gmail.com',
                'gender'       => 'Male',
                'role'         => 'developer',
                'address'      => NULL,
                'phone_number' => NULL,
                'password'     => bcrypt('password')
            ],
        ];
    
        $roleList = [
            'developer'  => '1'
        ];
        
        for($i=0; $i < count($userLists); $i++) {
            $userRole = $roleList[str_replace(' ', '_', strtolower($userLists[$i]['role']))];
            unset($userLists[$i]['role']);
    
            $user = User::insertGetId($userLists[$i]);
    
            $roleUser = [
                'users_id' => $user,
                'roles_id' => $userRole
            ];
    
            RoleUsers::create($roleUser);
        }
    }
}
