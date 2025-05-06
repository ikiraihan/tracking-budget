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
                        <form action="{{ route('perjalanan.store') }}" method="POST">
                            @csrf                        
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label for="jalur">Jalur</label>                                        
                                        <select id="jalur" name="jalur" class="form-control" required>
                                            <option selected disabled>Pilih Kota</option>
                                            <option value="full-tol">Full Tol</option>
                                            <option value="setengah-tol">Setengah Tol</option>
                                            <option value="bawah">Bawah</option>
                                        </select>                                                                          
                                    </div>
                                </div> 
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="uang_pengembalian_tol">Uang Pengembalian Tol</label>
                                    <input type="text" id="uang_pengembalian_tol" name="uang_pengembalian_tol" class="form-control bg-secondary-transparent text-black" placeholder="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_berangkat" class="form-label" required>Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="uang_kembali" required>Uang Kembali</label>
                                    <input type="text" id="uang_kembali" name="uang_kembali" class="form-control" placeholder="Masukkan Uang Kembali.." required>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="is_done" value="1" onchange="toggleForm()">
                                    <label class="form-check-label" for="gridCheck">
                                        Apakah Perjalanan sudah dilakukan?
                                    </label>
                                </div>
                            </div>        
                            <div class="row">
                                <div class="col-md-6 mb-3" id="formDate" style="display: none;">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali">
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
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

        document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';

        if (isChecked) {
            returnDate.setAttribute('required', 'required');
        } else {
            returnDate.removeAttribute('required');
        }
    }
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
    