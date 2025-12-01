<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Services\GoogleDriveService;

class DocumentManagementController extends Controller
{
    public function index(Request $request)
    {
        // 1. Bỏ logic lọc theo status, chỉ cần tìm kiếm và lấy list
        $query = Document::with('author');

        // Vẫn giữ tìm kiếm theo tên
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $docs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.documents.index', compact('docs'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request, GoogleDriveService $drive)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'file' => 'required|file|max:20480', 
        ]);

        try {
            $uploaded = $drive->upload($request->file('file'));

            $doc = new Document();
            $doc->title = $request->title;
            $doc->type = $request->type;
            $doc->user_id = auth()->id();
            $doc->author_id = auth()->id();
            $doc->drive_path = $uploaded->id;
            
            // QUAN TRỌNG: Mặc định luôn là 'approved' để hiện thị ra ngoài
            $doc->status = 'approved'; 
            
            $doc->save();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Đã tải lên văn bản thành công!');

        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }

    // XÓA hàm approve()
    // XÓA hàm reject()

    public function destroy($id, GoogleDriveService $drive)
    {
        $doc = Document::findOrFail($id);
        try {
            if ($doc->drive_path) {
                $drive->delete($doc->drive_path);
            }
            $doc->delete();
            return back()->with('success', 'Đã xóa văn bản.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $doc = Document::findOrFail($id);
        return view('admin.documents.edit', compact('doc'));
    }

    // 2. Xử lý cập nhật
    public function update(Request $request, $id, GoogleDriveService $drive)
    {
        $doc = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'file' => 'nullable|file|max:20480', // File không bắt buộc nhập lại
        ]);

        try {
            // A. XỬ LÝ ĐỔI TÊN TRÊN DRIVE
            // Nếu tiêu đề thay đổi và file chưa bị thay thế
            if ($doc->title !== $request->title && $doc->drive_path) {
                // Gọi hàm rename vừa thêm ở Bước 1
                $drive->rename($doc->drive_path, $request->title);
            }

            // B. XỬ LÝ NẾU CÓ UPLOAD FILE MỚI
            if ($request->hasFile('file')) {
                // Xóa file cũ trên Drive
                if ($doc->drive_path) {
                    $drive->delete($doc->drive_path);
                }
                // Upload file mới
                $uploaded = $drive->upload($request->file('file'));
                $doc->drive_path = $uploaded->id;
            }

            // C. CẬP NHẬT DATABASE
            $doc->title = $request->title;
            $doc->type = $request->type;
            // $doc->status = 'approved'; // Nếu muốn sửa xong auto duyệt lại thì bỏ comment dòng này
            $doc->save();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Cập nhật văn bản thành công!');

        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }
}