@extends('layouts.app')
@section('title','Đăng ký')
@section('content')
  <div class="card">
    <h1>Đăng ký</h1>

    <form method="POST" action="{{ route('register.store') }}">
      @csrf

      <label>Họ và Tên</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="7" r="3.2" stroke="currentColor" stroke-width="1.8"/>
          <path d="M4 20c1.8-4.5 13.2-4.5 16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
        <input class="inp" name="fullname" value="{{ old('fullname') }}" placeholder="Nhập đầy đủ họ và tên">
      </div>
      @error('fullname') <div class="danger">{{ $message }}</div> @enderror

      <label>Email</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="3" y="5" width="18" height="14" rx="3" stroke="currentColor" stroke-width="1.8"/>
        </svg>
        <input class="inp" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
      </div>
      @error('email') <div class="danger">{{ $message }}</div> @enderror

      <label>Mật khẩu</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="10" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/>
          <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
        <input class="inp" type="password" name="password" placeholder="Mật khẩu (≥8, có HOA & ký tự đặc biệt)">
      </div>
      @error('password') <div class="danger">{{ $message }}</div> @enderror

      <label>Nhập lại mật khẩu</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M12 17v-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          <path d="M5 11h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
        <input class="inp" type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu">
      </div>

      <div style="margin-top:16px"><button class="btn">Đăng ký</button></div>
    </form>

    <div class="hr"><span class="muted">Hoặc</span></div>

    <div class="links">
      <button class="btn-fb">Đăng ký với Facebook</button>
      <button class="btn-gg">Đăng ký với Google</button>
    </div>

    <div class="footer">
      <p class="muted">Đã có tài khoản?
        <a class="small-link" href="{{ route('login.form') }}">Đăng nhập</a>
      </p>
    </div>
  </div>
@endsection
