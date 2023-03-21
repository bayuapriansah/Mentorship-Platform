<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Customer;
use App\Models\ReadNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CommentReadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $injection;
    protected $participant;
    protected $roleUserId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($injection, $participant,$roleUserId)
    {
        $this->injection = $injection;
        $this->participant = $participant;
        $this->roleUserId = $roleUserId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $readMessageProjectSections = Comment::where(['project_section_id' => $this->injection->id,'student_id' => $this->participant->id,'user_id' => null,'mentor_id' => null,'customer_id' => null,])->get();
        $readAllDataMessage = Comment::where('project_section_id', $this->injection->id)
            ->where('student_id', $this->participant->id)
            ->whereNull('user_id')
            ->whereNull('mentor_id')
            // ->whereNull('customer_id')->get();
            ->whereNull('customer_id')
            ->update(['read_message' => 1]);

        $guard = Auth::getDefaultDriver();

        foreach ($readMessageProjectSections as $readMessageProjectSection) {
            $studentId = $readMessageProjectSection->student_id;
            $commentsId = $readMessageProjectSection->id;

            $existingRecord = ReadNotification::where('student_id', $studentId)
                ->where('comments_id', $commentsId)
                ->first();

            if (!$existingRecord) {
                $readNotification = new ReadNotification;
                $readNotification->student_id = $studentId;
                $readNotification->comments_id = $commentsId;

                switch ($guard) {
                    case 'web':
                        $readNotification->user_id = $this->roleUserId;
                        break;
                    case 'mentor':
                        $readNotification->mentor_id = $this->roleUserId;
                        break;
                    case 'customer':
                        $readNotification->customer_id = $this->roleUserId;
                        break;
                }

                $readNotification->type = 'comments';
                $readNotification->is_read = 1;
                $readNotification->save();
            }
        }
    }
}
