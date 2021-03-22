<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'number_of_ghosts' => $this->faker->numberBetween(0, 10),
            'phone_number' => $this->faker->numerify('###-###-####'),
            'phone_verified_at' => now(),
            'username' => $this->faker->userName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'sexuality' => $this->faker->randomElement(['Straight', 'Bisexual', 'Gay']),
            'looking_for' => $this->faker->randomElement(['anything', 'serious', 'friendship', 'fun']),
            'likes' => $this->faker->sentence(10),
            'about_me' => $this->faker->paragraph(4, true),
            'birthdate' => $this->faker->dateTimeThisCentury()->format('Y-m-d'),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
