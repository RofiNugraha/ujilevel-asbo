<x-admin.admin-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Notifikasi</h1>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary mb-3">Tambah Notifikasi</a>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-bell me-1"></i> Notifikasi
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>User</th>
                            <th>Booking</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->user->name }}</td>
                            <td>{{ $notification->booking->id }}</td>
                            <td>{{ $notification->pesan }}</td>
                            <td>{{ $notification->tanggal_notif }}</td>
                            <td>
                                <span class="badge {{ $notification->status_dibaca ? 'bg-success' : 'bg-warning' }}">
                                    {{ $notification->status_dibaca ? 'Dibaca' : 'Belum Dibaca' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin.admin-layout>
