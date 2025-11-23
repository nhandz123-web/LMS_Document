@extends('layouts.app')
@section('title','Đăng nhập')
@section('content')
  <div class="card">
    <h1>Đăng nhập</h1>
    <p class="subtitle">Đăng nhập vào tài khoản của bạn</p>

    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf

      <label>Tên đăng nhập / Email</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="5" width="18" height="14" rx="3" stroke="currentColor" stroke-width="1.8"/></svg>
        <input class="inp" type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email">
      </div>
      @error('email') <div class="danger">{{ $message }}</div> @enderror

      <label>Mật khẩu</label>
      <div class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="10" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        <input class="inp" type="password" name="password" placeholder="Mật khẩu">
      </div>

      <div class="alt">
        <label class="muted"><input type="checkbox" name="remember"> Ghi nhớ</label>
        <a class="small-link" href="#">Quên mật khẩu</a>
      </div>

      <div style="margin-top:16px"><button class="btn">Đăng nhập</button></div>
    </form>

    <div class="hr"><span class="muted">Hoặc</span></div>

    <div class="links">
      <button class="btn-fb">Đăng nhập Facebook</button>
      <button class="btn-gg">Đăng nhập Google</button>
    </div>

    <div class="footer">
      <p class="muted">Chưa có tài khoản?
        <a class="small-link" href="{{ route('register.form') }}">Tạo tài khoản mới</a>
      </p>
    </div>
  </div>
@endsection

@once
  @push('icons')
    {{-- placeholder nếu dùng component; không cần nếu không --}}
  @endpush
@endonce
