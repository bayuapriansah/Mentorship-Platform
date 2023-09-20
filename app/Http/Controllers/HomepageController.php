<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function studentsInfo()
    {
        return view('homepage.students-info');
    }

    public function institutesInfo()
    {
        return view('homepage.institutes-info');
    }

    public function partnersInfo()
    {
        return view('homepage.partners-info');
    }
}
