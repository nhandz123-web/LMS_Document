<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Hệ thống quản lý</title>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>

<body>
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-rocket"></i>
            </div>
            <span>AdminHub</span>
        </a>

        <ul class="sidebar-menu">
            <li class="menu-section">
                <div class="menu-section-title">Tổng quan</div>
                <ul class="list-unstyled">
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}" 
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-section">
                <div class="menu-section-title">Quản lý nội dung</div>
                <ul class="list-unstyled">
                    <li class="nav-item">
                        <a href="{{ route('admin.documents.index') }}"
                           class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Văn bản</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-folder-open"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-section">
                <div class="menu-section-title">Người dùng</div>
                <ul class="list-unstyled">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Thành viên</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-section">
                <div class="menu-section-title">Hệ thống</div>
                <ul class="list-unstyled">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Cài đặt</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        {{-- TOPBAR --}}
        <nav class="topbar">
            <div class="topbar-left">
                <h1 class="topbar-title">Hệ thống Quản lý Tài liệu</h1>
            </div>

            <div class="topbar-search d-none d-lg-block">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm văn bản, thành viên...">
            </div>

            <div class="topbar-actions">
                <button class="topbar-btn" title="Thông báo">
                    <i class="fas fa-bell"></i>
                    <span class="badge-dot"></span>
                </button>

                <button class="topbar-btn d-none d-md-flex" title="Tin nhắn">
                    <i class="fas fa-envelope"></i>
                </button>

                {{-- User Dropdown --}}
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->fullname ?? 'A', 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->fullname ?? 'Administrator' }}</div>
                            <div class="user-role">{{ Auth::user()->role ?? 'Admin' }}</div>
                        </div>
                        <i class="fas fa-chevron-down" style="color: #9ca3af; font-size: 0.75rem;"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user"></i>
                                Hồ sơ cá nhân
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i>
                                Cài đặt
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- CONTENT BODY --}}
        <div class="content-body">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer class="footer">
            <p class="footer-text">
                © {{ date('Y') }} Hệ thống Quản lý Văn bản. Phát triển bởi <strong>Admin Team</strong>
            </p>
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>