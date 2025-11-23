@extends('layouts.app')

@section('title', 'Danh sách tài liệu')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Danh sách tài liệu</h1>

  <a class="btn" href="{{ route('documents.create') }}">+ Upload tài liệu</a>

  @if(session('success'))
      <div class="alert alert-success mt-2">{{ session('success') }}</div>
  @endif

  <table class="table-auto w-full mt-4 border">
      <thead>
          <tr class="bg-gray-100">
              <th class="p-2 border">#</th>
              <th class="p-2 border">Tiêu đề</th>
              <th class="p-2 border">Loại</th>
              <th class="p-2 border">Tác giả</th>
              <th class="p-2 border">Ngày tạo</th>
              <th class="p-2 border">File</th>
              <th class="p-2 border">Hành động</th>
          </tr>
      </thead>
      <tbody>
      @foreach($docs as $doc)
          <tr>
              <td class="border p-2">{{ $doc->id }}</td>
              <td class="border p-2">{{ $doc->title }}</td>
              <td class="border p-2">{{ $doc->type }}</td>
              <td class="border p-2">{{ $doc->author->fullname ?? '-' }}</td>
              <td class="border p-2">{{ $doc->created_at->format('d/m/Y') }}</td>
              <td class="border p-2">
                  @if($doc->drive_path)
                      <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view"
                         class="text-blue-600 underline" target="_blank">Xem</a>
                  @else
                      —
                  @endif
              </td>
              <td class="border p-2">
                  <form action="{{ route('documents.destroy', $doc->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="text-red-600 underline" type="submit">Xoá</button>
                  </form>
              </td>
          </tr>
      @endforeach
      </tbody>
  </table>

  <div class="mt-4">
      {{ $docs->links() }}
  </div>
@endsection
