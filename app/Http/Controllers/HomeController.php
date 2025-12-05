<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy user hiện tại (có thể null nếu chưa đăng nhập)
        $user = auth()->user();

        // 1. Lấy danh sách Danh mục (để hiện menu)
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // ==========================================================
        // PHẦN 1: QUERY CHÍNH (DANH SÁCH MỚI NHẤT & TÌM KIẾM)
        // ==========================================================
        $query = Document::with('author', 'category')
            ->where('status', 'approved');

        // --- LOGIC PHÂN QUYỀN (Áp dụng cho Query chính) ---
        // Nếu chưa đăng nhập HOẶC là Sinh viên (SV)
        if (!$user || $user->role === 'SV') {
            // Điều kiện 1: Phải là văn bản công khai
            $query->where('privacy', 'public');

            // Điều kiện 2: Phải nằm trong danh mục công khai
            $query->whereHas('category', function ($q) {
                $q->where('is_internal', false);
            });
        }

        // 3. Xử lý Tìm kiếm
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        // 4. Xử lý Lọc theo Danh mục
        if ($request->filled('cat')) {
            $catId = $request->cat;

            // Tìm xem danh mục này có con không
            // Lấy danh sách ID gồm: Chính nó + Các con của nó
            $categoryIds = Category::where('id', $catId)
                ->orWhere('parent_id', $catId)
                ->pluck('id')
                ->toArray();

            // Dùng whereIn để lấy văn bản thuộc bất kỳ ID nào trong danh sách trên
            $query->whereIn('category_id', $categoryIds);
        }

        // Lấy dữ liệu phân trang cho danh sách chính
        $docs = $query->latest()->paginate(12);


        // ==========================================================
        // [MỚI] PHẦN 2: LẤY DATA CHO CÁC MỤC GỢI Ý (FEATURED & TRENDING)
        // ==========================================================

        // A. Danh mục nổi bật (Lấy 4 danh mục cha)
        $featuredCategories = Category::whereNull('parent_id')
            ->with('children') // Lấy kèm các con
            ->withCount('documents') // Đếm bài của chính nó
            ->take(4)
            ->get();

        // Duyệt qua từng danh mục cha để cộng dồn số bài của con vào
        foreach ($featuredCategories as $cat) {
            // Lấy số lượng bài của các con
            $childrenCount = Category::where('parent_id', $cat->id)->withCount('documents')->get()->sum('documents_count');

            // Cộng dồn vào cha
            $cat->documents_count += $childrenCount;
        }

        // B. Tài liệu phổ biến (Trending)
        // Cần tạo Query mới nhưng vẫn phải giữ logic BẢO MẬT như trên
        $popQuery = Document::with('author', 'category')->where('status', 'approved');

        if (!$user || $user->role === 'SV') {
            $popQuery->where('privacy', 'public')
                ->whereHas('category', function ($q) {
                    $q->where('is_internal', false);
                });
        }

        // Lấy 4 tài liệu ngẫu nhiên (hoặc theo views nếu có)
        $popularDocs = $popQuery->inRandomOrder()
            ->take(4)
            ->get();


        // ==========================================================
        // TRẢ VỀ VIEW
        // ==========================================================
        return view('home.index', compact('docs', 'categories', 'featuredCategories', 'popularDocs'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $user = auth()->user();

        // 1. Kiểm tra quyền truy cập Danh mục (Nếu danh mục là Nội bộ mà SV vào xem -> Chặn)
        if ($category->is_internal && (!$user || $user->role === 'SV')) {
            abort(403, 'Bạn không có quyền truy cập danh mục nội bộ này.');
        }

        // 2. Lấy danh sách ID (Chính nó + Các con của nó)
        $categoryIds = Category::where('id', $id)
            ->orWhere('parent_id', $id)
            ->pluck('id')
            ->toArray();

        // 3. Query văn bản
        $query = Document::with('author', 'category')
            ->whereIn('category_id', $categoryIds)
            ->where('status', 'approved');

        // 4. Áp dụng Logic Phân quyền (Privacy) - Copy từ hàm index
        if (!$user || $user->role === 'SV') {
            $query->where('privacy', 'public');
            // (Không cần check is_internal ở đây nữa vì đã check ở bước 1 rồi, 
            // nhưng nếu cẩn thận cứ để whereHas cũng được)
        }

        $docs = $query->latest()->paginate(12);

        return view('home.category', compact('category', 'docs'));
    }

    // Trang xem chi tiết
    public function show($id)
    {
        $doc = Document::where('status', 'approved')->findOrFail($id);
        return view('home.show', compact('doc'));
    }
}
