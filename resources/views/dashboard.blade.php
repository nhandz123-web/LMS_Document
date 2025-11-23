@extends('layouts.app')
@section('content')
<h1 class="text-2xl">Xin chào, {{ $user->fullname }} ({{ $role }})</h1>
<ul style="margin-top:12px">
  @if($role === 'SV')
    <li>• Xem tài liệu</li><li>• Nộp bài</li>
  @elseif($role === 'GV')
    <li>• Tài liệu môn</li><li>• Upload/Cập nhật</li>
  @else
    <a href="{{ route('admin.dashboard') }}">Vào trang quản trị</a><li>• Phân quyền</li>
  @endif
</ul>
@endsection
