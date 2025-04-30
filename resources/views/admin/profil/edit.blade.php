<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main class="container my-5">
                <div class="card shadow-lg rounded-4 mx-auto" style="max-width: 700px;">
                    <div class="card-header bg-warning text-white text-center py-4">
                        <h2 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil Admin
                        </h2>
                    </div>
                    <div class="card-body bg-light">

                        <form action="{{ route('admin.profil.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Image Upload -->
                            <div class="mb-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <img id="previewImage"
                                        src="{{ $user->image ? asset('storage/' . $user->image) : 'https://via.placeholder.com/150' }}"
                                        class="rounded-circle border border-3 border-warning shadow-sm"
                                        style="width: 120px; height: 120px; object-fit: cover;" />
                                    <label for="image"
                                        class="position-absolute top-0 end-0 bg-dark bg-opacity-75 text-white px-2 py-1 rounded-circle"
                                        style="cursor: pointer;" title="Ubah foto">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>
                                <input type="file" id="image" name="image" accept="image/*" class="d-none"
                                    onchange="previewFile()" />
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="name" class="form-label"><i
                                        class="fas fa-user text-warning me-1"></i>Username</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" placeholder="Masukkan username" required>
                            </div>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label"><i
                                        class="fas fa-id-card text-primary me-1"></i>Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label"><i
                                        class="fas fa-phone text-success me-1"></i>Nomor HP</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}" placeholder="Masukkan nomor HP">
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="form-label"><i
                                        class="fas fa-map-marker-alt text-danger me-1"></i>Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3"
                                    placeholder="Masukkan alamat">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Image Preview Script -->
                <script>
                function previewFile() {
                    const preview = document.getElementById('previewImage');
                    const file = document.querySelector('input[type=file]').files[0];
                    const reader = new FileReader();

                    reader.onloadend = function() {
                        preview.src = reader.result;
                    }

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }
                </script>
            </main>
        </div>
    </div>
</x-admin.admin-layout>