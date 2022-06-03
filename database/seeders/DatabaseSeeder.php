<?php

namespace Database\Seeders;

use App\Models\Pasals;
use App\Models\Customer;
use App\Models\DraftContracts;
use Illuminate\Database\Seeder;
use App\Models\ContractManagements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        ContractManagements::factory(5)->create();
        Pasals::factory(5)->create();
        Customer::factory(6)->create();
        // DraftContracts::factory(5)->create();
    }
}
