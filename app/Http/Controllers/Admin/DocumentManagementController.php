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

    // public function create()
    // {
    //     // Lấy các danh mục Cha (parent_id = null) và kèm theo con của nó (children)
    //     $categories = Category::whereNull('parent_id')->with('children')->get();

    //     return view('admin.documents.create', compact('categories'));
    // }

    public function store(Request $request, GoogleDriveService $drive)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validate Danh mục
            'type' => 'required',
            'file' => 'required|file|max:20480', // Max 20MB
            'privacy' => 'required|in:public,restricted', // [MỚI] Validate Quyền hạn
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // [MỚI] Validate Ảnh bìa
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục văn bản.',
            'privacy.required' => 'Vui lòng chọn phạm vi hiển thị.',
        ]);

        try {
            // 2. Upload file tài liệu lên Google Drive
            $uploaded = $drive->upload($request->file('file'));

            // 3. Khởi tạo đối tượng
            $doc = new Document();
            $doc->title = $request->title;
            $doc->category_id = $request->category_id; // Lưu Danh mục
            $doc->type = $request->type;
            $doc->privacy = $request->privacy; // Lưu Quyền hạn

            $doc->user_id = auth()->id();
            $doc->author_id = auth()->id();
            $doc->drive_path = $uploaded->id;
            $doc->status = 'approved';

            // 4. [MỚI] Xử lý upload Ảnh bìa (nếu có)
            if ($request->hasFile('cover_image')) {
                // Lưu vào public/storage/covers
                $path = $request->file('cover_image')->store('covers', 'public');
                $doc->cover_image = $path;
            }

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

        // 1. Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required',
            'privacy' => 'required|in:public,restricted', // [MỚI]
            'file' => 'nullable|file|max:20480', // File tài liệu (không bắt buộc)
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // [MỚI]
        ]);

        try {
            // 2. Xử lý Google Drive
            // A. Đổi tên file trên Drive nếu tiêu đề thay đổi
            if ($doc->title !== $request->title && $doc->drive_path) {
                $drive->rename($doc->drive_path, $request->title);
            }

            // B. Thay thế file tài liệu (nếu người dùng upload file mới)
            if ($request->hasFile('file')) {
                // Xóa file cũ trên Drive
                if ($doc->drive_path) {
                    $drive->delete($doc->drive_path);
                }
                // Upload file mới
                $uploaded = $drive->upload($request->file('file'));
                $doc->drive_path = $uploaded->id;
            }

            // 3. Cập nhật thông tin vào Database
            $doc->title = $request->title;
            $doc->category_id = $request->category_id; // Cập nhật danh mục
            $doc->type = $request->type;
            $doc->privacy = $request->privacy; // Cập nhật quyền hạn

            // 4. [MỚI] Cập nhật Ảnh bìa
            if ($request->hasFile('cover_image')) {
                // (Tùy chọn) Xóa ảnh cũ để tiết kiệm dung lượng server
                // if ($doc->cover_image) Storage::disk('public')->delete($doc->cover_image);

                $path = $request->file('cover_image')->store('covers', 'public');
                $doc->cover_image = $path;
            }

            $doc->save();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Cập nhật văn bản thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }

    // App/Http/Controllers/Admin/DocumentManagementController.php

    public function syncFromDrive(GoogleDriveService $drive)
    {
        try {
            // 1. Lấy tất cả file từ Drive
            $driveFiles = $drive->listFiles();
            $count = 0;

            foreach ($driveFiles as $file) {
                // 2. Kiểm tra xem File ID này đã có trong Database chưa
                $exists = Document::where('drive_path', $file->id)->exists();

                if (!$exists) {
                    // 3. Nếu chưa có -> Tạo mới
                    Document::create([
                        'title' => $file->name, // Lấy tên file làm tiêu đề
                        'drive_path' => $file->id,
                        'type' => $this->guessType($file->mimeType), // Hàm đoán loại file (viết thêm bên dưới)
                        'user_id' => auth()->id(), // Gán tạm cho Admin đang thao tác
                        'author_id' => auth()->id(),
                        'status' => 'approved',
                        'category_id' => null, // Để trống, sau này vào sửa sau
                        'created_at' => date('Y-m-d H:i:s', strtotime($file->createdTime)) // Lấy ngày tạo trên Drive
                    ]);
                    $count++;
                }
            }

            return back()->with('success', "Đã đồng bộ thành công! Tìm thấy {$count} văn bản mới từ Drive.");
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi đồng bộ: ' . $e->getMessage());
        }
    }

    // Hàm phụ để đoán loại file từ mimeType của Google
    private function guessType($mimeType)
    {
        if (str_contains($mimeType, 'pdf')) return 'PDF';
        if (str_contains($mimeType, 'word') || str_contains($mimeType, 'document')) return 'DOCX';
        if (str_contains($mimeType, 'presentation') || str_contains($mimeType, 'powerpoint')) return 'SLIDE';
        return 'OTHER';
    }
}
