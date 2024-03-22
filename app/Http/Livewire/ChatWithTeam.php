<?php

namespace App\Http\Livewire;

use App\Models\TeamChat;
use Livewire\Component;

class ChatWithTeam extends Component
{
    public $chats, $message;
    public $team_name;
    function mount()
    {
        $this->getChat();
    }
    public function render()
    {
        return view('livewire.chat-with-team');
    }

    function getChat()
    {
        $this->chats = TeamChat::with("admin", "mentor", "student")->where("team_name", $this->team_name)->orderBy("created_at", "asc")->get();
    }
    function sendMessage()
    {
        try {
            TeamChat::create([
                "team_name" => $this->team_name,
                "message" => $this->message,
                "sender_id" => auth()->user()->id,
                "type" => "text",
                "sender_type" => getRole(),
            ]);
            $this->message = null;
            $this->getChat();
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
