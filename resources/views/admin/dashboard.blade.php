<x-admin.admin-layout>
    <style>
    #orderChart {
        width: 100% !important;
        height: 250px !important;
    }

    .date-container {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .min-height {
        min-height: 50px;
    }

    .carousel-container {
        position: relative;
        max-width: 100%;
        overflow: hidden;
        margin: auto;
    }

    .review-carousel {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 20px;
        padding-bottom: 10px;
        white-space: nowrap;
    }

    .review-card {
        min-width: 250px;
        flex: 0 0 auto;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .review-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #007BFF;
        object-fit: cover;
        margin: auto;
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #007BFF;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .nav-btn-left {
        left: -40px;
    }

    .nav-btn-right {
        right: -40px;
    }
    </style>

    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main class="container mt-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="fw-semibold">Dashboard</h1>
                        <p class="text-gray mb-0">Hallo, selamat datang di halaman dashboard</p>
                    </div>
                    <div class="date-container mt-3 text-center">
                        <h5 class="mb-1">Filter Periode</h5>
                        <div class="d-flex align-items-center gap-2" id="dropdownToggle" style="cursor: pointer;">
                            <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                            <span id="currentDate" class="fw-semibold">Pilih rentang tanggal</span>
                            <i id="toggleDropdown" class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-42222A">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card shadow-sm p-3 d-flex align-items-center rounded-4 text-center">
                            <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                            <h3 class="fs-6 fw-semibold">Total Pesanan</h3>
                            <p class="fs-4 fw-bold" id="totalOrders">150</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card shadow-sm p-3 d-flex align-items-center rounded-4 text-center">
                            <i class="fas fa-wallet fa-2x text-success mb-2"></i>
                            <h3 class="fs-6 fw-semibold">Pendapatan</h3>
                            <p class="fs-4 fw-bold" id="totalRevenue">Rp 5.000.000</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-sm p-3 d-flex align-items-center rounded-4 text-center">
                            <i class="fas fa-users fa-2x text-warning mb-2"></i>
                            <h3 class="fs-6 fw-semibold">Pelanggan</h3>
                            <p class="fs-4 fw-bold" id="totalCustomers">120</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 card shadow-sm p-4" style="height: 320px;">
                    <h3 class="fs-5 fw-semibold mb-3"><i class="fas fa-chart-bar me-2"></i> Statistik Pesanan</h3>
                    <canvas id="orderChart"></canvas>
                </div>
                <div class="container mt-5 mb-5">
                    <div class="carousel-container">
                        <button class="nav-btn nav-btn-left" onclick="scrollLeft()">❮</button>
                        <div id="reviewCarousel" class="review-carousel">
                            @foreach ($contacts as $contact)
                            <div class="card review-card">
                                <img src="{{ asset($contact->user->image) }}" class="review-img">
                                <h5 class="mt-3">{{ $contact->user->name }}</h5>
                                <p class="min-height">{{ $contact->feedback }}</p>
                                <div class="text-warning">
                                    {!! str_repeat('⭐', $contact->rating) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="nav-btn nav-btn-right" onclick="scrollRight()">❯</button>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
    function scrollLeft() {
        document.getElementById('reviewCarousel').scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    }

    function scrollRight() {
        document.getElementById('reviewCarousel').scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById("currentDate").textContent = today.toLocaleDateString("id-ID", options);

        var ctx = document.getElementById("orderChart").getContext("2d");
        var orderChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov",
                    "Des"
                ],
                datasets: [{
                    label: "Jumlah Pesanan",
                    data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                    backgroundColor: "rgba(54, 162, 235, 0.5)"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
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

        document.getElementById("dropdownToggle").addEventListener("click", function() {
            Swal.fire({
                title: 'Pilih Rentang Tanggal',
                html: `
                    <label for="startDate" class="form-label">Tanggal Awal:</label>
                    <input type="date" id="startDate" class="swal2-input">
                    <label for="endDate" class="form-label">Tanggal Akhir:</label>
                    <input type="date" id="endDate" class="swal2-input">
                `,
                showCancelButton: true,
                confirmButtonText: 'Pilih',
                preConfirm: () => {
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    if (!startDate || !endDate) {
                        Swal.showValidationMessage('Harap pilih tanggal awal dan akhir!');
                    }
                    return {
                        startDate,
                        endDate
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("currentDate").innerText =
                        `${result.value.startDate} - ${result.value.endDate}`;

                    orderChart.data.datasets[0].data = generateRandomData();
                    orderChart.update();
                }
            });
        });

        function generateRandomData() {
            return Array.from({
                length: 12
            }, () => Math.floor(Math.random() * 100));
        }
    });
    </script>
</x-admin.admin-layout>