<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buildings')->insert([
            [
                'building' => 'ตึก 60 ปี คณะวิทยาศาสตร์',
            ],
            [
                'building' => 'อาคารจุฬาภรณ์ คณะวิทยาศาสตร์',
            ],
            [
                'building' => 'อาคารเสาวรัจ นิตยวรรธนะ',
            ]
        ]);
    }
}
