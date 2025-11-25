<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document; // Giả định bạn đã có model này

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê tổng quan
        $stats = [
            'users_count' => User::count(), // Tổng thành viên
            'docs_count'  => Document::count(), // Tổng văn bản
            // Giả sử có cột 'status' để đếm văn bản chờ duyệt
            'pending_docs' => Document::where('status', 'pending')->count(), 
        ];

        // 2. Lấy danh sách văn bản mới nhất (5 cái) để hiển thị nhanh
        $recentDocuments = Document::with('author') // Eager loading user để lấy tên người đăng
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'recentDocuments'));
    }
}