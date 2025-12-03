<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DMS CNTT - Thư viện Tài liệu')</title>

    {{-- 1. Font & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- 2. Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* GIỮ LẠI TÔNG MÀU CŨ CỦA BẠN NHƯNG ÁP DỤNG CHO BOOTSTRAP */
        :root {
            --bg: #f6f7fb;
            --accent: #48a6a7;       /* Màu chủ đạo cũ */
            --accent-hover: #2f7f80; /* Màu hover cũ */
            --text-dark: #0f172a;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Tùy chỉnh Navbar */
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--accent) !important;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .nav-link {
            font-weight: 600;
            color: #6b7280;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent);
        }

        /* Tùy chỉnh Button theo màu cũ của bạn */
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            font-weight: 700;
            border-radius: 10px;
            padding: 8px 20px;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
            font-weight: 700;
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background-color: var(--accent);
            color: #fff;
        }

        /* Style cho Card Văn bản (Dùng ở trang Home) */
        .doc-card {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(72, 166, 167, 0.15); /* Bóng màu xanh ngọc nhẹ */
        }

        /* Footer */
        footer {
            background: #fff;
            margin-top: auto;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

    {{-- PHẦN 1: NAVBAR (MENU TRÊN CÙNG) --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-layer-group me-2"></i>DMS CNTT
            </a>
            
            {{-- Nút Toggle Mobile --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu Content --}}
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    
                    {{-- Dropdown Danh mục (Nếu bạn muốn hiển thị nhanh) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="catDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" style="border-radius: 12px;">
                            {{-- Bạn có thể share biến $categories global sau, tạm thời để link mẫu --}}
                            <li><a class="dropdown-item" href="{{ route('home', ['keyword' => 'Giáo trình']) }}">Giáo trình</a></li>
                            <li><a class="dropdown-item" href="{{ route('home', ['keyword' => 'Đồ án']) }}">Đồ án tốt nghiệp</a></li>
                        </ul>
                    </li>
                </ul>

                {{-- Phần User / Đăng nhập --}}
                <div class="d-flex align-items-center gap-2">
                    @auth
                        {{-- Nếu đã đăng nhập --}}
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 32px; height: 32px; font-size: 14px; background-color: var(--accent)!important;">
                                    {{ substr(Auth::user()->fullname ?? 'U', 0, 1) }}
                                </div>
                                <span class="d-none d-md-inline small fw-bold">{{ Auth::user()->fullname }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" style="border-radius: 12px;">
                                @if(Auth::user()->role === 'ADMIN')
                                    <li><a class="dropdown-item text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Vào trang Admin
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        {{-- Nếu chưa đăng nhập --}}
                        <a href="{{ route('login.form') }}" class="btn btn-outline-primary btn-sm border-2">Đăng nhập</a>
                        <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- PHẦN 2: NỘI DUNG CHÍNH (Đẩy xuống dưới Navbar) --}}
    <main class="container" style="margin-top: 100px; padding-bottom: 40px;">
        @yield('content')
    </main>

    {{-- PHẦN 3: FOOTER --}}
    <footer class="py-4 text-center">
        <div class="container">
            <p class="mb-0 text-muted small">
                &copy; {{ date('Y') }} <strong>DMS CNTT</strong>. Hệ thống quản lý văn bản Khoa CNTT.
            </p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>