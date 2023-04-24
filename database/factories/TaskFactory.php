<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectDevStage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::inRandomOrder()->first();

        return [
            'title'                 => $title = fake()->unique()->text(10),
            'description'           => fake()->text(100),
            'project_id'            => $project->id,
            'project_dev_stage_id'  => ProjectDevStage::inRandomOrder()->first()->id,
            'user_id'               => User::inRandomOrder()->first()->id,
            'reference'             => (strtoupper(substr($project->name,0,3)))."-".mt_rand(1000,2000)
        ];
    }
}
