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
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // 1. Lấy trạng thái người dùng chọn
        $isInternal = $request->has('is_internal') ? 1 : 0;

        // 2. [LOGIC MỚI] Kiểm tra Cha (nếu có chọn Cha)
        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            // Nếu Cha là Nội bộ -> Con BẮT BUỘC phải là Nội bộ (bất kể user chọn gì)
            if ($parent && $parent->is_internal) {
                $isInternal = 1;
            }
        }

        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_internal' => $isInternal,
        ]);

        // Nếu vừa tạo là một Cha và muốn đồng bộ xuống con (trường hợp hiếm khi tạo mới nhưng giữ logic cho chặt)
        // Thường store chỉ tạo 1 cái nên không cần cascade xuống dưới.

        $msg = ($request->filled('parent_id') && $isInternal)
            ? 'Đã thêm danh mục con (Tự động set Nội bộ theo danh mục Cha).'
            : 'Đã thêm danh mục mới thành công!';

        return back()->with('success', $msg);
    }

    // Cập nhật danh mục
    // App/Http/Controllers/Admin/CategoryManagementController.php

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 1. Lấy trạng thái từ form (1 hoặc 0)
        $isInternal = $request->has('is_internal') ? 1 : 0;

        // 2. Cập nhật chính nó
        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'is_internal' => $isInternal,
        ]);

        // --- [MỚI] ĐỒNG BỘ CHO MỤC CON (CASCADING) ---
        // Nếu danh mục này có các danh mục con
        if ($category->children()->count() > 0) {
            // Cập nhật tất cả con của nó về cùng trạng thái với Cha
            $category->children()->update([
                'is_internal' => $isInternal
            ]);
        }

        return back()->with('success', 'Đã cập nhật danh mục (và đồng bộ trạng thái cho các mục con).');
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
