<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Student;
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
            'email' => 'admin@mail.com',
        ]);

        Company::create([
            'name' => fake()->name(),
            'email' => 'company@mail.com',
            'address' => fake()->address(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_confirm' => 1
        ]);

        Student::create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'gender' => 'male',
            'state' => 'medan',
            'country' => 'indonesia',
            'is_confirm' => 1
        ]);
        \App\Models\Project::create([
            'name' => 'First Project ',
            'project_domain' => 'nlp',
            'problem' => 'first project problem',
            'company_id' => '1',
            'status' => 'publish',
            'resources' => 'dummy_link',
            'valid_time' => 7,
        ]);
    }
}
