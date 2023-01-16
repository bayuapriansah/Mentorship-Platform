<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $projects = Project::take(3)->get();
        return view('index', compact('projects'));
    }
}
