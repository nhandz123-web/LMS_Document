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
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // [QUAN TRỌNG] Không cho phép tự hạ cấp chính mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể thay đổi quyền của chính mình!');
        }

        // Validate: Chỉ chấp nhận 3 quyền này
        $request->validate([
            'role' => 'required|in:ADMIN,GV,SV'
        ]);

        // Cập nhật
        $user->update(['role' => $request->role]);

        // Tạo thông báo hiển thị cho đẹp
        $roleName = match ($request->role) {
            'ADMIN' => 'Quản trị viên',
            'GV'    => 'Giảng viên',
            'SV'    => 'Sinh viên',
        };

        return back()->with('success', "Đã cập nhật vai trò của [{$user->fullname}] thành: {$roleName}");
    }

    // Khóa / Mở khóa tài khoản
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // [QUAN TRỌNG] Không cho phép tự khóa chính mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể khóa tài khoản của chính mình!');
        }

        if ($user->is_active) {
            // Đang hoạt động -> KHÓA
            $user->update(['is_active' => false]); // Hoặc 0 tùy kiểu dữ liệu DB
            $msg = "Đã khóa tài khoản [{$user->fullname}]. Người này sẽ không thể đăng nhập được nữa.";
        } else {
            // Đang khóa -> MỞ KHÓA
            $user->update(['is_active' => true]); // Hoặc 1
            $msg = "Đã mở khóa tài khoản [{$user->fullname}].";
        }

        return back()->with('success', $msg);
    }

    // --- 1. Hiển thị form sửa ---
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // --- 2. Xử lý cập nhật thông tin ---
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'fullname' => 'required|string|max:255',
            // Email là duy nhất (unique) nhưng phải trừ chính user này ra
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6', // Mật khẩu không bắt buộc, chỉ nhập khi muốn đổi
        ], [
            'email.unique' => 'Email này đã được sử dụng bởi thành viên khác.',
        ]);

        // Cập nhật thông tin cơ bản
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
        ];

        // Nếu có nhập mật khẩu mới thì mới hash và cập nhật
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', "Đã cập nhật thông tin thành viên [{$user->fullname}] thành công.");
    }

    // --- 3. Xóa thành viên ---
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // [QUAN TRỌNG] Không được xóa chính mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        // [CẢNH BÁO] Nếu user này đã đăng bài, việc xóa cứng sẽ làm bài viết bị lỗi.
        // Tạm thời mình xóa user, nhưng các bài viết của họ sẽ vẫn còn trong DB (nhưng mất author).
        // Nếu muốn kỹ hơn thì nên dùng SoftDelete.
        $user->delete();

        return back()->with('success', 'Đã xóa thành viên vĩnh viễn.');
    }
}
