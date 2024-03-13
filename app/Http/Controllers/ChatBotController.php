<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function ask(Request $request)
    {
        $apiKey = env('OPENAI_API_KEY');
        $message = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json'
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ["role" => "assistant", "content" => "You are a helpful assistant SimmyBot for Mentorship Program."],
                ["role" => "user", "content" => $message]
            ],
            'temperature' => 0.3,
            'max_tokens' => 256,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0
        ]);

        $data = $response->json();
        $reply = $data['choices'][0]['message']['content'];

        return response()->json(['reply' => $reply]);
    }
}
