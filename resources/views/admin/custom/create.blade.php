<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Data Website</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('admin.custom.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>

                                <form action="{{ route('admin.custom.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="logo" class="form-label">Logo</label>
                                                    <input type="file"
                                                        class="form-control @error('logo') is-invalid @enderror"
                                                        id="logo" name="logo" accept="image/*"
                                                        onchange="previewImage(this)">
                                                    @error('logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="logo-preview" src="#" alt="Preview Logo"
                                                            class="img-thumbnail"
                                                            style="max-width: 200px; display: none;">
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="judul" class="form-label">Judul Website <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('judul') is-invalid @enderror"
                                                        id="judul" name="judul" value="{{ old('judul') }}" required>
                                                    @error('judul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="subjudul" class="form-label">Subjudul Website</label>
                                                    <input type="text"
                                                        class="form-control @error('subjudul') is-invalid @enderror"
                                                        id="subjudul" name="subjudul" value="{{ old('subjudul') }}">
                                                    @error('subjudul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                        id="alamat" name="alamat"
                                                        rows="3">{{ old('alamat') }}</textarea>
                                                    @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="no_hp" class="form-label">No HP</label>
                                                    <input type="text"
                                                        class="form-control @error('no_hp') is-invalid @enderror"
                                                        id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
                                                    @error('no_hp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="jam_operasional" class="form-label">Jam
                                                        Operasional</label>
                                                    <input type="text"
                                                        class="form-control @error('jam_operasional') is-invalid @enderror"
                                                        id="jam_operasional" name="jam_operasional"
                                                        value="{{ old('jam_operasional') }}"
                                                        placeholder="Contoh: Senin-Jumat 08:00-17:00">
                                                    @error('jam_operasional')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="link_instagram" class="form-label">Link
                                                        Instagram</label>
                                                    <input type="url"
                                                        class="form-control @error('link_instagram') is-invalid @enderror"
                                                        id="link_instagram" name="link_instagram"
                                                        value="{{ old('link_instagram') }}"
                                                        placeholder="https://instagram.com/username">
                                                    @error('link_instagram')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="link_facebook" class="form-label">Link Facebook</label>
                                                    <input type="url"
                                                        class="form-control @error('link_facebook') is-invalid @enderror"
                                                        id="link_facebook" name="link_facebook"
                                                        value="{{ old('link_facebook') }}"
                                                        placeholder="https://facebook.com/username">
                                                    @error('link_facebook')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="link_whatsapp" class="form-label">Link WhatsApp</label>
                                                    <input type="url"
                                                        class="form-control @error('link_whatsapp') is-invalid @enderror"
                                                        id="link_whatsapp" name="link_whatsapp"
                                                        value="{{ old('link_whatsapp') }}"
                                                        placeholder="https://wa.me/6281234567890">
                                                    @error('link_whatsapp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <a href="{{ route('admin.custom.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#logo-preview').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-admin.admin-layout>