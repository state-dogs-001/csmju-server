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
            array('id' => '1', 'email' => 'chorthip_s@mju.ac.th', 'password' => '$2y$10$kHs9/0lYV8qeDDhz1zCU3OpTJAykldMxnR7Kg9t/Qu3Ncyr6u1uSi', 'citizen_id' => '3660800333836', 'role' => 'admin', 'email_verified_at' => NULL, 'remember_token' => NULL, 'created_at' => '2022-09-06 00:38:39', 'updated_at' => '2022-09-06 00:38:39'),
            array('id' => '2', 'email' => 'token@mju.ac.th', 'password' => '$2y$10$m20TNfQbABS26EAEb5L8E.YEyf4UCyJe4U.xMfKm4sY7w.4VTuUhe', 'citizen_id' => '1000000000000', 'role' => 'token', 'email_verified_at' => NULL, 'remember_token' => NULL, 'created_at' => '2022-09-06 00:39:28', 'updated_at' => '2022-09-06 00:39:28')
        );

        //? Insert $users to table
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
