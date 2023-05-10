<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectDevStage>
 */
class ProjectDevStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $default_stages = ['To Do','In Progress','In Review','In Testing','Testing Failed','Done'];

        return [
            'name'          => Arr::random($default_stages),
            'project_id'    => Project::inRandomOrder()->first()->id
        ];
    }
}
