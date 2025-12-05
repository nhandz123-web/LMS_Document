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
            <a href="{{ route('category.show', $cat->id) }}" class="text-decoration-none">
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
            <div class="card border-0 shadow-sm h-100 hover-shadow overflow-hidden">
                <div class="card-body d-flex align-items-center p-3">
                    
                    {{-- 1. KHUNG ẢNH BÌA (Thumbnail) --}}
                    <div class="me-3 flex-shrink-0 position-relative rounded overflow-hidden" 
                         style="width: 70px; height: 95px; background: #f8f9fa;">
                        
                        @if($pDoc->cover_image)
                            {{-- Nếu có ảnh bìa --}}
                            <img src="{{ asset('storage/' . $pDoc->cover_image) }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;" 
                                 alt="{{ $pDoc->title }}">
                        @else
                            {{-- Nếu chưa có ảnh -> Hiện Icon trên nền màu --}}
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
                                @if($pDoc->type == 'PDF') <i class="fas fa-file-pdf fa-2x text-danger opacity-75"></i>
                                @elseif($pDoc->type == 'DOCX') <i class="fas fa-file-word fa-2x text-primary opacity-75"></i>
                                @else <i class="fas fa-file-alt fa-2x text-secondary opacity-75"></i>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- 2. THÔNG TIN BÊN PHẢI --}}
                    <div class="flex-grow-1 overflow-hidden">
                        {{-- Badge danh mục nhỏ --}}
                        <div class="mb-1">
                            <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">
                                {{ $pDoc->category->name ?? 'Khác' }}
                            </span>
                        </div>

                        <h6 class="mb-1 fw-bold text-truncate" style="line-height: 1.4;">
                            <a href="{{ route('document.show', $pDoc->id) }}" class="text-dark text-decoration-none stretched-link">
                                {{ $pDoc->title }}
                            </a>
                        </h6>
                        
                        <div class="d-flex align-items-center text-muted small mt-2">
                            <span class="me-3">
                                <i class="fas fa-user-circle me-1"></i>{{ Str::limit($pDoc->author->fullname ?? 'Admin', 10) }}
                            </span>
                            <span>
                                <i class="fas fa-calendar-alt me-1"></i>{{ $pDoc->created_at->format('d/m') }}
                            </span>
                        </div>
                    </div>

                    {{-- 3. NÚT DOWNLOAD NHỎ (Vẫn giữ lại) --}}
                    <div class="ms-3 d-none d-sm-block">
                        <button class="btn btn-light btn-sm rounded-circle text-primary shadow-sm" 
                                style="width: 35px; height: 35px;">
                            <i class="fas fa-download fa-sm"></i>
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
        <div class="card doc-card h-100 position-relative border-0 shadow-sm">
            {{-- PHẦN ẢNH BÌA --}}
            <div class="position-relative" style="height: 180px; overflow: hidden; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                @if($doc->cover_image)
                <img src="{{ asset('storage/' . $doc->cover_image) }}"
                    class="w-100 h-100"
                    style="object-fit: cover; transition: transform 0.3s;"
                    alt="{{ $doc->title }}">
                @else
                {{-- Nếu không có ảnh thì hiện nền màu Gradient mặc định --}}
                <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                    style="background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);">
                    @if($doc->type == 'PDF') <i class="fas fa-file-pdf fa-4x text-danger opacity-50"></i>
                    @elseif($doc->type == 'DOCX') <i class="fas fa-file-word fa-4x text-primary opacity-50"></i>
                    @else <i class="fas fa-file-alt fa-4x text-secondary opacity-50"></i>
                    @endif
                </div>
                @endif

                {{-- Badge loại file nằm đè lên góc ảnh --}}
                <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-75">
                    {{ $doc->type }}
                </span>
            </div>

            {{-- PHẦN NỘI DUNG --}}
            <div class="card-body p-3">
                {{-- Badge danh mục nhỏ --}}
                <div class="mb-2">
                    <span class="badge bg-light text-secondary border small">{{ $doc->category->name ?? 'Khác' }}</span>
                </div>

                <h6 class="card-title fw-bold mb-2" style="line-height: 1.4; height: 2.8em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    <a href="{{ route('document.show', $doc->id) }}" class="text-decoration-none text-dark stretched-link link-hover">
                        {{ $doc->title }}
                    </a>
                </h6>

                <div class="d-flex align-items-center text-muted small">
                    <i class="far fa-user me-1"></i> {{ Str::limit($doc->author->fullname ?? 'Unknown', 15) }}
                </div>
            </div>

            {{-- Footer Card --}}
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-flex justify-content-between align-items-center small text-muted border-top pt-2">
                    <span><i class="far fa-clock me-1"></i>{{ $doc->created_at->format('d/m/Y') }}</span>
                    <span class="text-primary fw-bold">Xem &rarr;</span>
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