<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Services\GoogleDriveService;

class DocumentController extends Controller
{
    public function index()
    {
        $docs = Document::latest()->paginate(10);
        return view('documents.index', compact('docs'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request, GoogleDriveService $drive)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'file' => 'required|file|max:20480', // 20MB
        ]);

        $uploaded = $drive->upload($request->file('file'));

        $doc = new Document();
        $doc->title = $request->title;
        $doc->type = $request->type;
        $doc->user_id = auth()->id();
        $doc->author_id = auth()->id();
        $doc->drive_path = $uploaded->id; // lưu fileId
        $doc->save();

        return redirect()->route('documents.index')
            ->with('success', 'Tải lên thành công!');
    }

    public function destroy(Document $document, GoogleDriveService $drive)
    {
        if ($document->drive_path) {
            $drive->delete($document->drive_path);
        }
        $document->delete();
        return back()->with('success', 'Đã xoá tài liệu');
    }
}
