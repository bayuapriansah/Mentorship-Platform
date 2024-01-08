<?php

namespace App\Http\Controllers;

use App\Models\InternalDocumentGroupSection;
use App\Models\InternalDocumentPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function addPage()
    {
        $sections = InternalDocumentGroupSection::orderBy('created_at')->get();
        return view('dashboard.internal-document.add-page', compact('sections'));
    }

    public function savePage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'internal_document_group_section_id' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'description' => 'required',
            ], [
                'internal_document_group_section_id.required' => 'Please select a group section',
                'title.required' => 'Title is required',
                'subtitle.required' => 'Subtitle is required',
                'description.required' => 'Description is required',
            ]);

            if ($validator->fails()) {
                toastr()->error('Please fill all required fields');
                return back()->withErrors($validator)->withInput();
            }

            $validated = $validator->validated();

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    if ($file->getSize() > 5500000) {
                        throw new Exception('File size is too big, max size is 5MB');
                    }
                }
            }

            DB::transaction(function () use ($validated, $request) {
                $file_path = [];

                if ($request->hasFile('files')) {
                    $files = $request->file('files');

                    foreach ($files as $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file_path[] = $file->storeAs('public/internal-document', $file_name);
                    }
                }

                InternalDocumentPage::create([
                    'internal_document_group_section_id' => $validated['internal_document_group_section_id'],
                    'title' => $validated['title'],
                    'subtitle' => $validated['subtitle'],
                    'description' => $validated['description'],
                    'files' => count($file_path) > 0 ? json_encode($file_path) : null,
                ]);
            });

            toastr()->success('Page added successfully');
            return redirect()->route('dashboard.internal-document.all-pages.index');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }
}
