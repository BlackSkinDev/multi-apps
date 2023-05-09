<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectDevStage;
use App\Models\TaskType;
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
        $project    = Project::inRandomOrder()->first();
        $company    = $project->company;
        $user       = User::inRandomOrder()->where('company_id',$company->id)->first() ?? User::factory()->create(['company_id' => $company->id]);
        $reporter   = User::inRandomOrder()->where('company_id',$company->id)->first() ?? User::factory()->create(['company_id' => $company->id]);


        return [
            'title'                 => fake()->unique()->text(10),
            'description'           => fake()->text(100),
            'project_id'            => $project->id,
            'project_dev_stage_id'  => ProjectDevStage::inRandomOrder()->first()->id,
            'user_id'               => $user->id,
            'reporter_id'           => $reporter->id,
            'task_type_id'          => TaskType::inRandomOrder()->first()->id,
            'task_priority_id'      => TaskType::inRandomOrder()->first()->id,
            'due_date'              => fake()->dateTime()
        ];
    }
}
