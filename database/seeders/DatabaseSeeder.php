<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        Manufacturer::factory()->create([
            'name'=> 'Test Manufacturer'
        ]);

        Product::factory()->create([
            'name' => 'Test product',
            'price' => 10,
            'manufacturer_id' => 1,
            'sku' => 1,
            'description' => 'test description'
        ]);
    }
}
