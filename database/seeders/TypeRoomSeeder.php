<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_rooms')->insert([
            [
                'type_room' => 'ห้องปฏิบัติการ',
            ],
            [
                'type_room' => 'ห้องบรรยาย',
            ],
            [
                'type_room' => 'ห้องอื่นๆ',
            ]
        ]);
    }
}
