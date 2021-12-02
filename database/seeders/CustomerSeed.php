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
        $this->createCustomer('José Bruno', 'jose@bruno.com');
        $this->createCustomer('André Missão', 'andrea@missao.com');
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
