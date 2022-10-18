<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $access_tokens = array(
            array('id' => '1', 'tokenable_type' => 'App\\Models\\User', 'tokenable_id' => '2', 'name' => 'secret', 'token' => 'c17ca423b3f7db69ab8011546f79b1d81fbbc594521d27767439133f5d9edbc2', 'abilities' => '["*"]', 'last_used_at' => '2022-10-06 21:26:11', 'expires_at' => NULL, 'created_at' => '2022-09-26 18:04:16', 'updated_at' => '2022-10-06 21:26:11')
        );

        foreach ($access_tokens as $token) {
            DB::table('personal_access_tokens')->insert($token);
        }
    }
}
