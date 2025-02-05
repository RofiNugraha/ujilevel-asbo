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
    <span>Notifikasi</span>
</a>
<a class="nav-link {{ request()->is('admin/riwayat') ? 'active' : '' }}" href="/admin/riwayat">
    <span>Riwayat Transaksi</span>
</a>
<a class="nav-link {{ request()->is('admin/kasir') ? 'active' : '' }}" href="/admin/kasir">
    <span>Kasir</span>
</a>
{{ $slot }}