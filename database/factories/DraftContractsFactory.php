<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DraftContractsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "draft_name" => $this->faker->text(25),
            "id_contract" => 34915,
            "draft_note" => $this->faker->text(50),
            "id_document" => $this->faker->unique()->randomNumber(9, true),
            "tender_menang" => $this->faker->boolean(),
        ];
    }
}
