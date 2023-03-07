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
        DB::unprepared('DROP TRIGGER IF EXISTS `new_sections_trigger`');
        DB::unprepared('
            CREATE TRIGGER `new_sections_trigger` AFTER INSERT ON `project_sections` FOR EACH ROW
            BEGIN
                DECLARE releases_date DATE;              
                DECLARE taskNombre INT;
                DECLARE section_ids INT;
                DECLARE student_ids INT;
                DECLARE duration_day INT;
                DECLARE done INT DEFAULT FALSE;
                -- this will be, get value id_students who already enrolled this project so we will add the students also
                DECLARE id_students CURSOR FOR SELECT DISTINCT student_id FROM submissions WHERE project_id = NEW.project_id;
                -- this will be, get collection value of release_date from submissions;
                DECLARE releases_date_old CURSOR FOR SELECT release_date FROM submissions WHERE project_id=NEW.project_id AND section_id=(SELECT MAX(section_id) FROM submissions WHERE project_id=NEW.project_id);
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                -- this is for get id from table project_sections and put it into table submission and become section_id
                SELECT max(id) INTO section_ids FROM project_sections WHERE project_id = NEW.project_id;
                -- To get latest Task number
                SELECT max(section) INTO taskNombre FROM project_sections WHERE project_id = NEW.project_id;
                -- Get the duration day from the before latest section/task
                SELECT duration INTO duration_day FROM project_sections WHERE project_id = NEW.project_id ORDER BY id DESC LIMIT 1,1;

                OPEN id_students;
                OPEN releases_date_old;
                loop_sections: LOOP
                FETCH id_students INTO student_ids;
                FETCH releases_date_old INTO releases_date;
                IF done THEN
                    LEAVE loop_sections;
                END IF;
                INSERT INTO submissions (section_id, student_id, project_id, is_complete, release_date, taskNumber, created_at, updated_at)
                VALUES (section_ids, student_ids, NEW.project_id, 0, DATE_ADD(releases_date,INTERVAL duration_day DAY), taskNombre, NOW(), NOW());
                END LOOP;

                CLOSE id_students;
                CLOSE releases_date_old;
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
        DB::unprepared('DROP TRIGGER IF EXISTS `new_sections_trigger`');
    }
};
