<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProyekBerjalan>
 */
class ProyekBerjalanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nama_proyek" => $this->faker->address(15),
            "kode_proyek" => 12345,
            "unit_kerja" => $this->faker->company()    ,
            "nama_pic" => $this->faker->name(),
            "nilaiok_proyek" => $this->faker->randomNumber(7),
        ];
    }
}
