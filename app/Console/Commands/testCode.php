<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Grade;
use App\Models\Project;
use App\Models\Student;
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
        $notif = "hai";
        $newMessage = Grade::where('student_id',14)->where('read_message',0)->where('mentor_id',!NULL)->get();
        dd($newMessage);
        // return $notif;
    }
}
