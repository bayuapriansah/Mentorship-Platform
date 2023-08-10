<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `enrolled_projects_trigger`');
        DB::unprepared('
            CREATE TRIGGER `enrolled_projects_trigger` AFTER INSERT ON `enrolled_projects` FOR EACH ROW
            BEGIN
                DECLARE releases_date DATE;
                DECLARE loop_day INT;
                DECLARE taskNombre INT;
                DECLARE section_id INT;
                DECLARE done INT DEFAULT FALSE;
                DECLARE cur_sections CURSOR FOR SELECT id FROM project_sections WHERE project_id = NEW.project_id;
                DECLARE duration_day CURSOR FOR SELECT duration FROM project_sections WHERE project_id = NEW.project_id;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                SET releases_date = CURDATE();
                SET taskNombre = 1;
                OPEN cur_sections;
                OPEN duration_day;
                loop_sections: LOOP
                FETCH cur_sections INTO section_id;
                FETCH duration_day INTO loop_day;
                IF done THEN
                    LEAVE loop_sections;
                END IF;
                INSERT INTO submissions (section_id, student_id, project_id, is_complete, release_date, taskNumber, created_at, updated_at)
                VALUES (section_id, NEW.student_id, NEW.project_id, 0, releases_date, taskNombre, NOW(), NOW());
                SET releases_date = DATE_ADD(releases_date,INTERVAL loop_day DAY);
                SET taskNombre = taskNombre + 1;
                END LOOP;

                CLOSE cur_sections;
                CLOSE duration_day;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `enrolled_projects_trigger`');
    }
};