<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StaticPageSeeder::class);

        // Create Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'dheerajagarwal1995@gmail.com'],
            [
                'name' => 'Dheeraj Agarwal',
                'password' => \Illuminate\Support\Facades\Hash::make('good best'),
            ]
        );
    }
}
