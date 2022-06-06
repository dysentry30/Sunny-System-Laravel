<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company(),
            "email" => $this->faker->email(),
            "phone_number"=> $this->faker->phoneNumber(),
            "address_1" => $this->faker->address(),
            "address_2" => $this->faker->address(),
            "website" => $this->faker->text(12),
            "check_customer" => $this->faker->boolean(),
            "check_partner" => $this->faker->boolean(),
            "check_competitor" => $this->faker->boolean(),
            
            //faker company
            "jenis_instansi" => $this->faker->randomElement(["BUMN", "BUMND", "APBN", "Swasta", "Investasi"]),
            "journey_company" => $this->faker->randomElement(["Customer", "Loyal", "Advocate"]),
            "segmentation_company" => $this->faker->randomElement(["Silver", "Gold", "VIP"]),
            "kode_proyek" => $this->faker->unique()->randomNumber(6),
            "npwp_company" => $this->faker->randomNumber(9),
            "kode_nasabah" => $this->faker->randomNumber(6),
            
            //faker pic
            "name_pic" => $this->faker->unique()->name(),
            "kode_pic" => $this->faker->unique()->randomNumber(4),
            "email_pic" => $this->faker->email(),
            "phone_number_pic" => $this->faker->phoneNumber(),
            
            //faker performance
            "nilaiok" => $this->faker->randomNumber(7),
            "piutang" => $this->faker->randomNumber(7),
            "laba" => $this->faker->randomNumber(7),
            "rugi" => $this->faker->randomNumber(7),
            
            //faker note
            "note_attachment" => $this->faker->text(100),
            
        ];
    }
}
