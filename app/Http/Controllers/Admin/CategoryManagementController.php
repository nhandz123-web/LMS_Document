<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryManagementController extends Controller
{
    // Hiển thị danh sách dạng Cây
    public function index()
    {
        // Lấy danh mục Cha (parent_id = null), kèm theo danh mục Con (children)
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // Có thể null (là cha) hoặc là ID của cha
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Tạo slug tự động: "Giáo Trình" -> "giao-trinh"
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Đã thêm danh mục mới thành công!');
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Đã cập nhật tên danh mục.');
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Lưu ý: Nếu xóa Cha, các Con sẽ bị xóa theo (do migration set cascade)
        // Các văn bản thuộc danh mục này sẽ set category_id = null (do migration set null)
        $category->delete();

        return back()->with('success', 'Đã xóa danh mục.');
    }
}