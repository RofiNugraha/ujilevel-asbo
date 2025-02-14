<x-admin.admin-layout>
    <style>
        #myBarChart {
            width: 100% !important;
            height: 150px !important;
        }
        .date-container {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main class="container mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-semibold">Dashboard</h1>
                    <div class="date-container">
                        <h5 class="mb-1">Filter Priode</h5>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span id="currentDate" class="fw-semibold"></span>
                        </div>
                    </div>
                </div>
                <p class="text-gray mb-4">Hallo selamat datang di halaman dashboard</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm p-4 d-flex align-items-center rounded-4">
                            <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                            <h3 class="fs-5 fw-semibold">Total Pesanan</h3>
                            <p class="fs-3 fw-bold">150</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-4 d-flex align-items-center rounded-4">
                            <i class="fas fa-wallet fa-3x text-success mb-3"></i>
                            <h3 class="fs-5 fw-semibold">Pendapatan</h3>
                            <p class="fs-3 fw-bold">Rp 5.000.000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-4 d-flex align-items-center rounded-4">
                            <i class="fas fa-users fa-3x text-warning mb-3"></i>
                            <h3 class="fs-5 fw-semibold">Pelanggan</h3>
                            <p class="fs-3 fw-bold">120</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 card shadow-sm p-4" style="height: 320px;">
                    <h3 class="fs-5 fw-semibold mb-3"><i class="fas fa-chart-bar me-2"></i> Statistik Pesanan</h3>
                    <canvas id="orderChart" style="max-height: 250px;"></canvas>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date();
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById("currentDate").textContent = today.toLocaleDateString("id-ID", options);
        
            var ctx = document.getElementById("orderChart").getContext("2d");
            var orderChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
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
                            grid: { display: false }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-admin.admin-layout>