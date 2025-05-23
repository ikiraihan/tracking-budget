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
                                    <label for="tanggal_berangkat" class="form-label" required>Tanggal Keberangkatan<span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat" value="{{ old('tanggal_berangkat', $perjalanan->tanggal_berangkat) }}"required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"for="muatan">Muatan<span style="color: red;">*</span></label>                                        
                                    <select id="muatan" name="muatan" required>
                                        {{-- <option value="" {{ old('muatan', $perjalanan->muatan ?? '') === '' ? 'selected' : '' }}>-- Pilih Muatan --</option> --}}
                                        @foreach($muatans as $muatan)
                                            <option value="{{ $muatan }}">{{ $muatan }}
                                            </option>
                                        @endforeach
                                    </select>                                                                          
                                </div> 
                                <?php 
                                ?>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="uang_kembali" required>Uang Kembali</label>
                                    <input type="text" id="uang_kembali" name="uang_kembali" value="{{ old('uang_kembali', $uangKembaliOld) }}" class="form-control" placeholder="Masukkan Uang Kembali.." required>
                                </div>
                                {{-- Foto Diri --}}
                                <div class="col-md-6 mb-2" id="formStrukKembali">
                                    <label for="photo_struk_kembali" class="form-label">Foto Struk Kembali <span style="color: red;">*</span></label>
                                    <input type="file" class="form-control @error('photo_struk_kembali') is-invalid @enderror" 
                                        id="photo_struk_kembali" name="photo_struk_kembali" accept="image/*" {{ isset($perjalanan->path_struk_kembali) ? '' : 'required' }}>                                   
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
                                <div class="col-md-6" id="formDate" style="display: none;">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Akhir Perjalanan</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" value="{{ old('tanggal_kembali', $perjalanan->tanggal_kembali) }}" name="tanggal_kembali">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3" id="formTujuan" style="display: none;">
                                        <label class="form-label" for="kota_tujuan_slug">Tujuan Bongkar Akhir</label>   
                                        <select class="form-control @error('kota_tujuan_slug') is-invalid @enderror" name="kota_tujuan_slug" id="kota_tujuan_slug">                                     
                                            <option value="">-- Pilih Tujuan --</option>
                                            @foreach($kotaTujuans as $tujuan)
                                            <option value="{{ $tujuan->slug }}" 
                                                {{ old('kota_tujuan_slug', $perjalanan->kota_tujuan_slug) == $tujuan->slug ? 'selected' : '' }}>
                                                {{ $tujuan->nama }}
                                            </option>
                                            @endforeach 
                                        </select>                                                                        
                                    </div>
                                </div> 
                                <div class="col-md-6 mb-3">
                                    <div class="form-group mb-3" id="formJalur" style="display: none;">
                                        <label class="form-label" for="jalur_slug">Jalur</label>   
                                        <select class="form-control @error('jalur_slug') is-invalid @enderror" name="jalur_slug" id="jalur_slug">                                     
                                            <option value="">-- Pilih Jalur --</option>
                                            @foreach($jalurs as $jalur)
                                            <option value="{{ $jalur->slug }}" 
                                                data-uang_pengembalian_tol="{{ $jalur->uang_pengembalian_tol }}"
                                                {{ old('jalur_slug', $perjalanan->jalur_slug) == $jalur->slug ? 'selected' : '' }}>
                                                {{ $jalur->nama }}
                                            </option>
                                            @endforeach 
                                        </select>                                                                        
                                    </div>
                                </div> 
                                <div class="col-md-6 mb-3" id="formUangPengembalianTol" style="display: none;">
                                    <label class="form-label" for="uang_pengembalian_tol">Uang Pengembalian Tol</label>
                                    <input type="text" id="uang_pengembalian_tol" name="uang_pengembalian_tol" value="{{ old('uang_pengembalian_tol', $perjalanan->uang_pengembalian_tol) }}" class="form-control bg-secondary-transparent text-black" placeholder="0" readonly>
                                </div>
                                <div id="pengeluaranContainer" style="display: none;">
                                    @php
                                        $pengeluaransOld = old('pengeluaran', $perjalanan->pengeluarans->toArray() ?? []);
                                    @endphp

                                    @foreach($pengeluaransOld as $i => $pengeluaran)
                                        <div class="row pengeluaran-item mb-3">
                                            <input type="hidden" name="pengeluaran[{{ $i }}][id]" value="{{ $pengeluaran['id'] }}">
                                            <div class="col-md-4 mb-2">
                                                <label for="pengeluaran[{{ $i }}][nama]" class="form-label">Nama Pengeluaran</label>
                                                <input type="text" name="pengeluaran[{{ $i }}][nama]" value="{{ old("pengeluaran.$i.nama", $pengeluaran['nama'] ?? '') }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="pengeluaran[{{ $i }}][jumlah]" class="form-label">Jumlah (Rp)</label>
                                                <input type="text" name="pengeluaran[{{ $i }}][jumlah]" value="{{ old("pengeluaran.$i.jumlah", $pengeluaran['uang_pengeluaran'] ?? '') }}" class="form-control uang-input" placeholder="0" required>
                                            </div>
                                            <div class="col-md-4 mb-2 d-flex">
                                                <div class="w-100">
                                                    <label for="pengeluaran[{{ $i }}][photo]" class="form-label">Upload Bukti</label>
                                                    <input id="path_photo_penjualan" type="file" name="pengeluaran[{{ $i }}][photo]" class="form-control" accept="image/*" {{ isset($pengeluaran['path_photo']) ? '' : 'required' }}>
                                                    <div class="mt-2">
                                                        <img id="preview-path_photo_penjualan" 
                                                            src="{{ $pengeluaran['path_photo']  ? asset($pengeluaran['path_photo']) : '#' }}" 
                                                            alt="Preview Foto Struk" 
                                                            class="img-thumbnail" 
                                                            width="100"
                                                            style="{{ $pengeluaran['path_photo'] ? '' : 'display: none;' }}"
                                                            data-old-src="{{ $pengeluaran['path_photo'] ? asset($pengeluaran['path_photo']) : '' }}">
                                                    </div>
                                                    {{-- @if(isset($pengeluaran['path_photo']))
                                                        <div class="mt-2">
                                                            <img src="{{ asset($pengeluaran['path_photo']) }}" alt="Bukti" class="img-thumbnail" width="100">
                                                        </div>
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2 d-flex justify-content-center">
                                                <button type="button" class="btn btn-danger-transparent ms-2 delete-pengeluaran-btn" onclick="this.closest('.pengeluaran-item').remove()">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-12 mb-3" id="buttonPengeluaran" style="display: none">
                                    <button type="button" class="btn btn-outline-primary" id="addPengeluaranBtn">+ Tambah Detail Pengeluaran</button>
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
        const returnJalur = document.getElementById('jalur_slug');
        const returnTujuan = document.getElementById('kota_tujuan_slug');

        document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formUangPengembalianTol').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formJalur').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formTujuan').style.display = isChecked ? 'block' : 'none';
        document.getElementById('buttonPengeluaran').style.display = isChecked ? 'block' : 'none';
        document.getElementById('pengeluaranContainer').style.display = isChecked ? 'block' : 'none';

        if (isChecked) {
            returnDate.setAttribute('required', 'required');
            returnUangPengembalianTol.setAttribute('required', 'required');
            returnJalur.setAttribute('required', 'required');
            returnTujuan.setAttribute('required', 'required');
        } else {
            returnDate.removeAttribute('required');
            returnUangPengembalianTol.removeAttribute('required');
            returnJalur.removeAttribute('required');
            returnTujuan.removeAttribute('required');
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        if ({{ old('is_done', $perjalanan->is_done) ? 'true' : 'false' }}) {
            toggleForm();
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const jalurSelect = document.getElementById("jalur_slug"); 
        const uangPengembalianInput = document.getElementById("uang_pengembalian_tol");

        jalurSelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const uangPengembalian = selectedOption.getAttribute("data-uang_pengembalian_tol");

            uangPengembalianInput.value = uangPengembalian || "";
            uangPengembalianInput.dispatchEvent(new Event("input")); // agar langsung diformat rupiah
        });
    });
