<?php

namespace Database\Seeders;

use App\Models\TbTypeResearch;
use Illuminate\Database\Seeder;

class TypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type = [
            [

                'type_name' => 'ชุมชนท้องถิ่น'
            ],
            [
                'type_name' => 'ศิลปวัฒนธรรม'
            ]
        ];

        foreach ($type as $key => $value) {
            TbTypeResearch::create($value);
        }
    }
}
