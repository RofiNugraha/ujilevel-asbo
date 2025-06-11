<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.client_key')}}">
    </script>
    </script>
</head>

<style>
body {
    background-color: #f0f0f0;
}

.navbar {
    background-color: transparent !important;
    border: none !important;
}


.search-container {
    background-color: ;
    border-radius: 5px;
    padding: 5px;
}

.profile-container {
    background-color: ;
    border-radius: 5px;
    padding: 5px 10px;
    display: flex;
    align-items: center;
}

.profile-container img {
    border: 2px solid white;
}

/* Efek Hover */
/* Efek Hover */
.nav-link {
    display: block;
    text-align: center;
    padding: 10px 15px;
    /* Menyesuaikan padding agar hover tidak terlalu melebar */
    margin-right: 30px;
}

.nav-link:hover {
    background-color: black !important;
    color: white !important;
    border-radius: 5px;
    width: auto;
    /* Menghindari hover melebar */
    text-align: center;
}



/* Menu Aktif */
/* Indikator di sebelah kiri menu aktif */
/* Indikator di sebelah kiri layar untuk menu aktif */
/* Styling untuk menu aktif */
.nav-link.active {
    position: relative;
    background-color: black !important;
    /* Background warna emas */
    color: white !important;
    /* Warna teks putih biar kontras */
    border-radius: 5px;
    font-weight: bold;
    /* Biar lebih mencolok */
}

/* Indikator di pojok kiri layar */
.nav-link.active::before {
    content: "";
    position: absolute;
    left: -30px;
    /* Taruh di pojok kiri layar */
    top: 0;
    height: 100%;
    width: 10px;
    background-color: black;
    /* Warna indikator */
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}


/* Notifikasi */
.notification {
    position: relative;
}

.notification .badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border-radius: 50%;
    padding: 5px;
    font-size: 10px;
}
</style>

<body class="sb-nav-fixed">
    {{ $slot }}
    <nav class="sb-topnav navbar navbar-expand border-0"
        style="height: 80px; background-color: white; margin-left: 235px;">
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-dark bg-white" id="sidebarToggle">
            <i class="fas fa-bars m-1"></i>
        </button>
        <div class="container-fluid d-flex justify-content-between">
            <ul class="navbar-nav ms-auto me-3 me-lg-4 m-2">
                <!-- <li class="nav-item notification">
                    <a class="nav-link text-warning" href="#">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item mx-2">
                    <a class="nav-link text-warning" href="#" id="darkModeToggle">
                        <i class="fas fa-moon"></i>
                    </a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark profile-container" href="{{ route('admin.profil.profil') }}">
                        <span class="me-2">Profil</span>
                        <img src="{{ asset('images/google.png') }}" alt="Profile" class="rounded-circle" width="30"
                            height="30">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion" style="background-color: white;">
                <div class="sb-sidenav-menu">
                    <div class="nav ms-4 justify-content-center">
                        <img src="{{ asset('images/asboii.png')}}" alt="Logo" class="img-fluid"
                            style="width: 160px; height: auto;">
                        <a style="color: black;" class="nav-link mt-4 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon d-flex">
                                <i class="fas fa-home"></i>
                                <span class="ms-3">Dashboard</span>
                            </div>
                        </a>

                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.booking.index') ? 'active' : '' }}"
                            href="{{ route('admin.booking.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-calendar-check"></i>
                                <span class="ms-3">Booking</span>
                            </div>
                        </a>

                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.kasir.index') ? 'active' : '' }}"
                            href="{{ route('admin.kasir.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-cash-register"></i>
                                <span class="ms-3">Kasir</span>
                            </div>
                        </a>

                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.layanan.index') ? 'active' : '' }}"
                            href="{{ route('admin.layanan.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tools"></i>
                                <span class="ms-3">Layanan</span>
                            </div>
                        </a>

                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.pemasukan.index') ? 'active' : '' }}"
                            href="{{ route('admin.pemasukan.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="ms-3">Pemasukan</span>
                            </div>
                        </a>
                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.pengeluaran.index') ? 'active' : '' }}"
                            href="{{ route('admin.pengeluaran.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="ms-3">pengeluaran</span>
                            </div>
                        </a>
                        <a style="color: black;" class="nav-link mt-2 {{ request()->routeIs('admin.riwayat.index') ? 'active' : '' }}"
                            href="{{ route('admin.riwayat.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-history"></i>
                                <span class="ms-3">Riwayat</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer text-center ms-4">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script> 
        let table = new DataTable('#myTabel'); 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    <script>
    document.getElementById("darkModeToggle").addEventListener("click", function() {
        document.body.classList.toggle("bg-dark");
        document.body.classList.toggle("text-black");
    });
    </script>
</body>

</html>