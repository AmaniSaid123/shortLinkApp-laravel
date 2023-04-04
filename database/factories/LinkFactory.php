<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
     
        return [
            'url' => 'https://www.w3schools.com',
            'short_url' => Str::random(6),
            'user_id' => 1,
            'expires_at' => now()->addDay()
        ];
    }
}
