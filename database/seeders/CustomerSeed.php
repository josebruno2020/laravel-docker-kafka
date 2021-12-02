<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCustomer(name: 'José Bruno', email: 'jose@bruno.com');
        $this->createCustomer(name: 'André Missão', email: 'andrea@missao.com');
    }

    private function createCustomer(string $name, string $email): Customer
    {
        return Customer::create(
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }
}
