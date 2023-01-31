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
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ]);

        Company::create([
            'name' => fake()->name(),
	    'email' => 'company@mail.com',
	    'logo' => 'image.jpg',
            'address' => fake()->address(),
        ]);

        Student::create([
            'first_name' => fake()->firstname(),
            'last_name' => fake()->lastname(),
            'email' => 'student@mail.com',
            'sex' => 'male',
            'state' => 'medan',
            'country' => 'indonesia',
            'is_confirm' => 1
        ]);
        // \App\Models\Project::create([
        //     'name' => 'First Project ',
        //     'project_domain' => 'nlp',
        //     'problem' => 'first project problem',
        //     'company_id' => '1',
        //     'status' => 'publish',
        //     'resources' => 'dummy_link',
        //     'valid_time' => 7,
        // ]);
    }
}
