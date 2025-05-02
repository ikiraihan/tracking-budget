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
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="depart_kota_id">Kota Asal</label>
                                        <select id="depart_kota_id" name="depart_kota_id" class="form-control" data-trigger required>
                                            <option selected disabled>Pilih Kota</option>
                                            @foreach ($kotas as $kota)
                                                <option value="{{ $kota->id }}" {{ old('depart_kota_id', $perjalanan->depart_kota_id) == $kota->id ? 'selected' : '' }}>
                                                    {{ $kota->nama }}</option>
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
                                                <option value="{{ $kota->id }}" {{ old('return_kota_id', $perjalanan->return_kota_id) == $kota->id ? 'selected' : '' }}>
                                                    {{ $kota->nama }}</option>
                                            @endforeach
                                        </select>                       
                                    </div>
                                </div>  
                            </div>

                            <label class="d-block text-center fw-bold"><h6>Detail</h6></label>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_berangkat" class="form-label" required>Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat" 
                                        value="{{ old('tanggal_berangkat', $perjalanan->tanggal_berangkat) }}" required>
                                    @error('tanggal_berangkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="budget" required>Budget Kantor</label>
                                    <input type="text" id="budget" name="budget" class="form-control" placeholder="Masukkan Budget.." 
                                        value="{{ old('budget', $perjalanan->budget) }}" required>
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <div class="col-md-6 mb-3" id="formDate" style="display: none;">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                        value="{{ old('tanggal_kembali', $perjalanan->tanggal_kembali) }}">
                                </div>
                                <div class="col-md-6 mb-3" id="formPengeluaran" style="display: none;">
                                    <label for="expenditure" class="form-label">Pengeluaran</label>
                                    <input type="text" class="form-control" id="expenditure" name="expenditure"
                                        placeholder="Masukkan Pengeluaran.." value="{{ old('expenditure', $perjalanan->expenditure) }}">
                                </div>
                                <div class="col-md-6 mb-3" id="formPendapatan" style="display: none;">
                                    <label for="income" class="form-label">Pendapatan</label>
                                    <input type="text" class="form-control" id="income" name="income"
                                        placeholder="Masukkan Pendapatan.." value="{{ old('income', $perjalanan->income) }}">
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

        const returnDate = document.getElementById('tanggal_kembali');
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

    document.addEventListener('DOMContentLoaded', function () {
        if ({{ old('is_done', $perjalanan->is_done) ? 'true' : 'false' }}) {
            toggleForm();
        }
    });


</script>
