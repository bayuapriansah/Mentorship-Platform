<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotifyStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notify_students')->insert([
            'id_students' => 317,
            'notify_data' => json_encode([
                "notification" => [
                    [
                        "type" => "newProject",
                        "idNotify" => 1,
                        "idProject" => 3,
                        "projectName" => "eAuto - Level 1",
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "isRead" => 0
                    ],
                    [
                        "type" => "newGrading",
                        "idNotify" => 2,
                        "idProject" => 3,
                        "idSection" => 12,
                        "titleSection" => "Data Pipeline",
                        "message" => "You Pass",
                        "statusGrading" => "pass",
                        "graderName" => "Mentor",
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "isRead" => 0
                    ],
                    [
                        "type" => "newProject",
                        "idNotify" => 3,
                        "idProject" => 4,
                        "projectName" => "eAuto - Level 2",
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "isRead" => 0
                    ],
                    [
                        "type" => "newGrading",
                        "idNotify" => 4,
                        "idProject" => 3,
                        "idSection" => 13,
                        "titleSection" => "Data NLP",
                        "message" => "You need to revise the answer",
                        "statusGrading" => "revision",
                        "graderName" => "Mentor",
                        "created_at" => "2024-03-13T09:25:48.000000Z",
                        "isRead" => 0
                    ]
                ]
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
