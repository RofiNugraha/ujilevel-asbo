<a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
    <span>Dashboard</span>
</a>
<a class="nav-link {{ request()->is('admin/layanan') ? 'active' : '' }}" href="/admin/layanan">
    <span>Layanan</span>
</a>
<a class="nav-link {{ request()->is('admin/booking') ? 'active' : '' }}" href="/admin/booking">
    <span>booking</span>
</a>
<a class="nav-link {{ request()->is('admin/notifikasi') ? 'active' : '' }}" href="/admin/notifikasi">
    <span>Notifkasi</span>
</a>
{{ $slot }}