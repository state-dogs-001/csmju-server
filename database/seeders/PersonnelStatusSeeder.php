<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PersonnelStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personnel_status')->insert([
            [
                'status' => 'ทำงานปกติ',
            ],
            [
                'status' => 'ลาศึกษาต่อ',
            ],
            [
                'status' => 'ลาออก',
            ],
            [
                'status' => 'เกษียณอายุ',
            ],
            [
                'status' => 'ย้ายคณะ/ย้ายสาขา',
            ],
            [
                'status' => 'อาจารย์พิเศษ',
            ],
            [
                'status' => 'เสียชีวิต',
            ],
            [
                'status' => 'อื่นๆ',
            ]
        ]);
    }
}
