@extends('layouts.guest') {{-- Sử dụng Layout dành cho khách --}}

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="login-card">
    <h1>Tạo tài khoản mới</h1>
    <p class="subtitle">Tham gia hệ thống quản lý văn bản</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        {{-- 1. Họ và Tên --}}
        <div>
            <label>Họ và Tên</label>
            <div class="input-group">
                {{-- Icon User --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <input type="text" name="fullname" value="{{ old('fullname') }}" placeholder="Ví dụ: Nguyễn Văn A" required autofocus>
            </div>
            @error('fullname') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- 2. Email --}}
        <div style="margin-top: 15px;">
            <label>Email</label>
            <div class="input-group">
                {{-- Icon Mail --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
            </div>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- 3. Mật khẩu --}}
        <div style="margin-top: 15px;">
            <label>Mật khẩu</label>
            <div class="input-group">
                {{-- Icon Lock --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <input type="password" name="password" placeholder="Tối thiểu 6 ký tự" required>
            </div>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- 4. Xác nhận mật khẩu --}}
        <div style="margin-top: 15px;">
            <label>Nhập lại mật khẩu</label>
            <div class="input-group">
                {{-- Icon Check Circle --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu bên trên" required>
            </div>
        </div>

        {{-- Nút Submit --}}
        <button type="submit" class="btn" style="margin-top: 20px;">Đăng ký tài khoản</button>
    </form>

    <div class="divider"><span>Hoặc đăng ký bằng</span></div>

    <div class="social-btns">
        <button class="btn-social">
            <i class="fab fa-google" style="color: #ea4335;"></i> Google
        </button>
        {{-- Nếu muốn thêm FB --}}
        {{-- <button class="btn-social"><i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook</button> --}}
    </div>

    <div class="footer-text">
        Đã có tài khoản?
        <a href="{{ route('login.form') }}">Đăng nhập ngay</a>
    </div>
</div>
@endsection