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
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
    background-color: white;
    border-radius: 5px;
    padding: 5px;
}

.profile-container {
    background-color: white;
    border-radius: 5px;
    padding: 5px 10px;
    display: flex;
    align-items: center;
}

.profile-container img {
    border: 2px solid white;
}

/* Efek Hover */
.nav-link:hover {
    background-color: gold !important;
    color: white !important;
    border-radius: 5px;
}


/* Menu Aktif */
.nav-link.active {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 5px;
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
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion" style="background-color: white;">
                <div class="sb-sidenav-menu">
                    <div class="nav ms-4 justify-center">
                        <img src="{{ asset('images/logog.png')}}" alt="Logo" style="width: 150px; height: 80px;">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link text-warning active" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link text-warning" href="{{ route('admin.booking.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Booking
                        </a>
                        <a class="nav-link text-warning" href="{{ route('admin.kasir.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Kasir
                        </a>
                        <a class="nav-link text-warning" href="{{ route('admin.layanan.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-concierge-bell"></i></div>
                            Layanan
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer text-center">
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
    <nav class="sb-topnav navbar navbar-expand border-0" style="height: 80px; background-color: white;">
        <a class="navbar-brand ps-3 text-white" href="{{ route('admin.dashboard') }}"></a>
        <form class="d-none d-md-inline-block form-inline ms-3">
            <div class="input-group search-container">
                <input class="form-control" style="width: 600px;" type="text" placeholder="Search for..."
                    aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto me-3 me-lg-4 m-2">
            <li class="nav-item notification">
                <a class="nav-link text-warning" href="#">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-warning" href="#" id="darkModeToggle">
                    <i class="fas fa-moon"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-warning profile-container" href="#" id="profileDropdown"
                    role="button" data-bs-toggle="dropdown">
                    <span class="me-2" style="font-size: 15px;">Hallo, Admin</span>
                    <img src="{{ asset('images/google.png') }}" alt="Profile" class="rounded-circle" width="40"
                        height="40">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    </div>
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
        document.body.classList.toggle("text-white");
    });
    </script>
</body>

</html>