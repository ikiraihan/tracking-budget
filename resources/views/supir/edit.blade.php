@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Data Supir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/supir/update/{{ $supir->id }}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')                       
                            <div class="row">
                                {{-- Foto Diri --}}
                                <div class="col-md-12 mb-2">
                                    <label for="photo_diri" class="form-label">Foto Diri <span style="color: red;">*</span></label>
                                    <input type="file" class="form-control @error('photo_diri') is-invalid @enderror" 
                                        id="photo_diri" name="photo_diri" accept=".jpg,.jpeg,.png">                                    
                                    @error('photo_diri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-photo_diri" 
                                            src="{{ $supir->path_photo_diri ? asset($supir->path_photo_diri) : '#' }}" 
                                            alt="Preview Foto Diri" 
                                            class="img-thumbnail" 
                                            width="150"
                                            style="{{ $supir->path_photo_diri ? '' : 'display: none;' }}"
                                            data-old-src="{{ $supir->path_photo_diri ? asset($supir->path_photo_diri) : '' }}">
                                    </div>
                                </div>
                                
                                {{-- Nama Supir --}}
                                <div class="col-md-6 mb-2">
                                    <label for="nama" class="form-label">Nama Supir <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', $supir->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nama Username --}}
                                <div class="col-md-6 mb-2">
                                    <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                {{-- Telepon --}}
                                <div class="col-md-6 mb-2">
                                    <label for="telepon" class="form-label">Telepon <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" value="{{ old('telepon', $supir->telepon) }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                {{-- Alamat --}}
                                <div class="col-md-6 mb-2">
                                    <label for="alamat" class="form-label">Alamat <span style="color: red;">*</span></label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" name="alamat" rows="1" required>{{ old('alamat', $supir->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                {{-- No. KTP --}}
                                <div class="col-md-6 mb-2">
                                    <label for="no_ktp" class="form-label">No. KTP</label>
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" 
                                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $supir->no_ktp) }}">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                {{-- Foto KTP --}}
                                <div class="col-md-6 mb-2">
                                    <label for="photo_ktp" class="form-label">Foto KTP</label>
                                    <input type="file" class="form-control @error('photo_ktp') is-invalid @enderror" 
                                        id="photo_ktp" name="photo_ktp" accept=".jpg,.jpeg,.png">                                    
                                    @error('photo_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-photo_ktp" 
                                            src="{{ $supir->path_photo_ktp ? asset($supir->path_photo_ktp) : '#' }}" 
                                            alt="Preview Foto KTP" 
                                            class="img-thumbnail" 
                                            width="150"
                                            style="{{ $supir->path_photo_ktp ? '' : 'display: none;' }}"
                                            data-old-src="{{ $supir->path_photo_ktp ? asset($supir->path_photo_ktp) : '' }}">
                                    </div>
                                </div>
                        
                                {{-- No. SIM --}}
                                <div class="col-md-6 mb-2">
                                    <label for="no_sim" class="form-label">No. SIM</label>
                                    <input type="text" class="form-control @error('no_sim') is-invalid @enderror" 
                                           id="no_sim" name="no_sim" value="{{ old('no_sim', $supir->no_sim) }}">
                                    @error('no_sim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                {{-- Foto SIM --}}
                                <div class="col-md-6 mb-2">
                                    <label for="photo_sim" class="form-label">Foto SIM</label>
                                    <input type="file" class="form-control @error('photo_sim') is-invalid @enderror" 
                                        id="photo_sim" name="photo_sim" accept=".jpg,.jpeg,.png">
                                    @error('photo_sim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-photo_sim" 
                                            src="{{ $supir->path_photo_sim ? asset($supir->path_photo_sim) : '#' }}" 
                                            alt="Preview Foto SIM" 
                                            class="img-thumbnail" 
                                            width="150"
                                            style="{{ $supir->path_photo_sim ? '' : 'display: none;' }}"
                                            data-old-src="{{ $supir->path_photo_sim ? asset($supir->path_photo_sim) : '' }}">
                                    </div>
                                </div>
                        
                                {{-- Truk --}}
                                <div class="col-md-12 mb-3">
                                    <label for="truk_id" class="form-label">Truk <span style="color: red;">*</span></label>
                                    <select class="form-control @error('truk_id') is-invalid @enderror" name="truk_id" id="truk_id" required>
                                        <option value="">-- Pilih Truk --</option>
                                        @foreach($truks as $truk)
                                            <option value="{{ $truk->id }}" {{ old('truk_id', $supir->truk_id) == $truk->id ? 'selected' : '' }}>
                                                {{ $truk->no_polisi }} - {{ $truk->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('truk_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="is_active" class="form-label">Status Supir</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is_active" required>
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="1" {{ old('is_active', $supir->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $supir->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/supir" class="btn btn-secondary">Kembali</a>
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
    