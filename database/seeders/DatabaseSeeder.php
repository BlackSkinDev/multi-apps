<?php

namespace Database\Seeders;

use App\Models\ProjectDevStage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


         $this->call([
            AdminSeeder::class,
            TaskPrioritySeeder::class,
            TaskTypeSeeder::class,
         ]);

        \App\Models\Company::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Project::factory(10)->create();
        \App\Models\ProjectDevStage::factory(20)->create();
        \App\Models\Task::factory(20)->create();

    }
}
