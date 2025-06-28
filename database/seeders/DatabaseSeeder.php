<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    //php artisan db:seed
    //php artisan migrate:refresh --seed
    public function run(): void
    {
        Storage::deleteDirectory('products');
        Storage::makeDirectory('products');
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jesus Hdez',
            'email' => 'correo@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->call([FamilySeeder::class,OptionSeeder::class]);
        Product::factory(50)->create();
    }
}
