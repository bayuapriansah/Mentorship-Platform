<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CleanedCommentController extends Controller
{
    public function getCleanedComments()
    {
        // Retrieve the data from the "comments" table
        $comments = Comment::select('id', 'student_id', 'project_id', 'project_section_id', 'read_message', 'mentor_id', 'staff_id', 'user_id', 'customer_id', 'message', 'created_at', 'updated_at')
            ->whereNotNull('message')
            ->get();

        // Clean the data
        foreach ($comments as $comment) {
            $comment->message = $this->cleanText($comment->message);
        }

        // Sort the data based on student_id, project_id, and project_section_id
        $sortedComments = $comments->sortBy(['student_id', 'project_id', 'project_section_id']);

        // Generate prompts and completions
        $results = [];
        $prompt = null;

        foreach ($sortedComments as $comment) {
            if (is_null($comment->mentor_id) && is_null($comment->staff_id) && is_null($comment->user_id) && is_null($comment->customer_id)) {
                $prompt = $this->cleanText($comment->message);
            } elseif (!is_null($prompt)) {
                $completion = $this->cleanText($comment->message);
                $results[] = [
                    'prompt' => $prompt,
                    'completion' => $completion
                ];
                $prompt = null;
            }
        }

        // Format the JSON response
        $formattedResponse = collect($results)->map(function ($item) {
            return json_encode($item, JSON_UNESCAPED_SLASHES);
        })->implode("\n");

        // Return the cleaned JSON response in the desired format
        return Response::make($formattedResponse, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    // Function to clean HTML tags, special characters, newlines, backslashes, and replace double quotes with single quotes in a text
    private function cleanText($text)
    {
        $cleanedText = str_replace(['<br>', '</br>'], ' ', $text);
        $cleanedText = strip_tags($cleanedText);
        $cleanedText = preg_replace('/(["\/])/', '$1', $cleanedText);
        // $cleanedText = preg_replace('/([\\/])/', ' or ', $cleanedText);
        $cleanedText = str_replace(['&nbsp;', '\n', '\r', '\\\\'], [' ', ' ', ' ', ''], $cleanedText);
        $cleanedText = str_replace('"', "'", $cleanedText);
        $cleanedText = preg_replace('/\s+/', ' ', $cleanedText);
        return trim($cleanedText);
    }
}
