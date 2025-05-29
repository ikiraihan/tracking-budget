@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Form Perjalanan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                            <form id="formPerjalanan" action="{{ route('perjalanan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf                        
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_berangkat" class="form-label">Tanggal Keberangkatan<span style="color: red;">*</span></label>
                                        <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="muatan">Muatan<span style="color: red;">*</span></label>
                                        <select id="muatan" name="muatan" required>
                                            {{-- <option value="" {{ old('muatan', $perjalanan->muatan ?? '') === '' ? 'selected' : '' }}>-- Pilih Muatan --</option> --}}
                                            @foreach($muatans as $muatan)
                                                <option value="{{ $muatan }}">{{ $muatan }}
                                                </option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    {{-- <div class="col-md-6 mb-3" id="formUangSubsidiTol">
                                        <label class="form-label" for="uang_subsidi_tol">Uang Subsidi<span style="color: red;">*</span></label>
                                        <input type="text" id="uang_subsidi_tol" name="uang_subsidi_tol" class="form-control" placeholder="Masukkan Uang Subsidi.." required>
                                    </div>
                                    <div class="col-md-6 mb-3" id="formUangSubsidiSetoran">
                                        <label class="form-label" for="uang_setoran">Uang Setoran<span style="color: red;">*</span></label>
                                        <input type="text" id="uang_setoran" name="uang_setoran" class="form-control" placeholder="Masukkan Uang Setoran.." required>
                                    </div> --}}
                                    <div class="col-md-6 mb-3" id="formUangKembali">
                                        <label class="form-label" for="uang_kembali">Uang Kembali<span style="color: red;">*</span></label>
                                        <input type="text" id="uang_kembali" name="uang_kembali" class="form-control" placeholder="Masukkan Uang Kembali.." required>
                                    </div> 
                                    <div class="col-md-6 mb-2" id="formStrukKembali">
                                        <label for="photo_struk_kembali" class="form-label">Foto Struk Kembali<span style="color: red;">*</span></label>
                                        <input type="file" class="form-control @error('photo_struk_kembali') is-invalid @enderror" 
                                            id="photo_struk_kembali" name="photo_struk_kembali" accept="image/*" required>
                                        @error('photo_struk_kembali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <img id="preview-photo_struk_kembali" 
                                                src="#" 
                                                alt="Preview Foto Struk" 
                                                class="img-thumbnail" 
                                                width="150"
                                                style="display: none;">
                                        </div>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary">
                                        Kirim
                                    </button>                           
                                    <button type="button" id="btnLoading" class="btn btn-primary d-none" disabled>
                                        <i class="ri-loader-2-fill fs-16 me-2"></i> Loading...
                                    </button>
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
    // function toggleForm() {
    //     const isChecked = document.getElementById('gridCheck').checked;

    //     const returnDate = document.getElementById('tanggal_kembali');
    //     const returnUangPengembalianTol = document.getElementById('uang_pengembalian_tol');
    //     const returnJalur = document.getElementById('jalur');

    //     document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';
    //     document.getElementById('formUangPengembalianTol').style.display = isChecked ? 'block' : 'none';
    //     document.getElementById('formJalur').style.display = isChecked ? 'block' : 'none';

    //     if (isChecked) {
    //         returnDate.setAttribute('required', 'required');
    //         returnUangPengembalianTol.setAttribute('required', 'required');
    //         returnJalur.setAttribute('required', 'required');
    //     } else {
    //         returnDate.removeAttribute('required');
    //         returnUangPengembalianTol.removeAttribute('required');
    //         returnJalur.removeAttribute('required');
    //     }
    // }

    document.addEventListener('DOMContentLoaded', function () {
        // toggleForm(); // pastikan kondisi awal sesuai checkbox

        const form = document.getElementById('formPerjalanan');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnLoading = document.getElementById('btnLoading');

        form.addEventListener('submit', function () {
            btnSubmit.classList.add('d-none');
            btnLoading.classList.remove('d-none');
        });

        // Jika pengguna mengubah checkbox manual setelah halaman dibuka
        const checkbox = document.getElementById('gridCheck');
        checkbox.addEventListener('change', toggleForm);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const jalurSelect = document.getElementById("jalur");
        const uangPengembalianInput = document.getElementById("uang_pengembalian_tol");

        jalurSelect.addEventListener("change", function () {
            const value = this.value;
            if (value === "full-tol") {
                uangPengembalianInput.value = 4200000;
            } else if (value === "setengah-tol") {
                uangPengembalianInput.value = 3750000;
            } else if (value === "bawah") {
                uangPengembalianInput.value = 3250000;
            } else {
                uangPengembalianInput.value = "";
            }

            uangPengembalianInput.dispatchEvent(new Event("input"));
        });
    });
</script>
<script>
    //     function toggleForm() {
    //     const isChecked = document.getElementById('gridCheck').checked;

    //     const returnDate = document.getElementById('tanggal_kembali');
    //     const returnUangPengembalianTol = document.getElementById('uang_pengembalian_tol');
    //     const returnJalur = document.getElementById('jalur');

    //     document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';
    //     document.getElementById('formUangPengembalianTol').style.display = isChecked ? 'block' : 'none';
    //     document.getElementById('formJalur').style.display = isChecked ? 'block' : 'none';

    //     if (isChecked) {
    //         returnDate.setAttribute('required', 'required');
    //         returnUangPengembalianTol.setAttribute('required', 'required');
    //         returnJalur.setAttribute('required', 'required');
    //     } else {
    //         returnDate.removeAttribute('required');
    //         returnUangPengembalianTol.removeAttribute('required');
    //         returnJalur.removeAttribute('required');
    //     }
    // }
// document.addEventListener('DOMContentLoaded', function () {
//     const provinsiSelect = document.getElementById('depart_provinsi_id');
//     if (!provinsiSelect) {
//         console.error('Elemen depart_provinsi_id tidak ditemukan');
//         return;
//     }

//     const kotaSelect = document.getElementById('depart_kota_id');
//     let kotaChoices; // Mendeklarasikan variabel untuk Choices.js

//     // Inisialisasi Choices.js hanya jika belum diinisialisasi
//     if (kotaSelect && !kotaChoices) {
//         kotaChoices = new Choices(kotaSelect, {
//             searchEnabled: true,
//             itemSelectText: '',
//         });
//     }

//     provinsiSelect.addEventListener('change', function () {
//         const provinsiId = this.value;
//         console.log('Provinsi ID:', provinsiId);
//         if (provinsiId) {
//             // Hapus semua pilihan kota yang lama
//             kotaSelect.innerHTML = '<option selected disabled>Pilih Kota</option>'; // Reset pilihan kota
            
//             // Atau jika menggunakan Choices.js
//             kotaChoices.clearChoices();

//             fetch(`/get-kota-by-provinsi/${provinsiId}`)
//                 .then((response) => {
//                     if (!response.ok) {
//                         throw new Error(`HTTP error! status: ${response.status}`);
//                     }
//                     return response.json();
//                 })
//                 .then((data) => {
//                     console.log('Data kota yang diterima:', data);
//                     if (data.kotas && Array.isArray(data.kotas)) {
//                         let options = '<option selected disabled>Pilih Kota</option>';
//                         data.kotas.forEach((kota) => {
//                             options += `<option value="${kota.id}">${kota.nama}</option>`;
//                         });

//                         // Isi dropdown kota dengan data baru
//                         kotaSelect.innerHTML = options;

//                         // Perbarui Choices.js dengan data baru
//                         kotaChoices.setChoices(data.kotas.map(kota => ({ value: kota.id, label: kota.nama })), 'value', 'label', false);
//                     }
//                 })
//                 .catch((error) => {
//                     console.error('Error:', error);
//                 });
//         }
//     });
// });
// document.addEventListener('DOMContentLoaded', function () {
//     const provinsiSelect = document.getElementById('return_provinsi_id');
//     if (!provinsiSelect) {
//         console.error('Elemen return_provinsi_id tidak ditemukan');
//         return;
//     }

//     const kotaSelect = document.getElementById('return_kota_id');
//     let kotaChoices; // Mendeklarasikan variabel untuk Choices.js

//     // Inisialisasi Choices.js hanya jika belum diinisialisasi
//     if (kotaSelect && !kotaChoices) {
//         kotaChoices = new Choices(kotaSelect, {
//             searchEnabled: true,
//             itemSelectText: '',
//         });
//     }

//     provinsiSelect.addEventListener('change', function () {
//         const provinsiId = this.value;
//         console.log('Provinsi ID:', provinsiId);
//         if (provinsiId) {
//             // Hapus semua pilihan kota yang lama
//             kotaSelect.innerHTML = '<option selected disabled>Pilih Kota</option>'; // Reset pilihan kota
            
//             // Atau jika menggunakan Choices.js
//             kotaChoices.clearChoices();

//             fetch(`/get-kota-by-provinsi/${provinsiId}`)
//                 .then((response) => {
//                     if (!response.ok) {
//                         throw new Error(`HTTP error! status: ${response.status}`);
//                     }
//                     return response.json();
//                 })
//                 .then((data) => {
//                     console.log('Data kota yang diterima:', data);
//                     if (data.kotas && Array.isArray(data.kotas)) {
//                         let options = '<option selected disabled>Pilih Kota</option>';
//                         data.kotas.forEach((kota) => {
//                             options += `<option value="${kota.id}">${kota.nama}</option>`;
//                         });

//                         // Isi dropdown kota dengan data baru
//                         kotaSelect.innerHTML = options;

//                         // Perbarui Choices.js dengan data baru
//                         kotaChoices.setChoices(data.kotas.map(kota => ({ value: kota.id, label: kota.nama })), 'value', 'label', false);
//                     }
//                 })
//                 .catch((error) => {
//                     console.error('Error:', error);
//                 });
//         }
//     });
// });
// });
</script>
    