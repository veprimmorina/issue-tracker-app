<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(Issue::statuses()),
            'priority' => $this->faker->randomElement(Issue::priorities()),
            'due_date' => $this->faker->optional()->date(),
        ];
    }
}
