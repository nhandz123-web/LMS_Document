@extends('layouts.app')

@section('title', 'Upload tài liệu')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Upload tài liệu</h1>

  @if ($errors->any())
    <div class="alert alert-danger mb-3">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label class="block font-medium mb-1">Tiêu đề</label>
      <input type="text" name="title" class="form-input w-full" value="{{ old('title') }}" required>
    </div>

    <div>
      <label class="block font-medium mb-1">Loại</label>
      <input type="text" name="type" class="form-input w-full" value="{{ old('type') }}" required>
      {{-- hoặc dùng <select name="type">…</select> --}}
    </div>

    <div>
      <label class="block font-medium mb-1">File</label>
      <input type="file" name="file" class="form-input w-full" required>
    </div>

    <button type="submit" class="btn">Gửi</button>
    <a href="{{ route('documents.index') }}" class="btn">Hủy</a>
  </form>
@endsection
