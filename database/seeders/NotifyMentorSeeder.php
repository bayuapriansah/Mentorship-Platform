<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotifyMentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notify_mentors')->insert([
            'id_mentors' => 26,
            'notify_mentors_data' => json_encode([
                "notification" => [
                    [
                        "type" => "newSubmission",
                        "isRead" => 0,
                        "idNotify" => 1,
                        "idStudent" => 317,
                        "studentName" => "Bayu Apriansah",
                        "idProject" => 1,
                        "projectName" => "eAuto - Level 3",
                        "idTask" => 3,
                        "taskTitle" => "Model Building",
                        "idSubmission" => 3533,
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "statusSubmission" => "new",
                    ],
                    [
                        "type" => "newSubmission",
                        "isRead" => 0,
                        "idNotify" => 2,
                        "idStudent" => 317,
                        "studentName" => "Bayu Apriansah",
                        "idProject" => 3,
                        "projectName" => "eAuto - Level 3",
                        "idTask" => 3,
                        "taskTitle" => "Model Building",
                        "idSubmission" => 3533,
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "statusSubmission" => "revision",
                    ]
                ]
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
