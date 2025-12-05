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
            --accent: #48a6a7;
            /* Màu chủ đạo cũ */
            --accent-hover: #2f7f80;
            /* Màu hover cũ */
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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

        .nav-link:hover,
        .nav-link.active {
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(72, 166, 167, 0.15);
            /* Bóng màu xanh ngọc nhẹ */
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
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
    {{-- PHẦN 3: FOOTER (Thay thế đoạn footer cũ) --}}
    <footer class="bg-white border-top pt-5 mt-auto">
        <div class="container">
            <div class="row">
                {{-- Cột 1: Thông tin hệ thống --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px; background-color: var(--accent); color: white;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <span class="fs-4 fw-bold" style="color: var(--text-dark);">DMS CNTT</span>
                    </a>
                    <p class="text-muted small mb-3">
                        Hệ thống lưu trữ và quản lý tài liệu nội bộ Khoa Công nghệ Thông tin.
                        Hỗ trợ sinh viên và giảng viên tra cứu đồ án, giáo trình nhanh chóng và hiệu quả.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-light border rounded-circle"><i class="fab fa-facebook-f text-secondary"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle"><i class="fab fa-github text-secondary"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle"><i class="fab fa-youtube text-secondary"></i></a>
                    </div>
                </div>

                {{-- Cột 2: Liên kết nhanh --}}
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Liên kết</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-muted footer-link">Trang chủ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted footer-link">Giới thiệu</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted footer-link">Hướng dẫn sử dụng</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted footer-link">Liên hệ Admin</a></li>
                    </ul>
                </div>

                {{-- Cột 3: Danh mục phổ biến --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Tài liệu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home', ['keyword' => 'Đồ án']) }}" class="text-decoration-none text-muted footer-link">Đồ án tốt nghiệp</a></li>
                        <li class="mb-2"><a href="{{ route('home', ['keyword' => 'Giáo trình']) }}" class="text-decoration-none text-muted footer-link">Giáo trình môn học</a></li>
                        <li class="mb-2"><a href="{{ route('home', ['keyword' => 'Đề thi']) }}" class="text-decoration-none text-muted footer-link">Ngân hàng đề thi</a></li>
                        <li class="mb-2"><a href="{{ route('home', ['keyword' => 'Slide']) }}" class="text-decoration-none text-muted footer-link">Slide bài giảng</a></li>
                    </ul>
                </div>

                {{-- Cột 4: Liên hệ --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Liên hệ</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt mt-1 me-3" style="color: var(--accent);"></i>
                            <span>Tầng 5, Tòa nhà A1, Đại học Công nghệ, Số 144 Xuân Thủy, Cầu Giấy, Hà Nội</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-envelope mt-1 me-3" style="color: var(--accent);"></i>
                            <span>contact@fit-dms.edu.vn</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-phone-alt mt-1 me-3" style="color: var(--accent);"></i>
                            <span>(024) 3754 7xxx</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Dòng bản quyền dưới cùng --}}
            <div class="border-top py-4 mt-2">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0 text-muted small">
                            &copy; {{ date('Y') }} <strong>DMS CNTT</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-muted small text-decoration-none me-3 footer-link">Điều khoản</a>
                        <a href="#" class="text-muted small text-decoration-none footer-link">Bảo mật</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Thêm CSS riêng cho Footer vào @stack('styles') hoặc thẻ <style> --}}
    {{-- Nếu bạn đã tách CSS ra file public/css/app.css thì paste đoạn này vào đó --}}
    <style>
        /* Hiệu ứng hover cho link ở footer */
        .footer-link {
            transition: all 0.2s;
        }

        .footer-link:hover {
            color: var(--accent) !important;
            padding-left: 5px;
            /* Hiệu ứng trượt nhẹ sang phải */
        }

        /* Chỉnh lại nút social */
        .btn-light.border:hover {
            background-color: var(--accent);
            border-color: var(--accent) !important;
        }

        .btn-light.border:hover i {
            color: white !important;
        }
    </style>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>