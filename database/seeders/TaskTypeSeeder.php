<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task_priorities = [
            ['name'=>'Bug'],
            ['name'=>'Story'],
            ['name'=>'Task'],
        ];

        TaskType::insert($task_priorities);
    }
}
