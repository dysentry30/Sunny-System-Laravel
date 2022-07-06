<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\faqs>
 */
class FaqsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "judul" => $this->faker->realText(30),
            "deskripsi" => $this->faker->text(220),
            "faq_attachment" => $this->faker->uuid().".docx",
        ];
    }
}
