<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;

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

        \App\Models\User::factory()->create([
            'name' => 'farhan',
            'email' => 'farhan@admin.com',
        ]);

        // Company::create([
        //     'name' => fake()->name(),
        //     'email' => 'company@mail.com',
        //     'address' => fake()->address(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'is_confirm' => 1
        // ]);
        // \App\Models\Project::create([
        //     'name' => 'First Project ',
        //     'problem' => 'create user admin',
        //     'image' => 'https://www.codingem.com/wp-content/uploads/2021/10/juanjo-jaramillo-mZnx9429i94-unsplash-2048x1365.jpg?ezimgfmt=ng%3Awebp%2Fngcb1%2Frs%3Adevice%2Frscb1-1',
        //     'batch_id' => 1
        // ]);
    }
}
