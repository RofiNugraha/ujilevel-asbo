<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main class="container my-5">
                <div class="card shadow-lg rounded-4 mx-auto" style="max-width: 700px;">
                    <div class=" card-header bg-warning text-white text-center py-5">
                        <div class="mb-3">
                            <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('images/default-avatar.jpg') }}"
                                alt="Profile Photo" class="rounded-circle border border-white shadow"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <h2 class="fw-bold">{{ $user->name }}</h2>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>

                    <div class="card-body">
                        <!-- Informasi Pribadi -->
                        <h4 class="mb-3"><i class="bi bi-person-lines-fill me-2"></i>Informasi Pribadi</h4>
                        <table class="table table-borderless">
                            <tr>
                                <th class="w-25 text-secondary">Nama Lengkap</th>
                                <td>{{ $user->nama_lengkap ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Nomor HP</th>
                                <td>{{ $user->phone ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Alamat</th>
                                <td>{{ $user->address ?? 'Belum diisi' }}</td>
                            </tr>
                        </table>

                        <hr>

                        <!-- Informasi Akun -->
                        <h4 class="mb-3"><i class="bi bi-gear-fill me-2"></i>Informasi Akun</h4>
                        <table class="table table-borderless">
                            <tr>
                                <th class="w-25 text-secondary">Username</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Tipe Akun</th>
                                <td>{{ $user->usertype }}</td>
                            </tr>
                        </table>


                        <div class="d-flex justify-content-between mt-4">
                            @if(isset($user))
                            <a href="{{ route('admin.profil.edit', $user->id) }}"
                                class="btn btn-warning text-white">Edit
                                Profil</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i
                                        class="bi bi-box-arrow-right me-1"></i>Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>