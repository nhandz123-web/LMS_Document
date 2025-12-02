<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Kiểm tra Email và Mật khẩu trước (Chưa quan tâm bị khóa hay không)
        // Auth::validate() chỉ kiểm tra đúng sai, chưa đăng nhập
        if (Auth::validate($credentials)) {

            // Lấy user ra để kiểm tra trạng thái
            // (Bạn cần chắc chắn đã có Model User, thường Laravel có sẵn)
            $user = \App\Models\User::where('email', $request->email)->first();

            // 3. Kiểm tra cột is_active
            if ($user->is_active == 0) {
                // Nếu bị khóa -> Trả về lỗi và KHÔNG cho đăng nhập
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị KHÓA. Vui lòng liên hệ Quản trị viên.',
                ])->onlyInput('email');
            }

            // 4. Nếu tài khoản Hoạt động (is_active = 1) -> Tiến hành đăng nhập
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Chuyển hướng theo Role (như code cũ của bạn)
            // Lưu ý: Đảm bảo trong DB vai trò là 'ADMIN' (viết hoa) như bạn đã nói
            return $user->role === 'ADMIN'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        // 5. Trường hợp sai Email hoặc Mật khẩu
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}
