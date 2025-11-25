<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        // Lấy danh sách user, trừ chính mình ra (để tránh tự xóa/khóa mình)
        $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Thay đổi vai trò (Thăng chức / Giáng chức)
    public function updateRole($id)
    {
        $user = User::findOrFail($id);
        // Đảo ngược quyền: Nếu là admin -> user, và ngược lại
        $newRole = ($user->role === 'admin') ? 'user' : 'admin';
        $user->update(['role' => $newRole]);

        return back()->with('success', "Đã thay đổi quyền của {$user->fullname} thành " . strtoupper($newRole));
    }

    // Khóa / Mở khóa tài khoản
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'Mở khóa' : 'Đã khóa';
        return back()->with('success', "{$status} tài khoản {$user->fullname}");
    }
    
    // Xóa user (cẩn thận: xóa user thì các văn bản của họ sẽ ra sao? 
    // Tạm thời ta chỉ nên Khóa (Soft delete) thay vì xóa cứng).
}