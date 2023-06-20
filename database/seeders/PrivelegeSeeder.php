<?php

namespace Database\Seeders;

use App\Models\Priveleges;
use Illuminate\Database\Seeder;

class PrivelegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listNameSpaces = [
            'list',
            'create',
            'edit',
            'detail',
            'trash',
            'delete',
            'trashed',
            'restore',
            'export'
        ];

        $users = [
            'activation',
            'update_profile',
            'profile-detail',
            'reset_password'
        ];

        $data = [
            [
                'group' => 'MASTER DATA',
                'sub_modul' => [
                    'user',
                    'sysparams'
                ]
            ],
            [
                'group' => 'ROLE MANAGEMENT',
                'sub_modul' => [
                    'role',
                    'priveleges'
                ]
            ]
        ];

        for ($i = 0; $i < count($data); $i++) {
            $group = $data[$i]['group'];
            $subModule = $data[$i]['sub_modul'];
            for ($x = 0; $x < count($subModule); $x++) {
                $namespace = $listNameSpaces;
                if($subModule[$x] === 'user') $namespace = array_merge($namespace, $users);
                $count = 1;
                for ($y = 0; $y < count($namespace); $y++) {
                    $dataPrivileges = [
                        'module' => $group,
                        'sub_module' => strtoupper($subModule[$x]),
                        'module_name' => ucwords(str_replace(['-', '_'], ' ', $namespace[$y])) . ' ' . ucwords(str_replace(['-', '_'], ' ', $subModule[$x])),
                        'namespace' => $subModule[$x] . '.' . $namespace[$y],
                        'ordering' => $count++
                    ];

                    Priveleges::create($dataPrivileges);
                }
            }
        }
    }
}
