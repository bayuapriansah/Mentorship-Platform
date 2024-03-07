<?php

namespace App\Http\Controllers;

use App\Models\InternalDocumentGroupSection;
use App\Models\InternalDocumentPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InternalDocumentController extends Controller
{
    public function index()
    {
        $sections = InternalDocumentGroupSection::where('is_draft', false)->orderBy('id')->get();

        foreach ($sections as $section) {
            if ($section->internalDocumentPages->count() !== 0) {
                $pages = $section->internalDocumentPages->where('is_draft', false)->sortBy('id');

                if (count($pages) > 0) {
                    return redirect()->route('internal-document', ['slug' => $pages[0]->slug]);
                }
            }
        }

        abort(404);
    }

    public function allPages()
    {
        return view('dashboard.internal-document.all-pages');
    }

    public function groupSection()
    {
        return view('dashboard.internal-document.group-section');
    }

    public function viewPage($id)
    {
        $page = InternalDocumentPage::where('id', $id)->where('is_draft', false)->first();
        abort_if(!$page, 404);
        $files = $this->getFiles($page->id);

        return view('dashboard.internal-document.view-page', compact('page', 'files'));
    }

    public function viewPublicPage($slug)
    {
        $page = InternalDocumentPage::where('slug', $slug)->where('is_draft', false)->first();
        abort_if(!$page, 404);

        $groupSections = InternalDocumentGroupSection::orderBy('id')->get();
        $files = $this->getFiles($page->id);

        return view('internal-document', compact('groupSections', 'page', 'files'));
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
                'subtitle' => 'nullable',
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
                        $file->storeAs('public/internal-document', $file_name);
                        $file_path[] = 'internal-document/'. $file_name;
                    }
                }

                $page = InternalDocumentPage::create([
                    'internal_document_group_section_id' => $validated['internal_document_group_section_id'],
                    'title' => $validated['title'],
                    'slug' => Str::slug($validated['title']),
                    'subtitle' => $validated['subtitle'],
                    'description' => $validated['description'],
                    'files' => count($file_path) > 0 ? json_encode($file_path) : null,
                    'files_header_info' => $request->input('files_header_info'),
                    'files_footer_info' => $request->input('files_footer_info'),
                ]);

                $page->update([
                    'slug' => Str::slug($page->title . '-'. $page->id),
                ]);
            });

            toastr()->success('Page added successfully');
            return redirect()->route('dashboard.internal-document.all-pages.index');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function editPage($id)
    {
        $page = InternalDocumentPage::find($id);

        if (!$page) {
            abort(404);
        }

        $files = json_decode($page->files) !== null ? json_decode($page->files) : [];
        $sections = InternalDocumentGroupSection::orderBy('created_at')->get();

        return view('dashboard.internal-document.edit-page', compact('page', 'files', 'sections'));
    }

    public function updatePage(Request $request, $id)
    {
        try {
            $page = InternalDocumentPage::find($id);

            if (!$page) {
                throw new Exception('Page not found');
            }

            $validator = Validator::make($request->all(), [
                'internal_document_group_section_id' => 'required',
                'title' => 'required',
                'subtitle' => 'nullable',
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

            DB::transaction(function () use ($validated, $request, $page) {
                $file_path = [];

                if (json_decode($page->files) !== null) {
                    $file_path = json_decode($page->files);
                }

                if ($request->hasFile('files')) {
                    $files = $request->file('files');

                    foreach ($files as $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file->storeAs('public/internal-document', $file_name);
                        $file_path[] = 'internal-document/'. $file_name;
                    }
                }

                $page->update([
                    'internal_document_group_section_id' => $validated['internal_document_group_section_id'],
                    'title' => $validated['title'],
                    'slug' => Str::slug($validated['title'] . '-'. $page->id),
                    'subtitle' => $validated['subtitle'],
                    'description' => $validated['description'],
                    'files' => count($file_path) > 0 ? json_encode($file_path) : null,
                    'files_header_info' => $request->input('files_header_info'),
                    'files_footer_info' => $request->input('files_footer_info'),
                ]);
            });

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    if ($file->getSize() > 5500000) {
                        throw new Exception('File size is too big, max size is 5MB');
                    }
                }
            }

            toastr()->success('Page updated successfully');
            return redirect()->route('dashboard.internal-document.all-pages.index');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function deletePageFile(Request $request, $id)
    {
        try {
            $page = InternalDocumentPage::find($id);
            $file_path = $request->query('file_path');

            if (!$page || !$file_path) {
                abort(404);
            }

            $file_path = urldecode($file_path);

            $files = json_decode($page->files) !== null ? json_decode($page->files) : [];
            $target = '';

            foreach ($files as $file) {
                if ($file === $file_path) {
                    $target = $file;
                    break;
                }
            }

            if ($target === '') {
                throw new Exception('File not found');
            }

            if (file_exists(storage_path('app/public/'. $target))) {
                DB::transaction(function () use ($page, $files, $target) {
                    $trashFolder = 'public/trash/'. date('Ymd');

                    Storage::makeDirectory($trashFolder);
                    Storage::move('public/'. $target, $trashFolder . '/'. $target);

                    $files = array_diff($files, [$target]);
                    $page->update([
                        'files' => count($files) > 0 ? json_encode($files) : null,
                    ]);
                });
            } else {
                throw new Exception('File not found');
            }

            toastr()->success('File deleted successfully');
            return back()->withInput();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function getFiles($id)
    {
        $page = InternalDocumentPage::findOrFail($id);
        $files = json_decode($page->files) !== null ? json_decode($page->files) : [];
        $result = [];

        foreach ($files as $file) {
            $result[] = [
                'name' => $file,
                'url' => asset('storage/'. $file),
                'logo' => $this->getFileLogo($file),
            ];
        }

        return $result;
    }

    private function getFileLogo($filePath)
    {
        $extLogos = [
            [
                'ext' => ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff', 'tif', 'ico'],
                'logo' => asset('/assets/img/file-logo/image.png'),
            ],
            [
                'ext' => ['txt', 'rtf'],
                'logo' => asset('/assets/img/file-logo/text.png'),
            ],
            [
                'ext' => ['csv'],
                'logo' => asset('/assets/img/file-logo/csv.png'),
            ],
            [
                'ext' => ['pdf'],
                'logo' => asset('/assets/img/file-logo/pdf.png'),
            ],
            [
                'ext' => ['doc', 'docx'],
                'logo' => asset('/assets/img/file-logo/ms-word.png'),
            ],
            [
                'ext' => ['xls', 'xlsx'],
                'logo' => asset('/assets/img/file-logo/ms-excel.png'),
            ],
            [
                'ext' => ['ppt', 'pptx'],
                'logo' => asset('/assets/img/file-logo/ms-powerpoint.png'),
            ],
            [
                'ext' => ['py', 'pyw', 'ipy', 'ipynb'],
                'logo' => asset('/assets/img/file-logo/python.png'),
            ],
            [
                'ext' => ['sql', 'db', 'plpgsql'],
                'logo' => asset('/assets/img/file-logo/sql.png'),
            ],
            [
                'ext' => ['zip', 'rar', '7z', 'tar.gz', 'gz'],
                'logo' => asset('/assets/img/file-logo/zip.png'),
            ],
        ];

        $generalFileLogo = asset('/assets/img/file-logo/general.png');
        $ext = pathinfo(storage_path('app/public/'. $filePath), PATHINFO_EXTENSION);

        foreach ($extLogos as $logo) {
            if (in_array($ext, $logo['ext'])) {
                return $logo['logo'];
            }
        }

        return $generalFileLogo;
    }
}
