<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'fullname' => $this->faker->name(),
            'gender'   => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'password' => bcrypt('password123'), // Default password for all
            'phone'    => $this->faker->unique()->phoneNumber(),
            'address'  => $this->faker->address(),
            'position' => $this->faker->jobTitle(),
        ];
    }
}
