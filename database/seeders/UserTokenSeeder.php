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
            array('id' => '1', 'tokenable_type' => 'App\\Models\\User', 'tokenable_id' => '1', 'name' => 'anonymous58', 'token' => '0e001af967e586e461b25259fd7f70d1cda1515136beefa0f373efe59d07bfcb', 'abilities' => '["*"]', 'last_used_at' => '2022-12-28 15:50:28', 'expires_at' => NULL, 'created_at' => '2022-12-28 15:49:36', 'updated_at' => '2022-12-28 15:50:28')
        );

        foreach ($access_tokens as $token) {
            DB::table('personal_access_tokens')->insert($token);
        }
    }
}
