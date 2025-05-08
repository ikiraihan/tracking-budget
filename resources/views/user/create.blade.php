@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Data Supir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/user/store" method="POST" enctype="multipart/form-data">
                            @csrf                       
                            <div class="row">                       
                                {{-- Nama Supir --}}
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">Nama<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nama Username --}}
                                <div class="col-md-6 mb-2">
                                    <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role_id" class="form-label">Role <span style="color: red;">*</span></label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                        <option value="" selected disabled>-- Pilih Role --</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Owner</option>
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Password <span style="color: red;">*</span></label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                         type="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                                    
                                <!-- Confirm Password Input -->
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Konfirmasi Password <span style="color: red;">*</span></label>
                                    <input class="form-control" type="password" name="password_confirmation" required>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/user" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>                  
                    </div>
                </div>
                <div class="card-footer d-none border-top-0"></div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInputs = ['photo_diri', 'photo_ktp', 'photo_sim']; // Hapus 'photo' jika tidak digunakan

    fileInputs.forEach(function(inputId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById('preview-' + inputId);

        if (input && preview) {
            // Simpan URL gambar lama dari dataset atau atribut src awal
            preview.dataset.oldSrc = preview.src || '';

            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validasi ukuran file (4MB)
                    if (file.size > 4 * 1024 * 1024) {
                        alert('File terlalu besar! Maksimum 4MB.');
                        input.value = ''; // Kosongkan input
                        preview.src = preview.dataset.oldSrc || '#';
                        preview.style.display = preview.dataset.oldSrc ? 'block' : 'none';
                        return;
                    }
                    // Validasi tipe file
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        alert('Hanya file JPG, JPEG, atau PNG yang diperbolehkan.');
                        input.value = ''; // Kosongkan input
                        preview.src = preview.dataset.oldSrc || '#';
                        preview.style.display = preview.dataset.oldSrc ? 'block' : 'none';
                        return;
                    }
                    // Tampilkan pratinjau gambar baru
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Kembalikan ke gambar lama jika input dikosongkan
                    preview.src = preview.dataset.oldSrc || '#';
                    preview.style.display = preview.dataset.oldSrc ? 'block' : 'none';
                }
            });
        }
    });
});
</script>     
    