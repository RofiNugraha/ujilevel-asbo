<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Laporan Pengeluaran</h1>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                            <div>
                                <a href="{{ route('admin.pengeluaran.export', request()->query()) }}"
                                    class="btn btn-sm btn-success mr-2">
                                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                                </a>
                                <a href="{{ route('admin.pengeluaran.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Tambah Pengeluaran
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pengeluaran.index') }}" method="GET" class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $startDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $endDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="all" {{ $kategori == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="pribadi" {{ $kategori == 'pribadi' ? 'selected' : '' }}>Pribadi
                                        </option>
                                        <option value="toko" {{ $kategori == 'toko' ? 'selected' : '' }}>Toko</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.pengeluaran.index') }}"
                                        class="btn btn-secondary ml-2">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Dashboard Summary Cards -->
                    <div class="row">
                        <!-- Total Pengeluaran Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pengeluaran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengeluaran Pribadi Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pengeluaran Pribadi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($summaryByKategori['pribadi'], 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengeluaran Toko Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pengeluaran Toko</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($summaryByKategori['toko'], 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-store fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengeluaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Bukti</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pengeluarans as $pengeluaran)
                                        <tr>
                                            <td>{{ $pengeluaran->id }}</td>
                                            <td>{{ $pengeluaran->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $pengeluaran->nama }}</td>
                                            <td>{{ $pengeluaran->kategori }}
                                            </td>
                                            <td>Rp {{ number_format($pengeluaran->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ $pengeluaran->bukti_pembayaran_url }}"
                                                    data-lightbox="bukti-{{ $pengeluaran->id }}"
                                                    data-title="{{ $pengeluaran->nama }}">
                                                    <img src="{{ $pengeluaran->bukti_pembayaran_url }}"
                                                        alt="Bukti pembayaran" class="img-thumbnail"
                                                        style="max-height: 50px;">
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.pengeluaran.show', $pengeluaran->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.pengeluaran.edit', $pengeluaran->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.pengeluaran.destroy', $pengeluaran->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pengeluaran</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $pengeluarans->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
    $(document).ready(function() {
        // Script untuk memastikan tanggal akhir tidak lebih awal dari tanggal mulai
        $('#start_date').on('change', function() {
            var startDate = $(this).val();
            if (startDate && $('#end_date').val() && new Date(startDate) > new Date($('#end_date')
                    .val())) {
                $('#end_date').val(startDate);
            }
        });

        $('#end_date').on('change', function() {
            var endDate = $(this).val();
            if (endDate && $('#start_date').val() && new Date(endDate) < new Date($('#start_date')
                    .val())) {
                $('#start_date').val(endDate);
            }
        });
    });
    </script>
</x-admin.admin-layout>