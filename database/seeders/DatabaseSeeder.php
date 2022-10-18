<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            PersonnelStatusSeeder::class,
            BuildingSeeder::class,
            TypeRoomSeeder::class,
            EquipmentStatusSeeder::class,
            SubjectsSeeder::class,
            PersonnelsSeeder::class,
            RoomsSeeder::class,
            EquipmentSeeder::class,
            UserSeeder::class,
            MaterialsSeeder::class,
            UserTokenSeeder::class,
            ProjectLibrarySeeder::class,
        ]);
    }
}
