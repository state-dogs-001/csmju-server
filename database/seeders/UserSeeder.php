<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('id' => '1', 'personnel_id' => '58', 'role' => 'token', 'remember_token' => NULL, 'created_at' => '2022-12-28 15:48:58', 'updated_at' => '2022-12-28 15:48:58'),
            array('id' => '2', 'personnel_id' => '20', 'role' => 'admin', 'remember_token' => NULL, 'created_at' => '2022-12-28 15:49:22', 'updated_at' => '2022-12-28 15:49:22')
        );

        //? Insert $users to table
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