document.addEventListener('DOMContentLoaded', function () {
    let counter = document.querySelectorAll('.pengeluaran-item').length;

    const container = document.getElementById('pengeluaranContainer');
    const button = document.getElementById('addPengeluaranBtn');

    button.addEventListener('click', function () {
        const html = `
            <div class="row pengeluaran-item mb-3">
                <div class="col-md-4 mb-2">
                    <label for="pengeluaran[${counter}][nama]" class="form-label">Nama Pengeluaran</label>
                    <input type="text" name="pengeluaran[${counter}][nama]" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="pengeluaran[${counter}][jumlah]" class="form-label">Jumlah (Rp)</label>
                    <input type="text" name="pengeluaran[${counter}][jumlah]" class="form-control uang-input" placeholder="0" required>
                </div>
                <div class="col-md-4 mb-2 d-flex">
                    <div class="w-100">
                        <label for="pengeluaran[${counter}][photo]" class="form-label">Upload Bukti</label>
                        <input type="file" name="pengeluaran[${counter}][photo]" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="col-md-12 mb-2 d-flex justify-content-center">
                    <button type="button" class="btn btn-danger-transparent ms-2 delete-pengeluaran-btn" onclick="this.closest('.pengeluaran-item').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        counter++;

        // format ulang input uang
        applyInitialFormat(); 
    });
});

</script>

