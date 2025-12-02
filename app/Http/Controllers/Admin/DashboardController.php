<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Category; // [MỚI] Nhớ thêm model Category
use Illuminate\Support\Facades\DB; // [MỚI] Để dùng DB::raw vẽ biểu đồ

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê số liệu cho các Thẻ (Cards)
        $stats = [
            'users'      => User::count(),
            'documents'  => Document::count(),
            'categories' => Category::count(), // [MỚI] Đếm danh mục
            'admins'     => User::where('role', 'ADMIN')->count(), // [MỚI] Đếm admin
        ];

        // 2. [MỚI] Dữ liệu cho Biểu đồ: Số văn bản theo 12 tháng năm nay
        $docsByMonth = Document::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Chuẩn hóa dữ liệu mảng 12 tháng (tháng nào ko có thì bằng 0)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $docsByMonth[$i] ?? 0;
        }

        // 3. [GIỮ LẠI CŨ] Lấy 5 văn bản mới nhất để hiện danh sách nhanh
        $recentDocuments = Document::with(['author', 'category']) // Eager load thêm category cho đẹp
                            ->latest()
                            ->take(5)
                            ->get();

        // Trả về view admin.dashboard.index (Bạn nhớ tạo folder dashboard/index.blade.php nhé)
        return view('admin.dashboard.index', compact('stats', 'chartData', 'recentDocuments'));
    }
}