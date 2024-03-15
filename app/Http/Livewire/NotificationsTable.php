<?php

namespace App\Http\Livewire;

use App\Models\Submission;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsTable extends Component
{
    use WithPagination;

    public $limit = 10;

    public function render()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate(5);
        return view('livewire.notifications-table', [
            'submissions' => $this->getSubmissions(), "notifications" => $notifications
        ]);
    }
    function addnotif()
    {
        $time = time();
        $data = [
            "type" => 1,
            "title" => "Hello $time",
            "message" => "Hello world",
            "url" => "https://google.com",
        ];
        // Notification::send(Auth::user(), new TestNotification($data));
        auth()->user()->notify(new TestNotification($data));
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getSubmissions()
    {
        $user = null;
        $userType = null;

        $guards = [
            'web' => 'user',
            'mentor' => 'mentor',
            'customer' => 'customer',
        ];

        foreach ($guards as $guard => $type) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $userType = $type;

                break;
            }
        }

        if (!$user) {
            return collect();
        }

        $query = Submission::query()
            ->where('is_complete', 1)
            ->whereNotIn('id', function ($q) use ($user) {
                $q->select('submission_id')
                    ->from('read_notifications')
                    ->where('type', 'submissions')
                    ->where('is_read', 1)
                    ->where('user_id', $user->id);
            });


        if ($userType === 'mentor') {
            $query = $query->whereHas('student', function ($q) use ($user) {
                $q->where('mentor_id', $user->id);
            });
        }

        if ($userType === 'customer') {
            $query = $query->whereHas('project', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        }

        return $query->paginate($this->limit);
    }
}
