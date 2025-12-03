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
            $query->where('category_id', $request->cat);
        }

        // Lấy dữ liệu phân trang cho danh sách chính
        $docs = $query->latest()->paginate(12);


        // ==========================================================
        // [MỚI] PHẦN 2: LẤY DATA CHO CÁC MỤC GỢI Ý (FEATURED & TRENDING)
        // ==========================================================

        // A. Danh mục nổi bật (Lấy 4 danh mục cha)
        $featuredCategories = Category::whereNull('parent_id')
            ->withCount('documents') // Đếm số bài bên trong
            ->take(4)
            ->get();

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

    // Trang xem chi tiết
    public function show($id)
    {
        $doc = Document::where('status', 'approved')->findOrFail($id);
        return view('home.show', compact('doc'));
    }
}
