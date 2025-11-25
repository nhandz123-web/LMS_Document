<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Quản lý văn bản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #495057;
            color: white;
        }

        .card-icon {
            font-size: 2rem;
            opacity: 0.5;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <div class="sidebar p-3 d-none d-md-block" style="width: 250px;">
            <h4 class="text-white text-center mb-4">HỆ THỐNG VB</h4>
            <hr>
            <ul class="list-unstyled">
                <li><a href="{{ url('/admin/dashboard') }}" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li>
                    <a href="{{ route('admin.documents.index') }}"
                        class="{{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i> Quản lý Văn bản
                    </a>
                </li>
                <li><a href="{{ url('/admin/users') }}"><i class="fas fa-users me-2"></i> Quản lý User</a></li>
                <li><a href="#"><i class="fas fa-cogs me-2"></i> Cài đặt hệ thống</a></li>
            </ul>
        </div>

        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <span class="fw-bold">Trang quản trị</span>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                            Xin chào, {{ Auth::user()->fullname ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>