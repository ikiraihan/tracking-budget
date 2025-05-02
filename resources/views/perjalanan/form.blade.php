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
                                {{-- <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="depart_provinsi_id">Provinsi</label>
                                        <select class="form-control" data-trigger id="depart_provinsi_id" name="depart_provinsi_id" required>
                                            <option selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="depart_kota_id">Kota Asal</label>
                                        <select id="depart_kota_id" name="depart_kota_id" class="form-control" data-trigger required>
                                            <option selected disabled>Pilih Kota</option>
                                            @foreach ($kotas as $kota)
                                                <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="return_kota_id">Kota Tujuan</label>
                                        <select id="return_kota_id" name="return_kota_id" class="form-control" data-trigger required>
                                            <option selected disabled>Pilih Kota</option>
                                            @foreach ($kotas as $kota)
                                                <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                            @endforeach
                                        </select>                       
                                    </div>
                                </div>  
                            </div>
                            {{-- <label class="d-block text-center fw-bold"><h6>Tujuan</h6></label> --}}
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="return_provinsi_id">Provinsi</label>
                                        <select id="return_provinsi_id" name="return_provinsi_id" class="form-control" data-trigger required>
                                            <option selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>                             
                                    </div>
                                </div>
                            </div> --}}
                        
                            <label class="d-block text-center fw-bold"><h6>Detail</h6></label>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_berangkat" class="form-label" required>Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="budget" required>Budget Kantor</label>
                                    <input type="text" id="budget" name="budget" class="form-control" placeholder="Masukkan Budget.." required>
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
                                <div class="col-md-6 mb-3" id="formPengeluaran" style="display: none;">
                                    <label for="expenditure" class="form-label">Pengeluaran</label>
                                    <input type="text" class="form-control" id="expenditure" name="expenditure" placeholder="Masukkan Pengeluaran..">
                                </div>
                                <div class="col-md-6 mb-3" id="formPendapatan" style="display: none;">
                                    <label for="income" class="form-label">Pendapatan</label>
                                    <input type="text" class="form-control" id="income" name="income" placeholder="Masukkan Pendapatan..">
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
        const expenditure = document.getElementById('expenditure');
        const income = document.getElementById('income');

        document.getElementById('formDate').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formPengeluaran').style.display = isChecked ? 'block' : 'none';
        document.getElementById('formPendapatan').style.display = isChecked ? 'block' : 'none';

        if (isChecked) {
            returnDate.setAttribute('required', 'required');
            expenditure.setAttribute('required', 'required');
            income.setAttribute('required', 'required');
        } else {
            returnDate.removeAttribute('required');
            expenditure.removeAttribute('required');
            income.removeAttribute('required');
        }
    }
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
    