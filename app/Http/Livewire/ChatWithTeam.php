<?php

namespace App\Http\Livewire;

use App\Models\TeamChat;
use Livewire\Component;

class ChatWithTeam extends Component
{
    public $chats, $message;
    public $team_name;
    public function render()
    {
        $this->chats = TeamChat::where("team_name", $this->team_name)->orderBy("created_at", "asc")->get();
        return view('livewire.chat-with-team');
    }
    function sendMessage()
    {
        try {
            TeamChat::create([
                "team_name" => auth()->user()->team_name,
                "message" => $this->message,
                "sender_id" => auth()->user()->id,
                "type" => "text",
                "sender_type" => getRole(),
            ]);
            $this->message = null;
        } catch (\Throwable $th) {
        }
    }
}
