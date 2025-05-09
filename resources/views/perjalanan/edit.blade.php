@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Perjalanan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/perjalanan/update/{{ $perjalanan->id }}" method="POST" enctype="multipart/form-data">
                            @csrf    
                            @method('PUT')                      
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_berangkat" class="form-label" required>Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat" value="{{ old('tanggal_berangkat', $perjalanan->tanggal_berangkat) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="uang_kembali" required>Uang Kembali</label>
                                    <input type="text" id="uang_kembali" name="uang_kembali" value="{{ old('uang_kembali', $perjalanan->uang_kembali) }}" class="form-control" placeholder="Masukkan Uang Kembali.." required>
                                </div>
                                {{-- Foto Diri --}}
                                <div class="col-md-6 mb-2">
                                    <label for="photo_struk_kembali" class="form-label">Foto Struk Kembali <span style="color: red;">*</span></label>
                                    <input type="file" class="form-control @error('photo_struk_kembali') is-invalid @enderror" 
                                        id="photo_struk_kembali" name="photo_struk_kembali" accept=".jpg,.jpeg,.png">                                    
                                    @error('photo_struk_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-photo_struk_kembali" 
                                            src="{{ $perjalanan->path_struk_kembali ? asset($perjalanan->path_struk_kembali) : '#' }}" 
                                            alt="Preview Foto Struk" 
                                            class="img-thumbnail" 
                                            width="150"
                                            style="{{ $perjalanan->path_struk_kembali ? '' : 'display: none;' }}"
                                            data-old-src="{{ $perjalanan->path_struk_kembali ? asset($perjalanan->path_struk_kembali) : '' }}">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="is_done" value="1" 
                                        {{ old('is_done', $perjalanan->is_done) ? 'checked' : '' }} onchange="toggleForm()">
                                    <label class="form-check-label" for="gridCheck">
                                        Apakah Perjalanan sudah dilakukan?
                                    </label>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group mb-3" id="formJalur" style="display: none;">
                                        <label for="jalur">Jalur</label>                                        
                                        <select id="jalur" name="jalur" class="form-control" required>
                                            <option selected disabled>Pilih Jalur</option>
                                            <option value="full-tol" {{ old('jalur', $perjalanan->jalur) == 'full-tol' ? 'selected' : '' }}>Full Tol</option>
                                            <option value="setengah-tol" {{ old('jalur', $perjalanan->jalur) == 'setengah-tol' ? 'selected' : '' }}>Setengah Tol</option>
                                            <option value="bawah" {{ old('jalur', $perjalanan->jalur) == 'bawah' ? 'selected' : '' }}>Bawah</option>
                                        </select>                                                                          
                                    </div>
                                </div> 
                                <div class="col-md-6 mb-3" id="formUangPengembalianTol" style="display: none;">
                                    <label class="form-label" for="uang_pengembalian_tol">Uang Pengembalian Tol</label>
                                    <input type="text" id="uang_pengembalian_tol" name="uang_pengembalian_tol" value="{{ old('uang_pengembalian_tol', $perjalanan->uang_pengembalian_tol) }}" class="form-control bg-secondary-transparent text-black" placeholder="0" readonly>
                                </div>
                            </div>     
                            <div class="row">
                                <div class="col-md-6 mb-3" id="formDate" style="display: none;">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" value="{{ old('tanggal_kembali', $perjalanan->tanggal_kembali) }}" name="tanggal_kembali">
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/perjalanan" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>                        
                    </div>
                </div>
                <div class="card-footer d-none border-top-0">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    function toggleForm() {
        const isChecked = document.getElementById('gridCheck').checked;

        const returnDate = document.getElementById('return_date');
        const returnUangPengembalianTol = document.getElementById('uang_pengembalian_tol');
        const returnJalur = document.getElementById('jalur');

        document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formUangPengembalianTol').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formJalur').style.display = isChecked ? 'block' : 'none';

        if (isChecked) {
            returnDate.setAttribute('required', 'required');
            returnUangPengembalianTol.setAttribute('required', 'required');
            returnJalur.setAttribute('required', 'required');
        } else {
            returnDate.removeAttribute('required');
            returnUangPengembalianTol.removeAttribute('required');
            returnJalur.removeAttribute('required');
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        if ({{ old('is_done', $perjalanan->is_done) ? 'true' : 'false' }}) {
            toggleForm();
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const jalurSelect = document.getElementById("jalur");
        const uangPengembalianInput = document.getElementById("uang_pengembalian_tol");
        
        jalurSelect.addEventListener("change", function () {
            const value = this.value;
            if (value === "full-tol") {
                uangPengembalianInput.value = "4200000";
            } else if (value === "setengah-tol") {
                uangPengembalianInput.value = "3725000";
            } else if (value === "bawah") {
                uangPengembalianInput.value = "3250000";
            } else {
                uangPengembalianInput.value = "";
            }

            uangPengembalianInput.dispatchEvent(new Event("input"));
        });
    });
</script>
