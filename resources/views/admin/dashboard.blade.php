<x-admin.admin-layout>
    @include('partials.sweetalert')
    <style>
    .dashboard-card {
        border-radius: 12px;
        transition: transform 0.3s;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background: #fff;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .icon-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .bg-profit {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-income {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-expense {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .bg-booking {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-nonbooking {
        background-color: rgba(108, 117, 125, 0.1);
    }

    .bg-service {
        background-color: rgba(111, 66, 193, 0.1);
    }

    .chart-container {
        position: relative;
        height: 350px;
        margin-bottom: 20px;
    }

    .filter-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 20px;
    }

    .text-profit {
        color: #198754;
    }

    .text-expense {
        color: #dc3545;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .stat-change {
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .rating {
        font-size: 0.9rem;
    }
    </style>

    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="fw-bold mb-1">Dashboard Overview</h1>
                            <p class="text-muted">Welcome back, Administrator</p>
                        </div>
                        <div class="filter-container d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Period Filter</h6>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ now()->format('d M Y') }} - {{ now()->addDays(30)->format('d M Y') }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="periodDropdown">
                                        <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                        <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">Custom Range</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary Cards -->
                    <div class="row g-4 mb-4">
                        <!-- Net Profit -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="icon-container bg-profit">
                                            <i class="fas fa-wallet fa-2x text-success"></i>
                                        </div>
                                        <h3 class="stat-value text-profit">Rp
                                            {{ number_format($netProfit, 0, ',', '.') }}</h3>
                                        <p class="stat-label mb-0">Total Net Profit</p>
                                        <div class="stat-change text-success">
                                            <i class="fas fa-arrow-up me-1"></i>8.2% from last period
                                        </div>
                                    </div>
                                    <div>
                                        <div id="profitSparkline" style="width: 100px; height: 40px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Income -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="icon-container bg-income">
                                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                                        </div>
                                        <h3 class="stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                                        <p class="stat-label mb-0">Total Income</p>
                                        <div class="stat-change text-success">
                                            <i class="fas fa-arrow-up me-1"></i>12.5% from last period
                                        </div>
                                    </div>
                                    <div>
                                        <div id="incomeSparkline" style="width: 100px; height: 40px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Expense -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="icon-container bg-expense">
                                            <i class="fas fa-receipt fa-2x text-danger"></i>
                                        </div>
                                        <h3 class="stat-value text-expense">Rp
                                            {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                                        <p class="stat-label mb-0">Total Expenses</p>
                                        <div class="stat-change text-danger">
                                            <i class="fas fa-arrow-up me-1"></i>5.1% from last period
                                        </div>
                                    </div>
                                    <div>
                                        <div id="expenseSparkline" style="width: 100px; height: 40px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Customers -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-booking me-3">
                                        <i class="fas fa-calendar-check fa-2x text-warning"></i>
                                    </div>
                                    <div>
                                        <h3 class="stat-value">{{ $bookingCustomers }}</h3>
                                        <p class="stat-label mb-0">Booking Customers</p>
                                        <div class="stat-change text-success">
                                            <i class="fas fa-arrow-up me-1"></i>15.3% from last period
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Non-Booking Customers -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-nonbooking me-3">
                                        <i class="fas fa-users fa-2x text-secondary"></i>
                                    </div>
                                    <div>
                                        <h3 class="stat-value">{{ $nonBookingCustomers }}</h3>
                                        <p class="stat-label mb-0">Walk-in Customers</p>
                                        <div class="stat-change text-success">
                                            <i class="fas fa-arrow-up me-1"></i>3.7% from last period
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Services -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="dashboard-card p-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-service me-3">
                                        <i class="fas fa-cut fa-2x text-purple"></i>
                                    </div>
                                    <div>
                                        <h3 class="stat-value">{{ $totalServices }}</h3>
                                        <p class="stat-label mb-0">Available Services</p>
                                        <div class="stat-change text-success">
                                            <i class="fas fa-plus me-1"></i>2 new services added
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions and Customer Types -->
                    <div class="row mb-4">
                        <!-- Recent Transactions -->
                        <div class="col-lg-8">
                            <div class="dashboard-card p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">Recent Transactions</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="table-container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Services</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTransactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>
                                                    @if($transaction->user_id)
                                                    {{ $transaction->user->name }}
                                                    @else
                                                    Walk-in Customer
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                    $layananIds = is_array($transaction->layanan_id)
                                                    ? $transaction->layanan_id
                                                    : json_decode($transaction->layanan_id, true) ?? [];

                                                    $layananNames = [];

                                                    foreach ($layananIds as $id) {
                                                    $layanan = \App\Models\Layanan::find($id);
                                                    if ($layanan) {
                                                    $layananNames[] = $layanan->nama_layanan;
                                                    }
                                                    }

                                                    echo !empty($layananNames) ? implode(', ', $layananNames) : 'Tidak
                                                    ada layanan';
                                                    @endphp
                                                </td>
                                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($transaction->status_transaksi == 'success')
                                                    <span class="badge bg-success">Success</span>
                                                    @elseif($transaction->status_transaksi == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                    @else
                                                    <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Type Distribution -->
                        <div class="col-lg-4">
                            <div class="dashboard-card p-4">
                                <h5 class="fw-bold mb-3">Customer Distribution</h5>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Booking Customers</span>
                                        <span class="fw-bold">{{ $bookingCustomers }}</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ ($bookingCustomers + $nonBookingCustomers) > 0 ? ($bookingCustomers / ($bookingCustomers + $nonBookingCustomers) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Walk-in Customers</span>
                                        <span class="fw-bold">{{ $nonBookingCustomers }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-secondary"
                                            style="width: {{ ($bookingCustomers + $nonBookingCustomers) > 0 ? ($nonBookingCustomers / ($bookingCustomers + $nonBookingCustomers) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Breakdown -->
                    <div class="row">
                        <div class="col-12">
                            <div class="dashboard-card p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">Feedback</h5>
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary active">All</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Store</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Personal</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Tampilkan daftar feedback -->
                                        <div class="feedback-list">
                                            @foreach($contacts as $contact)
                                            <div class="feedback-item mb-4 p-3 border rounded">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">
                                                            {{ $contact->user ? $contact->user->name : 'Anonymous' }}
                                                        </h6>
                                                        <!-- Tampilkan rating dalam bentuk bintang -->
                                                        <div class="rating">
                                                            @for($i = 1; $i <= 5; $i++) <i
                                                                class="fas fa-star {{ $i <= $contact->rating ? 'text-warning' : 'text-secondary' }}">
                                                                </i>
                                                                @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted ms-auto">
                                                        {{ $contact->created_at->diffForHumans() }}
                                                    </small>
                                                </div>

                                                <!-- Tampilkan feedback jika ada -->
                                                @if($contact->feedback)
                                                <div class="feedback-content mt-2">
                                                    <p class="mb-0">{{ $contact->feedback }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach

                                            <!-- Pagination jika diperlukan -->
                                            @if($contacts->hasPages())
                                            <div class="mt-3">
                                                {{ $contacts->links() }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <h6 class="fw-bold mb-3">Recent Expenses</h6>
                                        <div class="table-container">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentExpenses as $expense)
                                                    <tr>
                                                        <td>{{ $expense->nama }}</td>
                                                        <td><span
                                                                class="badge {{ $expense->kategori == 'toko' ? 'bg-info' : 'bg-warning' }}">{{ ucfirst($expense->kategori) }}</span>
                                                        </td>
                                                        <td>Rp {{ number_format($expense->harga, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Income vs Expense Chart
        const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
        const incomeExpenseChart = new Chart(incomeExpenseCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                datasets: [{
                        label: 'Income',
                        data: json($monthlyIncome),
                        backgroundColor: 'rgba(13, 110, 253, 0.5)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Expense',
                        data: json($monthlyExpense),
                        backgroundColor: 'rgba(220, 53, 69, 0.5)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Net Profit',
                        data: json($monthlyProfit),
                        type: 'line',
                        fill: false,
                        borderColor: 'rgba(25, 135, 84, 1)',
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('sweet_alert')) {
            const message = atob(urlParams.get('sweet_alert')); // Decode base64

            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                customClass: {
                    container: 'custom-swal-container',
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    content: 'custom-swal-content',
                    confirmButton: 'custom-swal-confirm'
                },
                buttonsStyling: false
            });

            // Clean up URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    // Services Chart
    const servicesCtx = document.getElementById('servicesChart').getContext('2d');
    const servicesChart = new Chart(servicesCtx, {
        type: 'doughnut',
        data: {
            labels: json($popularServices > pluck('nama_layanan')),
            datasets: [{
                data: json($popularServices > pluck('count')),
                backgroundColor: [
                    'rgba(13, 110, 253, 0.7)',
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(111, 66, 193, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Customer Type Chart
    const customerTypeCtx = document.getElementById('customerTypeChart').getContext('2d');
    const customerTypeChart = new Chart(customerTypeCtx, {
        type: 'pie',
        data: {
            labels: ['Booking Customers', 'Walk-in Customers'],
            datasets: [{
                data: [json($bookingCustomers), json($nonBookingCustomers)],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(108, 117, 125, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Expense Breakdown Chart
    const expenseBreakdownCtx = document.getElementById('expenseBreakdownChart').getContext('2d');
    const expenseBreakdownChart = new Chart(expenseBreakdownCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
            'Dec'
        ],
        datasets: [{
                label: 'Store Expenses',
                data: json($storeExpenses),
                backgroundColor: 'rgba(13, 110, 253, 0.5)'
            },
            {
                label: 'Personal Expenses',
                data: json($personalExpenses),
                backgroundColor: 'rgba(255, 193, 7, 0.5)'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                stacked: true
            },
            x: {
                stacked: true
            }
        }
    }
    });
    });
    </script>
    @if(session()->has('success'))
    <script>
    console.log("Success message exists: {{ session('success') }}");
    </script>
    @else
    <script>
    console.log("No success message in session");
    </script>
    @endif
</x-admin.admin-layout>