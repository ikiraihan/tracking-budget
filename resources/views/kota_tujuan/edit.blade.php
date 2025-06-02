@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Tujuan Akhir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ url('/truk/update/' . $kotaTujuan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')                           
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama', $kotaTujuan->nama) }}" required>
                                </div>
                                 <div class="col-md-12 mb-3">
                                    <label class="form-label" for="uang_setoran_tambahan">Uang Pengembalian Tol</label>
                                    <input type="text" id="uang_setoran_tambahan" name="uang_setoran_tambahan" value="{{ old('uang_setoran_tambahan', $kotaTujuan->uang_setoran_tambahan) }}" class="form-control" placeholder="0">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is_active" required>
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="1" {{ old('is_active', $kotaTujuan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $kotaTujuan->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/truk" class="btn btn-secondary">Kembali</a>
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
        const photoInput = document.getElementById('photo');
        const preview = document.getElementById('previewImage');
    
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        }
    });
</script>
    