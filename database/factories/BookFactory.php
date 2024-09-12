<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(fake()->randomDigitNotNull()),
            'description' => fake()->paragraph(),
            'publish_date' => Carbon::now()->format('Y-m-d'),
            'author_id' => Author::factory(),
        ];
    }
}
