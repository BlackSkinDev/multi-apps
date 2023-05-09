<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user    = User::inRandomOrder()->first() ?? User::factory()->create();
        return [
            'name'              => fake()->unique()->text(7),
            'description'       => fake()->text(7),
            'company_id'        => $user->company_id,
            'project_lead_id'   => $user->id
        ];
    }
}
