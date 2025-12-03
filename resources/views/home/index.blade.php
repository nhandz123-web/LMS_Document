@extends('layouts.app')

@section('title', 'Trang chủ - Tra cứu tài liệu')

@section('content')

{{-- 1. HERO SECTION: BANNER TÌM KIẾM --}}
<div class="p-5 mb-5 rounded-4 shadow-sm position-relative overflow-hidden"
    style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%); margin-top: -20px;">

    {{-- Hình trang trí nền (Circles) --}}
    <div style="position: absolute; top: -30px; right: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -50px; left: -20px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>

    <div class="row justify-content-center position-relative">
        <div class="col-lg-8 text-center text-white">
            <h2 class="fw-bold mb-2">Thư viện Tài liệu CNTT</h2>
            <p class="mb-4 opacity-75">Tra cứu đồ án, giáo trình và tài liệu tham khảo nhanh chóng</p>

            {{-- Form Tìm kiếm --}}
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group input-group-lg bg-white p-1 rounded-pill shadow">
                    <span class="input-group-text border-0 bg-transparent ps-3">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="keyword"
                        class="form-control border-0 shadow-none"
                        placeholder="Nhập tên tài liệu, môn học, tác giả..."
                        value="{{ request('keyword') }}"
                        style="font-size: 1rem;">

                    <button class="btn btn-warning rounded-pill px-4 fw-bold text-dark"
                        type="submit"
                        style="background-color: #fbbf24; border: none;">
                        Tìm kiếm
                    </button>
                </div>
            </form>

            {{-- Gợi ý từ khóa (Tags) --}}
            <div class="mt-3 small opacity-75">
                <span class="me-2"><i class="fas fa-tags me-1"></i>Phổ biến:</span>
                <a href="{{ route('home', ['keyword' => 'Laravel']) }}" class="text-white text-decoration-underline me-2">Laravel</a>
                <a href="{{ route('home', ['keyword' => 'Python']) }}" class="text-white text-decoration-underline me-2">Python</a>
                <a href="{{ route('home', ['keyword' => 'Đồ án']) }}" class="text-white text-decoration-underline">Đồ án tốt nghiệp</a>
            </div>
        </div>
    </div>
</div>

{{-- ... Phần Hero Banner ở trên giữ nguyên ... --}}

{{-- =========================================== --}}
{{-- 1. SECTION: DANH MỤC NỔI BẬT (FEATURED) --}}
{{-- =========================================== --}}
<div class="mb-5">
    <h5 class="fw-bold mb-4 text-dark border-start border-4 ps-3" style="border-color: var(--accent)!important;">
        Khám phá theo chủ đề
    </h5>

    <div class="row">
        @foreach($featuredCategories as $cat)
        <div class="col-md-3 mb-3">
            <a href="{{ route('home', ['cat' => $cat->id]) }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm cat-card" style="transition: all 0.3s;">
                    <div class="card-body d-flex align-items-center p-3">
                        {{-- Icon giả lập (Dùng màu ngẫu nhiên hoặc fix cứng) --}}
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px; background-color: rgba(72, 166, 167, 0.1); color: var(--accent);">
                            <i class="fas fa-folder-open fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $cat->name }}</h6>
                            <small class="text-muted">{{ $cat->documents_count }} tài liệu</small>
                        </div>
                        <div class="ms-auto">
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- =========================================== --}}
{{-- 2. SECTION: TÀI LIỆU XEM NHIỀU (TRENDING) --}}
{{-- =========================================== --}}
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0 text-dark border-start border-4 ps-3" style="border-color: #ffc107!important;">
            Tài liệu phổ biến
        </h5>
        <span class="badge bg-warning text-dark"><i class="fas fa-fire me-1"></i>Trending</span>
    </div>

    <div class="row">
        @foreach($popularDocs as $pDoc)
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body d-flex align-items-center p-3">
                    {{-- Icon bên trái --}}
                    <div class="me-3 text-center" style="min-width: 50px;">
                        @if($pDoc->type == 'PDF') <i class="fas fa-file-pdf fa-2x text-danger"></i>
                        @elseif($pDoc->type == 'DOCX') <i class="fas fa-file-word fa-2x text-primary"></i>
                        @else <i class="fas fa-file fa-2x text-secondary"></i>
                        @endif
                    </div>

                    {{-- Thông tin bên phải --}}
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-1 fw-bold text-truncate">
                            <a href="{{ route('document.show', $pDoc->id) }}" class="text-dark text-decoration-none stretched-link">
                                {{ $pDoc->title }}
                            </a>
                        </h6>
                        <div class="d-flex align-items-center text-muted small">
                            <span class="me-3"><i class="fas fa-user me-1"></i>{{ $pDoc->author->fullname ?? 'Admin' }}</span>
                            <span><i class="fas fa-calendar me-1"></i>{{ $pDoc->created_at->format('d/m') }}</span>
                        </div>
                    </div>

                    {{-- Nút download nhỏ --}}
                    <div class="ms-3">
                        <button class="btn btn-light btn-sm rounded-circle text-primary">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ... Phần "Tài liệu mới cập nhật" cũ của bạn giữ nguyên ở dưới ... --}}

