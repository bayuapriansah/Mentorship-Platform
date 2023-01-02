<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
      return view('dashboard.index');
    }

    public function indexCompany()
    {
      return view('dashboard.index');
    }

    public function indexMentor()
    {
      return view('dashboard.index');
    }
}
