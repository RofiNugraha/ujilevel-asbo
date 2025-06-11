<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Kelola Website</h3>
                                    <a href="{{ route('admin.custom.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                </div>

                                <div class="card-body">
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="10%">Logo</th>
                                                    <th width="15%">Judul</th>
                                                    <th width="15%">Subjudul</th>
                                                    <th width="20%">Alamat</th>
                                                    <th width="10%">No HP</th>
                                                    <th width="15%">Email</th>
                                                    <th width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customs as $index => $custom)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if($custom->logo)
                                                        <img src="{{ asset($custom->logo) }}" alt="Logo"
                                                            class="img-thumbnail"
                                                            style="max-width: 60px; max-height: 60px;">
                                                        @else
                                                        <span class="text-muted">No Logo</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $custom->judul }}</td>
                                                    <td>{{ $custom->subjudul ?? '-' }}</td>
                                                    <td>{{ Str::limit($custom->alamat ?? '-', 50) }}</td>
                                                    <td>{{ $custom->no_hp ?? '-' }}</td>
                                                    <td>{{ $custom->email ?? '-' }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.custom.edit', $custom) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="deleteConfirm({{ $custom->id }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>

                                                        <form id="delete-form-{{ $custom->id }}"
                                                            action="{{ route('admin.custom.destroy', $custom) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Belum ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Modal -->
                @foreach($customs as $custom)
                <div class="modal fade" id="detailModal{{ $custom->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Website Setting</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Logo:</strong><br>
                                        @if($custom->logo)
                                        <img src="{{ asset($custom->logo) }}" alt="Logo" class="img-fluid mb-3"
                                            style="max-width: 200px;">
                                        @else
                                        <span class="text-muted">No Logo</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Judul:</strong> {{ $custom->judul }}<br><br>
                                        <strong>Subjudul:</strong> {{ $custom->subjudul ?? '-' }}<br><br>
                                        <strong>Email:</strong> {{ $custom->email ?? '-' }}<br><br>
                                        <strong>No HP:</strong> {{ $custom->no_hp ?? '-' }}<br><br>
                                        <strong>Jam Operasional:</strong> {{ $custom->jam_operasional ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Alamat:</strong><br>
                                        {{ $custom->alamat ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Instagram:</strong><br>
                                        @if($custom->link_instagram)
                                        <a href="{{ $custom->link_instagram }}"
                                            target="_blank">{{ $custom->link_instagram }}</a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Facebook:</strong><br>
                                        @if($custom->link_facebook)
                                        <a href="{{ $custom->link_facebook }}"
                                            target="_blank">{{ $custom->link_facebook }}</a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <strong>WhatsApp:</strong><br>
                                        @if($custom->link_whatsapp)
                                        <a href="{{ $custom->link_whatsapp }}"
                                            target="_blank">{{ $custom->link_whatsapp }}</a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </main>
        </div>
    </div>

    <script>
    function deleteConfirm(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    </script>
</x-admin.admin-layout>