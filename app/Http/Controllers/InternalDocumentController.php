<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalDocumentController extends Controller
{
    public function allPages()
    {
        return view('dashboard.internal-document.all-pages');
    }

    public function groupSection()
    {
        return view('dashboard.internal-document.group-section');
    }
}
