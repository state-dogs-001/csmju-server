<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipment_status')->insert([
            ['status' => 'ดี'],
            ['status' => 'ชำรุด'],
            ['status' => 'โอนย้าย'],
            ['status' => 'แปรสภาพ'],
            ['status' => 'จำหน่าย'],
        ]);
    }
}
