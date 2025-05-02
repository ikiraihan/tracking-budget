@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Verifikasi Supir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/supir/verifikasi/{{ $supir->id }}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')                       
                            <div class="row">   
                                <div class="col-md-12 mb-3">
                                    <label for="is_active" class="form-label">Aktifkan Akun Supir? <span style="color: red;">*</span></label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is_active" required onchange="toggleSupirForm()">
                                        <option value="" disabled {{ is_null(old('is_active', $supir->is_active)) ? 'selected' : '' }}>-- Pilih Status --</option>
                                        <option value="1" {{ old('is_active', $supir->is_active) == 1 ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('is_active', $supir->is_active) == 0 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="inactive-warning" class="text-danger mt-2" style="display: none;">
                                        Akun supir akan dinonaktifkan dan tidak dapat digunakan kembali.
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3" id="supirForm">
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
    function toggleSupirForm() {
        const isActive = document.getElementById('is_active').value;
        const supirForm = document.getElementById('supirForm');
        const trukSelect = document.getElementById('truk_id');
        const warning = document.getElementById('inactive-warning');

        if (isActive === "1") {
            supirForm.style.display = "block";
            trukSelect.setAttribute("required", "required");
            warning.style.display = "none";
        } else {
            supirForm.style.display = "none";
            trukSelect.removeAttribute("required");
            warning.style.display = "block";
        }
    }
</script>
