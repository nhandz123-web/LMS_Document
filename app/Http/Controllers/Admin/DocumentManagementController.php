<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Services\GoogleDriveService;
use App\Models\Category;

class DocumentManagementController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo query
        $query = Document::with(['author', 'category']); // Eager load cả category

        // 2. Lọc theo Từ khóa (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // 3. [MỚI] Lọc theo Danh mục (Category)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Lấy dữ liệu phân trang
        $docs = $query->latest()->paginate(10)->withQueryString(); // withQueryString giữ lại bộ lọc khi qua trang 2

        // 5. [MỚI] Lấy danh sách danh mục để hiển thị ở Filter Dropdown
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.documents.index', compact('docs', 'categories'));
    }

    public function create()
    {
        // Lấy các danh mục Cha (parent_id = null) và kèm theo con của nó (children)
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request, GoogleDriveService $drive)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // <--- Validate Danh mục
            'type' => 'required',
            'file' => 'required|file|max:20480',
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục văn bản.',
        ]);

        try {
            $uploaded = $drive->upload($request->file('file'));

            $doc = new Document();
            $doc->title = $request->title;
            $doc->category_id = $request->category_id; // <--- LƯU DANH MỤC
            $doc->type = $request->type;
            $doc->user_id = auth()->id();
            $doc->author_id = auth()->id();
            $doc->drive_path = $uploaded->id;
            $doc->status = 'approved';
            $doc->save();

            return redirect()->route('admin.documents.index')->with('success', 'Đã tải lên thành công!');
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
        // Cũng lấy danh mục y hệt hàm create
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.documents.edit', compact('doc', 'categories'));
    }

    // 2. Xử lý cập nhật
    // public function update(Request $request, $id, GoogleDriveService $drive)
    // {
    //     $doc = Document::findOrFail($id);

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'type' => 'required',
    //         'file' => 'nullable|file|max:20480', // File không bắt buộc nhập lại
    //     ]);

    //     try {
    //         // A. XỬ LÝ ĐỔI TÊN TRÊN DRIVE
    //         // Nếu tiêu đề thay đổi và file chưa bị thay thế
    //         if ($doc->title !== $request->title && $doc->drive_path) {
    //             // Gọi hàm rename vừa thêm ở Bước 1
    //             $drive->rename($doc->drive_path, $request->title);
    //         }

    //         // B. XỬ LÝ NẾU CÓ UPLOAD FILE MỚI
    //         if ($request->hasFile('file')) {
    //             // Xóa file cũ trên Drive
    //             if ($doc->drive_path) {
    //                 $drive->delete($doc->drive_path);
    //             }
    //             // Upload file mới
    //             $uploaded = $drive->upload($request->file('file'));
    //             $doc->drive_path = $uploaded->id;
    //         }

    //         // C. CẬP NHẬT DATABASE
    //         $doc->title = $request->title;
    //         $doc->type = $request->type;
    //         // $doc->status = 'approved'; // Nếu muốn sửa xong auto duyệt lại thì bỏ comment dòng này
    //         $doc->save();

    //         return redirect()->route('admin.documents.index')
    //             ->with('success', 'Cập nhật văn bản thành công!');
    //     } catch (\Exception $e) {
    //         return back()->withErrors(['file' => 'Lỗi: ' . $e->getMessage()])->withInput();
    //     }
    // }

    public function update(Request $request, $id, GoogleDriveService $drive)
    {
        $doc = Document::findOrFail($id);

        // 1. Validate (Giữ nguyên)
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Kiểm tra danh mục tồn tại
            'type' => 'required',
            'file' => 'nullable|file|max:20480',
        ]);

        try {
            // ... (Đoạn xử lý đổi tên file và upload file mới giữ nguyên) ...
            if ($doc->title !== $request->title && $doc->drive_path) {
                $drive->rename($doc->drive_path, $request->title);
            }

            if ($request->hasFile('file')) {
                // ... logic upload file ...
            }

            // 2. CẬP NHẬT DATABASE
            $doc->title = $request->title;

            // ---> [QUAN TRỌNG] THÊM DÒNG NÀY ĐỂ LƯU DANH MỤC <---
            $doc->category_id = $request->category_id;

            $doc->type = $request->type;
            $doc->save();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Cập nhật văn bản và danh mục thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }
}
