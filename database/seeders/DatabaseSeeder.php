<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ProjectDevStageSeeder::class
         ]);
         \App\Models\Project::factory(10)->create();
         \App\Models\User::factory(10)->create();
         \App\Models\Task::factory(20)->create();

    }
}
