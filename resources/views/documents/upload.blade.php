@extends('layouts.app')
@section('title','Upload tài liệu')

@section('content')
  <h1 class="text-2xl mb-4">Upload tài liệu</h1>

  @if ($errors->any())
    <div class="danger">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-3">
    @csrf
    <div>
      <label>Tiêu đề</label>
      <input class="inp" type="text" name="title" required>
    </div>
    <div>
      <label>Loại</label>
      <select class="inp" name="type" required>
        <option value="">-- Chọn --</option>
        <option value="giaotrinh">Giáo trình</option>
        <option value="decuong">Đề cương</option>
        <option value="thongbao">Thông báo</option>
      </select>
    </div>
    <div>
      <label>File</label>
      <input class="inp" type="file" name="file" required>
    </div>
    <button class="btn">Gửi</button>
  </form>
@endsection
