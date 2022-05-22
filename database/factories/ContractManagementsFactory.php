<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContractManagements>
 */
class ContractManagementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "id_contract"       => $this->faker->unique()->randomNumber(5, true),
            "project_id"      => $this->faker->unique()->randomNumber(6),
            "contract_proceed"  => $this->faker->randomElement(["Pelaksanaan", "Sudah Selesai"]),
            "contract_in"       => $this->faker->dateTime(),
            "stages"       => $this->faker->randomElement([1, 2, 3, 4, 5, 6]),
            "contract_out"      => $this->faker->dateTimeInInterval("+5 years", "0 days"),
            "value"             => $this->faker->randomNumber(9),
            "number_spk"        => $this->faker->randomNumber(9, true),
        ];
    }
}
