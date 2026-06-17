@extends('admin.includes.Template')

@section('content')

    <style>
        /* Vibrant Design Tokens */
        :root {
            --vc-blue: #0040E6;
            --vc-yellow: #FFD312;
            --gradient-main: linear-gradient(135deg, #0040E6 0%, #002b99 100%);
            --header-gradient: linear-gradient(135deg, #0040E6 0%, #002b99 100%);
        }


        /* 1. Improved Header & Vendor Name */
        .hero-banner {
            background: var(--header-gradient);
            border-radius: 24px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 12px 24px rgba(0, 64, 230, 0.15);
            position: relative;
        }

        .vendor-greeting {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .vendor-name-highlight {
            color: var(--vc-yellow);
            text-transform: capitalize;
        }

        /* Modern Header */
        .dashboard-header {
            background: var(--gradient-main);
            padding: 30px;
            border-radius: 20px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 64, 230, 0.2);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::after {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 211, 18, 0.2);
            border-radius: 50%;
        }

        /* Colorful Glass Cards */
        .color-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .color-card:hover {
            transform: translateY(-8px);
        }

        /* Specific Card Colors */
        .card-revenue {
            background: #eef2ff;
            border-bottom: 4px solid #4361ee;
        }

        .card-bookings {
            background: #fff9db;
            border-bottom: 4px solid #fab005;
        }

        .card-customers {
            background: #ebfbee;
            border-bottom: 4px solid #40c057;
        }

        .card-growth {
            background: #fff0f6;
            border-bottom: 4px solid #f06595;
        }

        .icon-box-lg {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        /* Glass Table */
        .table-container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid #f1f3f5;
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }



        /* 2. Refined Category Grids */
        .category-card {
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            border-color: var(--vc-blue);
            background: #f0f4ff;
        }

        .cat-icon {
            font-size: 24px;
            color: var(--vc-blue);
            margin-bottom: 10px;
            display: block;
        }
    </style>

    <div class="content container-fluid">

        @if ($message = Session::get('login_success'))
            <div class="alert alert-custom bg-white shadow-sm border-0 d-flex align-items-center mb-4"
                style="border-radius: 15px; border-left: 5px solid #2ecc71 !important;">
                <div class="bg-success text-white rounded-circle p-2 me-3">
                    <i class="fas fa-check"></i>
                </div>
                <div class="fw-bold text-dark">{{ $message }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- <div class="hero-banner shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="vendor-greeting">
                        Marhaba, <span class="vendor-name-highlight">{{ Auth::user()->name }}</span>! 👋
                    </h1>
                    <p class="lead opacity-75 mb-0">Manage your services and track your performance for today.</p>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <div class="bg-white text-dark d-inline-block px-4 py-2 rounded-pill shadow-sm fw-bold">
                        <i class="far fa-calendar-alt text-primary me-2"></i> {{ date('D, d M Y') }}
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1 ">Marhaba, {{ Auth::user()->name }}! 👋</h2>
                <p class="mb-0 ">Your VendorsCity business is growing. Here is your daily summary.</p>
            </div>
            <div class="d-none d-md-block">
                <div class="bg-white text-dark px-4 py-2 rounded-pill fw-bold shadow-sm">
                    <span class="text-primary"><i class="fas fa-calendar-alt"></i></span> {{ date('d M, Y') }}
                </div>
            </div>
        </div>

        {{-- <div class="row mb-4">
            <div class="col-12">
                <h5 class="fw-bold mb-3">Your Top Services</h5>
            </div>
            <div class="col-6 col-md-2">
                <div class="category-card shadow-sm">
                    <i class="fas fa-broom cat-icon"></i>
                    <span class="small fw-bold">Cleaning</span>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="category-card shadow-sm">
                    <i class="fas fa-snowflake cat-icon"></i>
                    <span class="small fw-bold">AC Repair</span>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="category-card shadow-sm">
                    <i class="fas fa-paint-roller cat-icon"></i>
                    <span class="small fw-bold">Painting</span>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="category-card shadow-sm">
                    <i class="fas fa-truck cat-icon"></i>
                    <span class="small fw-bold">Moving</span>
                </div>
            </div>
        </div> --}}
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Your Top Services</h5>
                {{-- <span class="badge rounded-pill bg-light text-dark border fw-medium small">Last 30 Days</span> --}}
            </div>

            <div class="col-6 col-md-3">
                <div class="category-card shadow-sm border-0 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">124
                            Done</span>
                    </div>
                    <i class="fas fa-broom cat-icon"></i>
                    <span class="small fw-bold d-block mb-1">Deep Cleaning</span>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="category-card shadow-sm border-0 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">86
                            Done</span>
                    </div>
                    <i class="fas fa-snowflake cat-icon"></i>
                    <span class="small fw-bold d-block mb-1">AC Repair</span>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="category-card shadow-sm border-0 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">42
                            Done</span>
                    </div>
                    <i class="fas fa-paint-roller cat-icon"></i>
                    <span class="small fw-bold d-block mb-1">Painting</span>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 35%"></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="category-card shadow-sm border-0 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">32
                            Done</span>
                    </div>
                    <i class="fas fa-truck cat-icon"></i>
                    <span class="small fw-bold d-block mb-1">Moving</span>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card color-card card-revenue shadow-sm">
                    <div class="card-body">
                        <div class="icon-box-lg bg-white text-primary shadow-sm"><i class="fas fa-chart-line"></i></div>
                        <h6 class="text-muted fw-bold small uppercase">Net Revenue</h6>
                        <h3 class="fw-bold mb-0">AED 14,290</h3>
                        <small class="text-success fw-bold"><i class="fas fa-caret-up"></i> +8.2%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card color-card card-bookings shadow-sm">
                    <div class="card-body">
                        <div class="icon-box-lg bg-white text-warning shadow-sm"><i class="fas fa-calendar-check"></i>
                        </div>
                        <h6 class="text-muted fw-bold small uppercase">Total Bookings</h6>
                        <h3 class="fw-bold mb-0">284</h3>
                        <small class="text-muted fw-bold">12 today</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card color-card card-customers shadow-sm">
                    <div class="card-body">
                        <div class="icon-box-lg bg-white text-success shadow-sm"><i class="fas fa-user-friends"></i></div>
                        <h6 class="text-muted fw-bold small uppercase">Loyal Clients</h6>
                        <h3 class="fw-bold mb-0">89</h3>
                        <small class="text-success fw-bold">High Retention</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card color-card card-growth shadow-sm">
                    <div class="card-body">
                        <div class="icon-box-lg bg-white text-danger shadow-sm"><i class="fas fa-award"></i></div>
                        <h6 class="text-muted fw-bold small uppercase">Performance</h6>
                        <h3 class="fw-bold mb-0">Top 5%</h3>
                        <small class="text-danger fw-bold">Elite Vendor</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i> New Service Requests</h5>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>SERVICE INFO</th>
                            <th>CUSTOMER</th>
                            <th>DATE</th>
                            <th>EARNINGS</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-bottom">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3 text-primary"><i class="fas fa-broom"></i></div>
                                    <div>
                                        <div class="fw-bold">Deep Cleaning</div>
                                        <div class="small text-muted">Order #VC-2024</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold">Zaid Al-Hamad</td>
                            <td>Mar 24, 09:30 AM</td>
                            <td class="fw-bold text-primary">AED 350.00</td>
                            <td><span class="status-pill bg-info text-white">Pending</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3 text-primary"><i class="fas fa-tools"></i></div>
                                    <div>
                                        <div class="fw-bold">AC Repair</div>
                                        <div class="small text-muted">Order #VC-2025</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold">Mariam J.</td>
                            <td>Mar 24, 11:00 AM</td>
                            <td class="fw-bold text-primary">AED 120.00</td>
                            <td><span class="status-pill bg-success text-white">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-7">
                <div class="table-container shadow-sm h-100">
                    <h5 class="fw-bold mb-4"><i class="fas fa-chart-pie text-primary me-2"></i> Booking Distribution</h5>
                    <div style="height: 250px;">
                        <canvas id="bookingStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="list-group shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <div class="list-group-item border-0 p-3 bg-primary text-white">
                        <h6 class="mb-0 fw-bold">Booking Management</h6>
                    </div>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div><i class="fas fa-bell text-warning me-2"></i> New Booking</div>
                        <span class="badge bg-danger rounded-pill">5</span>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div><i class="fas fa-check-circle text-info me-2"></i> Ongoing (Accepted)</div>
                        <span class="badge bg-info rounded-pill">12</span>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div><i class="fas fa-history text-success me-2"></i> History (Completed)</div>
                        <span class="badge bg-success rounded-pill">150</span>
                    </a>
                </div>
            </div>
        </div>





    </div>

@stop

@section('footer_js')
    <script src="{{ asset('public/admin/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCtx = document.getElementById('bookingStatusChart').getContext('2d');

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['New', 'Accepted', 'Completed'],
                    datasets: [{
                        data: [5, 12, 150], // Replace with your @php variables
                        backgroundColor: ['#FFD312', '#0040E6', '#2ecc71'],
                        hoverOffset: 4,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    cutout: '70%' // Makes it look modern/thin
                }
            });
        });
    </script>
    <script>
        function myCustomFunction() {
            Swal.fire({
                title: 'Welcome Back!',
                text: 'Your dashboard is live with the latest data.',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#fff',
                iconColor: '#0040E6',
                customClass: {
                    popup: 'shadow-lg border-0 rounded-3'
                }
            });
        }

        $(window).on('load', function() {
            myCustomFunction();
        });
    </script>
@stop
