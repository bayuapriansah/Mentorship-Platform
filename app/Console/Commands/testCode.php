<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Grade;
use App\Models\Project;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Submission;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;
use Illuminate\Support\Facades\Hash;

class testCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        // $newMessage = Submission::where('student_id',14)->get();
        // foreach ($newMessage as $mesd) {
        //     // print_r($mesd->grade->submission);
        //     dd($mesd->grade->readornot);

        // }
        // dd($newMessage);
        // return $notif;
        // $notifActivity = Submission::withCount('grade')->where('student_id', 14)->get();
        // $submissions = Submission::select('submissions.id as submission_id', 'students.id as student_id')
        // ->join('grades', 'submissions.id', '=', 'grades.submission_id')
        // ->join('students', 'submissions.student_id', '=', 'students.id')->where('student_id', 14)
        // ->get();
        // dd($encrypted = Hash::make('administrator'));
        // dd($encrypted);

        // $student_id = 1;
        // $notif = Notification::get();
        // dd($notif->count());

    //     $notifActivity = $this->all_notif_new_task();
    //     // $nop = [];
    //     // foreach($notifActivity as $no){
    //     //     $nop[] = $no->project;
    //     // }
    //     dd($notifActivity);
    //     // dd(count($nop));
    //     // dd($notif->count() + $notifActivityCount);
    // }
    // public function count_total_all_notification_available(){
    //     $notif = Notification::get();

    //     return $notif;
    // }

    // public function all_notif_new_task(){
    //     return $this->count_total_all_notification_available();
    // }

        // $newMessage = Comment::where('student_id', 11)
        // ->where('read_message', 0)
        // ->whereIn('user_id', [!null])
        // ->orWhereIn('mentor_id', [!null])
        // ->orWhereIn('customer_id', [!null])
        // ->get();

        // dd($newMessage);
        $data[] = (object)array(
            "id" => 1,
            "product_id" => 101,
            "month" => "January",
            "year" => 2022,
            "quantity" => 50,
            "product_name" => "Product A",
            "next_x" => 1.5,
            "_x" => 3,
            "_y" => 200,
            "_xx" => 15,
            "_xy" => 750,
            "peramalan" => 100,
        );
        
        // Second array of data
        $data[] = (object)array(
            "id" => 2,
            "product_id" => 102,
            "month" => "February",
            "year" => 2022,
            "quantity" => 60,
            "product_name" => "Product B",
            "next_x" => 2.5,
            "_x" => 6,
            "_y" => 300,
            "_xx" => 35,
            "_xy" => 1500,
            "peramalan" => 120,
        );
        
        // Third array of data
        $data[] = (object)array(
            "id" => 3,
            "product_id" => 103,
            "month" => "March",
            "year" => 2022,
            "quantity" => 70,
            "product_name" => "Product C",
            "next_x" => 3.5,
            "_x" => 9,
            "_y" => 400,
            "_xx" => 55,
            "_xy" => 2100,
            "peramalan" => 150,
        );
        
        // Fourth array of data
        $data[] = (object)array(
            "id" => 4,
            "product_id" => 104,
            "month" => "April",
            "year" => 2022,
            "quantity" => 80,
            "product_name" => "Product D",
            "next_x" => 4.5,
            "_x" => 12,
            "_y" => 500,
            "_xx" => 85,
            "_xy" => 3000,
            "peramalan" => 180,
        );
        
        $_n = count($data);
		$_mid = $_n / 2;

		$sum_x 		= 0;
		$sum_y 		= 0;
		$sum_xx 	= 0;
		$sum_xy 	= 0;
		$sum_peramalan = 0;
		$sum_error = 0;
		$sum_abs = 0;
		$sum_error_accent = 0;
		$sum_ape = 0;
        $lkkl = 1;
		for ($i = 0, $_x = ($_mid * 2 - 1) * -1; $_x <= ($_mid * 2 - 1), $i < $_n; $_x += 2, $i++) {
			$sum_x += $_x;
			$sum_y += $data[$i]->_y;
			$sum_xx += ($_x * $_x);
			$sum_xy += ($_x * $data[$i]->_y);

			// disini ngambil total dari x dan y
			$_ax 	= $sum_y / $_n;
			$_bx 	= $sum_xy / $sum_xx;
            echo ". ";
            echo $lkkl;
            echo ".Nilai $_ax = ";
            echo $_ax;
            echo " & " ;
            echo "Nilai $_ax = ";
            echo $_bx;
            $lkkl = $lkkl + 1 ;
			$data[$i]->_x = $_x;
			$data[$i]->_xx = ($_x * $_x);
			$data[$i]->_xy = ($_x * $data[$i]->_y);
			// $data[$i]->peramalan = (72083.33333) + -386.3636364 * $_x;
			$data[$i]->peramalan = $_ax + $_bx * $_x;
			$data[$i]->error = $data[$i]->peramalan - $data[$i]->_y;
			$data[$i]->abs_error = abs($data[$i]->error);
			$data[$i]->error_accent = $data[$i]->error * $data[$i]->error;
			$data[$i]->ape = $data[$i]->abs_error / $data[$i]->_y * 100;

			$sum_error += $data[$i]->error;
			$sum_abs += $data[$i]->abs_error;
			$sum_error_accent += $data[$i]->error_accent;
			$sum_ape += $data[$i]->ape;

			$sum_peramalan = $sum_xy / $sum_xx . ' capek';
		}
    }
}
