<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project    = Project::inRandomOrder()->first();
        $task       = Task::inRandomOrder()->where('project_id',$project->id)->first() ?? Task::factory()->create(['project_id' => $project->id]);
        $user       = User::inRandomOrder()->where('company_id',$project->company_id)->first() ?? User::factory()->create(['company_id' =>$project->company_id]);


        return [
            'task_id'      => $task->id,
            'user_id'      => $user->id,
            'comment_text' => fake()->text(20),

        ];
    }
}
