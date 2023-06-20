<?php

namespace Database\Seeders;

use App\Models\Sysparams;
use Illuminate\Database\Seeder;

class SysparamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'Gender' => collect([
                [
                    'code' => 'Male',
                    'value' => 'Male'
                ],
                [
                    'code' => 'Famale',
                    'value' => 'Famale'
                ],
            ]),
            'Activation' => collect([
                [
                    'code' => 1,
                    'value' => 'Active'
                ],
                [
                    'code' => 2,
                    'value' => 'Not Active'
                ]
            ])
        ]);

        $collection->each(function ($value, $key) {
            for ($i=0; $i < count($value); $i++) { 
                $data = [
                    'groups'   => $key,
                    'key'      => $value[$i]['code'],
                    'value'    => $value[$i]['value'],
                    'ordering' => $i + 1
                ];
                
                Sysparams::create($data);
            }
        });
    }
}
