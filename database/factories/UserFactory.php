<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstNameFemale(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'username' => $this->faker->username(),
            'email_verified_at' => now(),
            'password' => $this->faker->password(),
            'slug' => $this->faker->slug(),
            'github' => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
            'facebook' => $this->faker->url(),
            'website' => $this->faker->url(),
            'job_title' => $this->faker->jobTitle(),
            'photo' => $this->faker->imageUrl(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'vendor_shop_name' => $this->faker->company,
            'vendor_short_info' => $this->faker->sentence,
            'remember_token' => $this->faker->sha256,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
