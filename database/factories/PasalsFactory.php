<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PasalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "tipe_pasal" => $this->faker->randomElement(["Pasal Tenaga Kerja", "Pasal Keuangan", "Pasal Perizinan"]),
            "pasal" => $this->faker->realText(100),
        ];
    }
}
