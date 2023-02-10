<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmailBulkInvitationController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx') {
                $path = $file->store('public');
                $file = Storage::get($path);
                $emails = [];
                if ($extension == 'csv') {
                    $emails = array_map('str_getcsv', explode("\n", $file));
                } else {
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($extension));
                    $spreadsheet = $reader->load($path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $emails = $worksheet->toArray();
                }
                return view('emails', compact('emails'));
            } else {
                return redirect()->back()->with('error', 'Invalid file type');
            }
        } else {
            return redirect()->back()->with('error', 'File not found');
        }
    }
}