{{-- 2. DANH SÁCH TÀI LIỆU --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold m-0 text-dark border-start border-4 border-primary ps-3" style="border-color: var(--accent)!important;">
        Tài liệu mới cập nhật
    </h5>

    {{-- Bộ lọc nhanh (Optional) --}}
    @if(request('keyword') || request('cat'))
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="fas fa-sync-alt me-1"></i>Xem tất cả
    </a>
    @endif
</div>

<div class="row">
    @forelse($docs as $doc)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card doc-card h-100 position-relative">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-3">
                    {{-- Icon loại file --}}
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        @if($doc->type == 'PDF') <i class="fas fa-file-pdf fa-lg text-danger"></i>
                        @elseif($doc->type == 'DOCX') <i class="fas fa-file-word fa-lg text-primary"></i>
                        @elseif($doc->type == 'SLIDE') <i class="fas fa-file-powerpoint fa-lg text-warning"></i>
                        @else <i class="fas fa-file-alt fa-lg text-secondary"></i>
                        @endif
                    </div>
                    {{-- Badge danh mục --}}
                    <div>
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill text-truncate" style="max-width: 100px;">
                            {{ $doc->category->name ?? 'Khác' }}
                        </span>
                    </div>
                </div>

                <h6 class="card-title fw-bold mb-2">
                    <a href="{{ route('document.show', $doc->id) }}" class="text-decoration-none text-dark stretched-link link-hover">
                        {{ \Illuminate\Support\Str::limit($doc->title, 50) }}
                    </a>
                </h6>

                <div class="d-flex align-items-center text-muted small mb-2">
                    <i class="far fa-user me-1"></i> {{ \Illuminate\Support\Str::limit($doc->author->fullname ?? 'Unknown', 15) }}
                </div>
            </div>

            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-flex justify-content-between align-items-center small text-muted border-top pt-2">
                    <span><i class="far fa-clock me-1"></i>{{ $doc->created_at->format('d/m/Y') }}</span>
                    <span class="text-primary fw-bold" style="color: var(--accent)!important;">Xem chi tiết &rarr;</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" width="120" class="mb-3 opacity-50">
            <h5 class="text-muted fw-bold">Không tìm thấy tài liệu nào</h5>
            <p class="text-muted small">Thử tìm với từ khóa khác hoặc quay lại trang chủ.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Phân trang --}}
<div class="d-flex justify-content-center mt-4">
    {{ $docs->appends(request()->query())->links() }}
    {{-- appends() để giữ lại từ khóa tìm kiếm khi chuyển trang --}}
</div>

{{-- Thêm chút CSS riêng cho trang này để hiệu ứng đẹp hơn --}}
<style>
    .link-hover:hover {
        color: var(--accent) !important;
    }

    .doc-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
</style>

@endsection