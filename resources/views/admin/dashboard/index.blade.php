@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard</h3>
        <span class="text-muted">Hôm nay: {{ date('d/m/Y') }}</span>
    </div>

    {{-- 1. CÁC THẺ THỐNG KÊ (CARDS) --}}
    <div class="row mb-4">
        {{-- Card: Tổng văn bản --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Tổng Văn bản</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['documents'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300 opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Tổng thành viên --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Thành viên</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['users'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300 opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Danh mục --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Danh mục</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['categories'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-folder fa-2x text-gray-300 opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Admin --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Quản trị viên</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['admins'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-shield fa-2x text-gray-300 opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. HÀNG DƯỚI: BIỂU ĐỒ + BẢNG MỚI NHẤT --}}
    <div class="row">
        {{-- Cột Trái: Biểu đồ (Chiếm 8 phần) --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-bar me-2"></i>Thống kê tải lên năm {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="position: relative; height: 300px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột Phải: 5 Văn bản mới nhất (Chiếm 4 phần) --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Vừa cập nhật</h6>
                    <a href="{{ route('admin.documents.index') }}" class="small text-decoration-none">Xem tất cả &rarr;</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentDocuments as $doc)
                        <li class="list-group-item d-flex align-items-center p-3">
                            <div class="me-3">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    @if($doc->type == 'PDF') <i class="fas fa-file-pdf text-danger"></i>
                                    @elseif($doc->type == 'DOCX') <i class="fas fa-file-word text-primary"></i>
                                    @else <i class="fas fa-file text-secondary"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 text-truncate" title="{{ $doc->title }}">{{ $doc->title }}</h6>
                                <small class="text-muted">
                                    {{ $doc->author->fullname ?? 'Unknown' }} • {{ $doc->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted">Chưa có văn bản nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT VẼ BIỂU ĐỒ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData); 
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    
    // Gradient màu cho đẹp
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(78, 115, 223, 0.5)');
    gradient.addColorStop(1, 'rgba(78, 115, 223, 0.05)');

    new Chart(ctx, {
        type: 'line', // Đổi sang 'line' cho mềm mại (hoặc 'bar' nếu thích cột)
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            datasets: [{
                label: 'Văn bản mới',
                data: chartData,
                backgroundColor: gradient,
                borderColor: '#4e73df',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.3 // Làm cong đường biểu đồ
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }, // Ẩn chú thích cho gọn
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection