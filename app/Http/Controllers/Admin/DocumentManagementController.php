<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query
        $query = Document::with('author'); // Eager load user để tránh N+1 query

        // Xử lý bộ lọc trạng thái
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Tìm kiếm (nếu muốn mở rộng sau này)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Lấy dữ liệu, sắp xếp mới nhất trước, phân trang 10 dòng
        $docs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.documents.index', compact('docs'));
    }

    public function approve($id)
    {
        $doc = Document::findOrFail($id);
        $doc->update(['status' => 'approved', 'rejected_reason' => null]);
        return back()->with('success', "Đã duyệt văn bản: {$doc->title}");
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        
        $doc = Document::findOrFail($id);
        $doc->update(['status' => 'rejected', 'rejected_reason' => $request->reason]);
        
        return back()->with('success', 'Đã từ chối văn bản.');
    }
    
    // Hàm xóa (dùng chung logic với user hoặc viết riêng tùy bạn)
    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        // Code xóa file trên Google Drive (gọi Service) ở đây nếu cần
        $doc->delete();
        return back()->with('success', 'Đã xóa văn bản vĩnh viễn.');
    }
}