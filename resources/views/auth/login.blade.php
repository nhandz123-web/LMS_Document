@extends('layouts.guest') {{-- SỬ DỤNG LAYOUT RIÊNG CHO KHÁCH --}}

@section('title', 'Đăng nhập')

@section('content')
<div class="login-card">
    <h1>Chào mừng trở lại!</h1>
    <p class="subtitle">Đăng nhập để truy cập kho tài liệu</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        {{-- Email --}}
        <div>
            <label>Email đăng nhập</label>
            <div class="input-group">
                {{-- Icon Email --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
            </div>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div style="margin-top: 15px;">
            <label>Mật khẩu</label>
            <div class="input-group">
                {{-- Icon Lock --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
        </div>

        {{-- Ghi nhớ & Quên MK --}}
        <div class="options">
            <label style="margin:0; font-weight:400; cursor:pointer;">
                <input type="checkbox" name="remember"> <span style="margin-left:5px">Ghi nhớ tôi</span>
            </label>
            <a href="#">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn">Đăng nhập ngay</button>
    </form>

    <div class="divider"><span>Hoặc tiếp tục với</span></div>

    <div class="social-btns">
        <button class="btn-social">
            <i class="fab fa-google" style="color: #ea4335;"></i> Google
        </button>
        {{-- Nếu muốn thêm FB thì bỏ comment --}}
        {{-- <button class="btn-social"><i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook</button> --}}
    </div>

    <div class="footer-text">
        Chưa có tài khoản?
        <a href="{{ route('register.form') }}">Đăng ký ngay</a>
    </div>
</div>
@endsection