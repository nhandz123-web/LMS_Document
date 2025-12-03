@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/dashboard_index.css')}}">
</head>
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-tachometer-alt me-2" style="color: #4e73df;"></i>Dashboard
            </h2>
            <p class="text-muted mb-0">Chào mừng trở lại! Đây là tổng quan hệ thống của bạn</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-inline-block bg-light rounded-3 px-3 py-2">
                <i class="fas fa-calendar-day me-2 text-primary"></i>
                <span class="fw-semibold">{{ date('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Card: Tổng văn bản --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Tổng Văn bản</p>
                            <h3 class="fw-bold mb-0" style="color: #4e73df;">{{ $stats['documents'] }}</h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-alt fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" style="width: 75%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Thành viên --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Thành viên</p>
                            <h3 class="fw-bold mb-0" style="color: #1cc88a;">{{ $stats['users'] }}</h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 60%; background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%) !important;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Danh mục --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Danh mục</p>
                            <h3 class="fw-bold mb-0" style="color: #36b9cc;">{{ $stats['categories'] }}</h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-folder fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" style="width: 85%; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Admin --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Quản trị viên</p>
                            <h3 class="fw-bold mb-0" style="color: #f6c23e;">{{ $stats['admins'] }}</h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-shield fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" style="width: 50%; background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart and Recent Documents --}}
    <div class="row g-4">
        {{-- Chart Section --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold" style="color: #4e73df;">
                                <i class="fas fa-chart-line me-2"></i>Thống kê tải lên
                            </h5>
                            <p class="text-muted mb-0 small">Biểu đồ văn bản theo tháng năm {{ date('Y') }}</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Xuất dữ liệu</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>In báo cáo</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="position: relative; height: 320px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Documents --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold" style="color: #4e73df;">
                                <i class="fas fa-clock me-2"></i>Vừa cập nhật
                            </h5>
                            <p class="text-muted mb-0 small">5 văn bản mới nhất</p>
                        </div>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-primary">
                            Xem tất cả
                        </a>
                    </div>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentDocuments as $index => $doc)
                    <div class="document-item p-3 border-bottom" style="transition: all 0.3s ease;">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <div class="file-icon-wrapper d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; border-radius: 10px; 
                                    @if($doc->type == 'PDF') background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
                                    @elseif($doc->type == 'DOCX') background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                                    @else background: linear-gradient(135deg, #858796 0%, #60616f 100%);
                                    @endif">
                                    @if($doc->type == 'PDF') 
                                        <i class="fas fa-file-pdf text-white"></i>
                                    @elseif($doc->type == 'DOCX') 
                                        <i class="fas fa-file-word text-white"></i>
                                    @else 
                                        <i class="fas fa-file text-white"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 text-truncate fw-semibold" style="color: #2d3748;" title="{{ $doc->title }}">
                                    {{ $doc->title }}
                                </h6>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <span class="me-2">{{ $doc->author->fullname ?? 'Unknown' }}</span>
                                    <i class="fas fa-clock me-1"></i>
                                    <span>{{ $doc->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Chưa có văn bản nào</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS --}}


{{-- Chart Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const chartData = @json($chartData); 
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    
    // Gradient cho đường biểu đồ
    const gradientFill = ctx.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, 'rgba(78, 115, 223, 0.2)');
    gradientFill.addColorStop(1, 'rgba(78, 115, 223, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Văn bản mới',
                data: chartData,
                backgroundColor: gradientFill,
                borderColor: '#4e73df',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#4e73df',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    display: false 
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { 
                        stepSize: 1,
                        font: { size: 11 },
                        color: '#858796'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: { 
                    grid: { 
                        display: false 
                    },
                    ticks: {
                        font: { size: 11 },
                        color: '#858796'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

</script>
@endsection