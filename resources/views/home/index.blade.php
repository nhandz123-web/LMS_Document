@extends('layouts.app')

@section('title', 'Trang chủ - Tra cứu tài liệu')

@section('content')

<style>
    :root {
        --primary: #2563eb;
        --accent: #48a6a7;
        --warning: #fbbf24;
        --danger: #ef4444;
        --dark: #1f2937;
        --light: #f9fafb;
    }

    /* =================== HERO SECTION =================== */
    .hero-wrapper {
        position: relative;
        background-color: #000;
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("images/thuvien.jpg") }}');
        background-size: cover;
        background-position: center;
        z-index: 0;
        animation: zoomIn 20s infinite alternate;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.85), rgba(0, 0, 0, 0.7));
        z-index: 0;
    }

    @keyframes zoomIn {
        from { transform: scale(1); }
        to { transform: scale(1.08); }
    }

    .hero-content {
        min-height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-wrapper h1,
    .hero-wrapper p {
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    /* =================== CATEGORY CARDS =================== */
    .cat-card {
        transition: all 0.3s ease;
        background: white;
        border-radius: 0.75rem;
    }

    .cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    .cat-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(72, 166, 167, 0.1));
        border-radius: 50%;
    }

    /* =================== DOCUMENT CARDS =================== */
    .doc-card {
        transition: all 0.3s ease;
        border-radius: 1rem;
        overflow: hidden;
    }

    .doc-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12) !important;
    }

    .doc-cover {
        height: 250px;
        background: linear-gradient(135deg, #e0e7ff 0%, #fce7f3 100%);
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem 0.5rem 0 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .doc-card {
        max-width: calc(100% - 20px);
        margin: 0 auto;
    }

    .doc-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.4s ease, filter 0.3s ease;
    }

    .doc-card:hover .doc-cover img {
        transform: scale(1.08);
        filter: brightness(0.95);
    }

    /* Overlay effect on hover */
    .doc-cover::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .doc-card:hover .doc-cover::after {
        opacity: 1;
    }

    /* Author text styling */
    .doc-card .small,
    .trending-card .small {
        font-size: 0.7rem;
    }

    /* Document card title styling */
    .doc-card .card-title {
        font-size: 0.95rem;
        line-height: 1.4;
        min-height: 2.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0 !important;
    }

    .doc-card .card-title a {
        color: #1f2937 !important;
        font-weight: 600 !important;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .doc-card:hover .card-title a {
        color: var(--primary) !important;
    }

    /* =================== TRENDING SECTION =================== */
    .trending-card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }

    .trending-card:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08) !important;
    }

    .trending-thumb {
        width: 100px;
        height: 140px;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* =================== SECTION HEADERS =================== */
    .section-header {
        position: relative;
        padding-left: 1rem;
    }

    .section-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: 4px;
        background: linear-gradient(180deg, var(--primary), var(--accent));
    }

    /* =================== BADGES & BUTTONS =================== */
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .btn-custom {
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    /* =================== MOBILE RESPONSIVE =================== */
    @media (max-width: 768px) {
        /* Hero Section */
        .hero-content {
            min-height: 320px !important;
            padding: 2rem 1rem !important;
        }

        .hero-wrapper h1 {
            font-size: 1.75rem !important;
            margin-bottom: 0.75rem !important;
        }

        .hero-wrapper p.lead {
            font-size: 0.95rem !important;
            margin-bottom: 1.25rem !important;
        }

        .hero-wrapper .btn {
            padding: 0.65rem 1.5rem !important;
            font-size: 0.9rem !important;
        }

        .carousel-indicators {
            bottom: 0.5rem !important;
        }

        /* Horizontal Scroll for Categories & Documents */
        .mobile-scroll {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            gap: 1rem;
            padding-bottom: 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .mobile-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Category Cards Mobile */
        .mobile-scroll .col-md-3 {
            flex: 0 0 280px;
            max-width: 280px;
            scroll-snap-align: start;
        }

        /* Document Cards Mobile */
        .mobile-scroll .col-lg-3 {
            flex: 0 0 160px;
            max-width: 160px;
            scroll-snap-align: start;
        }

        .doc-cover {
            height: 240px !important;
        }

        .doc-card {
            max-width: 210px !important;
        }

        .doc-card h6 {
            font-size: 0.875rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Trending Cards Mobile */
        .mobile-scroll .col-lg-6 {
            flex: 0 0 calc(100% - 2rem);
            max-width: calc(100% - 2rem);
            scroll-snap-align: start;
        }

        .trending-thumb {
            width: 70px;
            height: 95px;
        }

        /* Section Headers */
        .section-header {
            font-size: 1.125rem !important;
        }

        /* Hide download button on mobile */
        .mobile-hide {
            display: none !important;
        }

        /* Button Groups */
        .button-group-mobile {
            flex-direction: column !important;
            gap: 0.75rem !important;
        }

        .button-group-mobile .btn {
            width: 100% !important;
        }
    }

    /* Tablet Responsive */
    @media (min-width: 769px) and (max-width: 1024px) {
        .doc-cover {
            height: 200px;
        }

        .col-md-4.doc-col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    /* Desktop Enhancements */
    @media (min-width: 1025px) {
        .container {
            max-width: 1320px;
        }

        .doc-cover {
            height: 270px;
        }

        .doc-card {
            max-width: calc(100% - 10px);
        }

        .doc-card h6 {
            font-size: 1rem;
        }

        .trending-thumb {
            width: 120px;
            height: 160px;
        }

        .trending-card h6 {
            font-size: 1.05rem;
        }
    }

    /* Extra Large Desktop */
    @media (min-width: 1400px) {
        .container {
            max-width: 1400px;
        }

        .doc-cover {
            height: 290px;
        }

        .doc-card {
            max-width: calc(100% - 10px);
        }
    }
    
    /* =================== HORIZONTAL SCROLL WRAPPER (GLOBAL) =================== */
    .horizontal-scroll-wrapper {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 1.5rem;
        padding-bottom: 1rem;
        /* Custom Scrollbar for better UX */
        /* scrollbar-width: thin;
        scrollbar-color: var(--primary) transparent;
        -webkit-overflow-scrolling: touch; */
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    /* .horizontal-scroll-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(37, 99, 235, 0.3);
        border-radius: 20px;
    } */

    /* .horizontal-scroll-wrapper:hover::-webkit-scrollbar-thumb {
        background-color: var(--primary);
    } */

    .scroll-card-item {
        flex: 0 0 auto;
        width: 250px;
    }

    @media (min-width: 768px) {
        .scroll-card-item {
            width: 280px;
        }
    }
</style>

{{-- =================== HERO CAROUSEL =================== --}}
<div class="hero-wrapper shadow-sm">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div id="heroCarousel" class="carousel slide position-relative" style="z-index: 1;" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            {{-- Slide 1 --}}
            <div class="carousel-item active" data-bs-interval="5000">
                <div class="hero-content text-center px-3">
                    <div class="col-12 col-lg-9 mx-auto text-white">
                        <span class="badge badge-custom bg-white text-primary mb-3">
                            <i class="fas fa-university me-2"></i>Thư viện số
                        </span>
                        <h1 class="display-4 fw-bold mb-3">Kho Tài Liệu CNTT</h1>
                        <p class="lead mb-4 opacity-90">Nơi lưu trữ, chia sẻ đồ án, giáo trình và tài liệu nghiên cứu chính thống</p>
                        <div class="d-flex justify-content-center gap-3 button-group-mobile">
                            <a href="#featured" class="btn btn-custom btn-primary shadow">
                                <i class="fas fa-compass me-2"></i>Khám phá ngay
                            </a>
                            <a href="#" class="btn btn-custom btn-outline-light">
                                <i class="fas fa-play-circle me-2"></i>Giới thiệu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="carousel-item" data-bs-interval="5000">
                <div class="hero-content text-center px-3">
                    <div class="col-12 col-lg-9 mx-auto text-white">
                        <span class="badge badge-custom bg-warning text-dark mb-3">
                            <i class="fas fa-graduation-cap me-2"></i>Tốt nghiệp
                        </span>
                        <h1 class="display-4 fw-bold mb-3">Đồ Án Xuất Sắc</h1>
                        <p class="lead mb-4 opacity-90">Tham khảo cấu trúc, source code và báo cáo của các khóa trước</p>
                        <a href="{{ route('home', ['keyword' => 'Đồ án']) }}" class="btn btn-custom btn-warning text-dark shadow">
                            <i class="fas fa-folder-open me-2"></i>Xem danh sách
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="carousel-item" data-bs-interval="5000">
                <div class="hero-content text-center px-3">
                    <div class="col-12 col-lg-9 mx-auto text-white">
                        <span class="badge badge-custom bg-danger text-white mb-3">
                            <i class="fas fa-heart me-2"></i>Cộng đồng
                        </span>
                        <h1 class="display-4 fw-bold mb-3">Chia Sẻ Tri Thức</h1>
                        <p class="lead mb-4 opacity-90">Đừng để tài liệu nằm yên. Hãy chia sẻ để giúp đỡ các khóa sau</p>
                        <a href="#" class="btn btn-custom btn-light text-danger shadow">
                            <i class="fas fa-upload me-2"></i>Gửi tài liệu đóng góp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></span>
        </button>
    </div>
</div>

<div id="featured"></div>

{{-- =================== FEATURED CATEGORIES =================== --}}
<div class="mb-5">
    <h5 class="section-header fw-bold mb-4 text-dark">
        Khám phá theo chủ đề
    </h5>

    <div class="row mobile-scroll g-3">
        @foreach($featuredCategories as $cat)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="{{ route('category.show', $cat->id) }}" class="text-decoration-none">
                <div class="card cat-card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="cat-icon d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-folder-open fa-lg" style="color: var(--accent);"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $cat->name }}</h6>
                            <small class="text-muted">{{ $cat->documents_count }} tài liệu</small>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- =================== TRENDING DOCUMENTS =================== --}}
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="section-header fw-bold m-0 text-dark">
            Tài liệu phổ biến
        </h5>
        <span class="badge bg-warning text-dark">
            <i class="fas fa-fire me-1"></i>Trending
        </span>
    </div>

    <div class="row mobile-scroll g-3">
        @foreach($popularDocs as $pDoc)
        <div class="col-lg-6">
            <div class="card trending-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="trending-thumb me-3">
                        @if($pDoc->cover_image)
                        <img src="{{ asset('storage/' . $pDoc->cover_image) }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover; object-position: center top;"
                             alt="{{ $pDoc->title }}"
                             loading="lazy">
                        @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                            @if($pDoc->type == 'PDF')
                            <i class="fas fa-file-pdf fa-2x text-danger opacity-50"></i>
                            @elseif($pDoc->type == 'DOCX')
                            <i class="fas fa-file-word fa-2x text-primary opacity-50"></i>
                            @else
                            <i class="fas fa-file-alt fa-2x text-secondary opacity-50"></i>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div class="flex-grow-1 overflow-hidden">
                        <span class="badge bg-light text-secondary border mb-2" style="font-size: 0.7rem;">
                            {{ $pDoc->category->name ?? 'Khác' }}
                        </span>
                        <h6 class="mb-2 fw-bold">
                            <a href="{{ route('document.show', $pDoc->id) }}" 
                               class="text-dark text-decoration-none stretched-link">
                                {{ Str::limit($pDoc->title, 50) }}
                            </a>
                        </h6>
                        <div class="d-flex align-items-center text-muted small">
                            <span class="me-3">
                                <i class="fas fa-user-circle me-1"></i>{{ Str::limit($pDoc->author->fullname ?? 'Admin', 12) }}
                            </span>
                            <span>
                                <i class="fas fa-calendar-alt me-1"></i>{{ $pDoc->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="ms-3 mobile-hide">
                        <a href="{{ route('document.show', $pDoc->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm" 
                           style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-download text-primary"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- =================== LATEST DOCUMENTS =================== --}}
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="section-header fw-bold m-0 text-dark">
            Tài liệu mới cập nhật
        </h5>
        @if(request('keyword') || request('cat'))
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="fas fa-sync-alt me-1"></i>Xem tất cả
        </a>
        @endif
    </div>

    <div class="horizontal-scroll-wrapper">
        @forelse($docs as $doc)
        <div class="scroll-card-item">
            <div class="card doc-card h-100 border-0 shadow-sm">
                <div class="doc-cover">
                    @if($doc->cover_image)
                    <img src="{{ asset('storage/' . $doc->cover_image) }}" 
                         alt="{{ $doc->title }}"
                         loading="lazy"
                         onload="this.style.opacity=1"
                         style="opacity: 0; transition: opacity 0.3s ease;">
                    @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        @if($doc->type == 'PDF')
                        <i class="fas fa-file-pdf fa-4x text-danger opacity-25"></i>
                        @elseif($doc->type == 'DOCX')
                        <i class="fas fa-file-word fa-4x text-primary opacity-25"></i>
                        @else
                        <i class="fas fa-file-alt fa-4x text-secondary opacity-25"></i>
                        @endif
                    </div>
                    @endif
                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark">{{ $doc->type }}</span>
                </div>

                <div class="card-body p-3">
                    <span class="badge bg-light text-secondary border mb-2" style="font-size: 0.7rem;">
                        {{ $doc->category->name ?? 'Khác' }}
                    </span>
                    <h6 class="card-title fw-bold mb-2">
                        <a href="{{ route('document.show', $doc->id) }}" 
                           class="text-decoration-none text-dark stretched-link">
                            {{ Str::limit($doc->title, 50) }}
                        </a>
                    </h6>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="far fa-user me-1"></i>
                        <span>{{ Str::limit($doc->author->fullname ?? 'Admin', 15) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">Chưa có tài liệu nào</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $docs->appends(request()->query())->links() }}
</div>

@endsection