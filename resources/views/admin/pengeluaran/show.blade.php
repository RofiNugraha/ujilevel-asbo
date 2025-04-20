<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Detail Pengeluaran</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Pengeluaran</h6>
                            <div>
                                <a href="{{ route('admin.pengeluaran.edit', $pengeluaran->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.pengeluaran.destroy', $pengeluaran->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Nama Pengeluaran</th>
                                            <td>: {{ $pengeluaran->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kategori</th>
                                            <td>: {{ $pengeluaran->kategori }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Pengeluaran</th>
                                            <td>: Rp {{ number_format($pengeluaran->harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td>: {{ $pengeluaran->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="m-0 font-weight-bold text-primary">Bukti Pembayaran</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            @if($pengeluaran->bukti_pembayaran)
                                            <img src="{{ $pengeluaran->bukti_pembayaran_url }}" alt="Bukti Pembayaran"
                                                class="img-fluid" style="max-height: 300px;">
                                            @else
                                            <p class="text-muted">Tidak ada bukti pembayaran</p>
                                            @endif
                                        </div>
                                        @if($pengeluaran->bukti_pembayaran)
                                        <div class="card-footer text-center">
                                            <a href="{{ $pengeluaran->bukti_pembayaran_url }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-external-link-alt"></i> Lihat Ukuran Penuh
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>