<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        \App\Models\User::factory()->count(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);

        \App\Models\User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => null,
            'email_verified_at' => null,
            'password' => Hash::make('password')
        ]);

        
    }
        
        
}
