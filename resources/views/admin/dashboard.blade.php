@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Trang quản trị</h1>
  <p>Xin chào, {{ $user->fullname }} ({{ $user->role }})</p>

  <div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-top:16px">
    <a class="card" href="{{ route('admin.dashboard') }}" style="padding:16px;border:1px solid #eee;border-radius:12px;display:block;text-decoration:none">
      <h3>🏠 Tổng quan</h3>
      <p class="muted">Số liệu nhanh, nhật ký hệ thống...</p>
    </a>

    {{-- Ví dụ liên kết quản trị khác (tạo sau) --}}
    {{-- <a class="card" href="{{ route('admin.users.index') }}">👤 Người dùng</a> --}}
    {{-- <a class="card" href="{{ route('admin.documents.index') }}">📄 Văn bản</a> --}}
  </div>
@endsection
