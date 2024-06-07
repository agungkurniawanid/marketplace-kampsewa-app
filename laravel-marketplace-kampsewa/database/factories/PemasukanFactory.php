<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemasukan>
 */
class PemasukanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => $this->faker->numberBetween(1, 500),
            'sumber' => $this->faker->randomElement(['Iklan', 'Transaksi Penyewaan', 'Modal']),
            'deskripsi' => $this->faker->sentence,
            'nominal' => $this->faker->numberBetween(1000000, 100000000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}