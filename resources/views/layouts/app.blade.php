<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hệ thống quản lý tài liệu DMS CNTT - Tra cứu đồ án, giáo trình, tài liệu học tập">
    <title>@yield('title', 'DMS CNTT - Thư viện Tài liệu')</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: rgba(37, 99, 235, 0.1);
            --accent: #0056b3;
            --accent-hover: #004494;
            --secondary-yellow: #fbbf24;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* =================== NAVBAR =================== */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-2px);
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Search Bar */
        .search-header input {
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .search-header input:focus {
            box-shadow: 0 0 0 3px var(--primary-light);
            background-color: white !important;
        }

        .search-header button {
            border: none;
            background: transparent;
        }

        .search-header button:hover i {
            color: var(--primary) !important;
        }

        /* User Avatar */
        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.6rem 1.2rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--bg-light);
            color: var(--primary) !important;
            transform: translateX(5px);
        }

        /* =================== BUTTONS =================== */
        .btn {
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* =================== FOOTER =================== */
        footer {
            background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
            margin-top: auto;
        }

        .footer-link {
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-link:hover {
            color: var(--primary) !important;
            transform: translateX(5px);
        }

        .footer-logo {
            transition: all 0.3s ease;
        }

        .footer-logo:hover {
            transform: scale(1.05);
        }

        .social-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            transform: translateY(-3px);
        }

        .social-btn:hover i {
            color: white !important;
        }

        /* =================== UTILITIES =================== */
        .text-primary,
        .text-accent {
            color: var(--primary) !important;
        }

        .bg-primary,
        .bg-accent {
            background-color: var(--primary) !important;
        }

        .border-primary {
            border-color: var(--primary) !important;
        }

        /* =================== MOBILE RESPONSIVE =================== */
        @media (max-width: 991px) {
            .navbar {
                height: auto !important;
                padding: 0.75rem 0;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-brand img {
                height: 40px !important;
            }

            .search-header {
                margin: 1rem 0 !important;
            }

            .navbar-nav {
                padding-top: 1rem;
                gap: 0 !important;
            }

            .nav-item {
                padding: 0.5rem 0;
            }

            .nav-link::after {
                display: none;
            }

            .dropdown-menu {
                border: 1px solid var(--border-color);
                box-shadow: none;
            }

            main {
                margin-top: 80px !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                height: 36px !important;
            }

            .navbar-brand span {
                font-size: 1rem !important;
            }

            .search-header input {
                font-size: 0.85rem;
                height: 38px !important;
            }

            main {
                padding-bottom: 2rem !important;
            }

            /* Footer Mobile Optimization */
            footer {
                padding-top: 2.5rem !important;
            }

            footer .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            /* Compact columns on mobile */
            footer .col-lg-4,
            footer .col-lg-2,
            footer .col-lg-3 {
                margin-bottom: 2rem !important;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            /* Logo section */
            footer .footer-logo {
                margin-bottom: 0.75rem !important;
            }

            footer .footer-logo .rounded-circle {
                width: 36px !important;
                height: 36px !important;
            }

            footer .footer-logo span {
                font-size: 1.25rem !important;
            }

            footer .col-lg-4 p {
                font-size: 0.8rem !important;
                margin-bottom: 1rem !important;
                line-height: 1.5;
            }

            /* Social buttons */
            footer .social-btn {
                width: 34px !important;
                height: 34px !important;
            }

            /* Section titles */
            footer h6 {
                font-size: 0.9rem !important;
                margin-bottom: 0.75rem !important;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid var(--border-color);
            }

            /* Links */
            footer .list-unstyled {
                margin-bottom: 0;
            }

            footer .list-unstyled li {
                margin-bottom: 0.5rem !important;
            }

            footer .list-unstyled li a,
            footer .list-unstyled li span {
                font-size: 0.8rem !important;
                line-height: 1.4;
            }

            /* Contact icons */
            footer .fa-map-marker-alt,
            footer .fa-envelope,
            footer .fa-phone-alt {
                font-size: 0.85rem;
                min-width: 18px;
            }

            /* Copyright section */
            footer .border-top {
                margin-top: 1rem !important;
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }

            footer .border-top p,
            footer .border-top a {
                font-size: 0.75rem !important;
            }

            /* Collapse some sections on mobile */
            footer .col-lg-2 {
                order: 3;
            }

            footer .col-lg-3:first-of-type {
                order: 2;
            }

            footer .col-lg-3:last-of-type {
                order: 4;
            }
        }

        /* Extra small devices */
        @media (max-width: 480px) {
            footer .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            footer .col-lg-4 p {
                font-size: 0.75rem !important;
            }

            footer .list-unstyled li a,
            footer .list-unstyled li span {
                font-size: 0.75rem !important;
            }

            footer h6 {
                font-size: 0.85rem !important;
            }
        }

        /* =================== SCROLLBAR =================== */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* =================== LOADING ANIMATION =================== */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
            z-index: 9999;
            animation: loading 1.5s ease-in-out infinite;
        }

        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg fixed-top border-bottom" style="height: 70px;">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/image.png') }}"
                    alt="DMS Logo"
                    class="me-2"
                    style="height: 50px; width: auto; object-fit: contain;">
                <span class="fw-bold" style="color: var(--primary);">DMS CNTT</span>
            </a>

            {{-- Toggle Button --}}
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar Content --}}
            <div class="collapse navbar-collapse" id="navbarContent">
                {{-- Search Bar --}}
                <form class="d-flex mx-auto my-2 my-lg-0 position-relative search-header"
                    action="{{ route('home') }}" method="GET" style="max-width: 500px; width: 100%;">
                    <input class="form-control rounded-pill ps-4 pe-5 bg-light border-0"
                        type="search" name="keyword"
                        placeholder="Tìm kiếm tài liệu, đồ án..."
                        value="{{ request('keyword') }}"
                        style="height: 42px;">
                    <button class="btn position-absolute top-50 end-0 translate-middle-y"
                        type="submit" style="width: 42px; height: 42px;">
                        <i class="fas fa-search text-muted"></i>
                    </button>
                </form>

                {{-- Nav Menu --}}
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1 d-lg-none"></i>Trang chủ
                        </a>
                    </li>

                    {{-- Dropdown Categories --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-1 d-lg-none"></i>Danh mục
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2">
                            <li><a class="dropdown-item" href="{{ route('home', ['keyword' => 'Giáo trình']) }}">
                                <i class="fas fa-book me-2 text-primary"></i>Giáo trình
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('home', ['keyword' => 'Đồ án']) }}">
                                <i class="fas fa-graduation-cap me-2 text-success"></i>Đồ án
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-list me-2 text-muted"></i>Tất cả
                            </a></li>
                        </ul>
                    </li>

                    {{-- User Menu --}}
                    @auth
                    <li class="nav-item dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm">
                                {{ substr(Auth::user()->fullname ?? 'U', 0, 1) }}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 mt-2" style="min-width: 250px;">
                            <li class="px-3 py-2 border-bottom mb-2">
                                <div class="fw-bold text-dark">{{ Auth::user()->fullname }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                            </li>
                            @if(Auth::user()->role === 'ADMIN' || Auth::user()->role === 'GV')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>Trang quản trị
                            </a></li>
                            @endif
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2 text-info"></i>Thông tin cá nhân
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item mt-2 mt-lg-0">
                        <a href="{{ route('login.form') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm">
                            <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="container" style="margin-top: 100px; padding-bottom: 40px;">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-top pt-5">
        <div class="container">
            <div class="row">
                {{-- Column 1: About --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('home') }}" class="footer-logo d-flex align-items-center text-decoration-none mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <span class="fs-4 fw-bold" style="color: var(--text-dark);">DMS CNTT</span>
                    </a>
                    <p class="text-muted small mb-3 pe-lg-4">
                        Hệ thống lưu trữ và quản lý tài liệu nội bộ Khoa Công nghệ Thông tin.
                        Hỗ trợ sinh viên và giảng viên tra cứu nhanh chóng và hiệu quả.
                    </p>
                    <div class="d-flex gap-2 mb-3">
                        <a href="#" class="btn btn-sm btn-light border rounded-circle social-btn" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-secondary"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle social-btn" aria-label="GitHub">
                            <i class="fab fa-github text-secondary"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle social-btn" aria-label="YouTube">
                            <i class="fab fa-youtube text-secondary"></i>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Links --}}
                <div class="col-lg-2 col-md-6 col-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Liên kết</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-home me-1 d-md-none" style="width: 16px;"></i>Trang chủ
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-info-circle me-1 d-md-none" style="width: 16px;"></i>Giới thiệu
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-question-circle me-1 d-md-none" style="width: 16px;"></i>Hướng dẫn
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-envelope me-1 d-md-none" style="width: 16px;"></i>Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Documents --}}
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Tài liệu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <a href="{{ route('home', ['keyword' => 'Đồ án']) }}" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-graduation-cap me-1 d-md-none" style="width: 16px;"></i>Đồ án
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home', ['keyword' => 'Giáo trình']) }}" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-book me-1 d-md-none" style="width: 16px;"></i>Giáo trình
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home', ['keyword' => 'Đề thi']) }}" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-file-alt me-1 d-md-none" style="width: 16px;"></i>Đề thi
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home', ['keyword' => 'Slide']) }}" class="text-decoration-none text-muted footer-link">
                                <i class="fas fa-presentation me-1 d-md-none" style="width: 16px;"></i>Slide
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 4: Contact --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Liên hệ</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt mt-1 me-2 flex-shrink-0" style="color: var(--primary);"></i>
                            <span>Đại học Tây Nguyên, 567 Lê Duẩn, Eakao, Đắk Lắk</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-envelope mt-1 me-2 flex-shrink-0" style="color: var(--primary);"></i>
                            <a href="mailto:contact@fit-dms.edu.vn" class="text-muted text-decoration-none footer-link">
                                contact@fit-dms.edu.vn
                            </a>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-phone-alt mt-1 me-2 flex-shrink-0" style="color: var(--primary);"></i>
                            <a href="tel:02437547000" class="text-muted text-decoration-none footer-link">
                                (024) 3754 7xxx
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-top py-4 mt-2">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0 text-muted small">
                            &copy; {{ date('Y') }} <strong style="color: var(--primary);">DMS CNTT</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-muted small text-decoration-none me-3 footer-link">Điều khoản</a>
                        <span class="text-muted small d-none d-sm-inline">•</span>
                        <a href="#" class="text-muted small text-decoration-none ms-0 ms-sm-3 footer-link">Bảo mật</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.getElementById('navbarContent');
            const toggler = document.querySelector('.navbar-toggler');
            
            if (navbar && toggler && navbar.classList.contains('show')) {
                if (!navbar.contains(event.target) && !toggler.contains(event.target)) {
                    toggler.click();
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>