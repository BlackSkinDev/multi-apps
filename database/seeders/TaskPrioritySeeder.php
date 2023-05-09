<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task_priorities = [
            ['name'=>'Low'],
            ['name'=>'Medium'],
            ['name'=>'High'],
        ];

        TaskPriority::insert($task_priorities);
    }
}
