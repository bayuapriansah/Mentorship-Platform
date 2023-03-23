<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BulkEmailInvitation;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmailBulkInvitationController extends Controller
{

    public function index()
    {
        return view('test.upload');
    }
    public function sendInviteFromInstitution(Request $request)
    {
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $extension = $uploadedFile->getClientOriginalExtension();
            if ($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx') {
                $path = Storage::disk('public')->put('invitation', $uploadedFile);
                $filePath = Storage::disk('public')->path($path);
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $emails = [];
                if ($extension == 'csv') {
                    $fileContents = Storage::disk('public')->get($path);
                    $emails = array_map('str_getcsv', explode("\n", $fileContents));
                } else {
                    $worksheet = $spreadsheet->getActiveSheet();
                    $emails = $worksheet->toArray();
                }
                return response()->json(['success' => true, 'emails' => $emails]);
            } else {
                return response()->json(['success' => false, 'error' => 'Invalid file type']);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'File not found']);
        }
    }

}
