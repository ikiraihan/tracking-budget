@extends('layouts.main')

@section('content')
<style>
    .route-wrapper {
        position: relative;
        max-width: 300px;
        margin: 20px auto 10px auto;
    }

    .route-label {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        font-size:18px;
        font-weight: 600;
        font-family: sans-serif;
    }

    .route-line {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 5px;
        background-color: #0162e8;
        transform: translateY(-50%);
        z-index: 0;
    }

    .route-dots {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 1;
    }

    .dot {
        width: 12px;
        height: 12px;
        background-color: #0162e8;
        border-radius: 50%;
    }

    .label-container {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        font-family: sans-serif;
        margin-top: 6px;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .label-container span {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .label-container span:first-child {
        text-align: left;
    }

    .label-container span:last-child {
        text-align: right;
    }

</style>


<!-- Start::row-1 -->
<div class="mt-1">
    <a href="/perjalanan" class="btn btn-secondary">
        <i class="bi bi-arrow-left">Kembali</i>
    </a>
</div>
<br>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    <h3>Detail Perjalanan</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <!-- Rute Visual -->
                    <div class="w-100">
                        <div class="route-wrapper">
                            <div class="route-label">Rute</div>
                            <div class="route-line"></div>
                            <div class="route-dots">
                                <div class="dot"></div>
                                <div class="dot"></div>
                                <div class="dot"></div>
                            </div>
                        </div>
                        <div class="label-container">
                            <span>{{ ucwords(strtolower(str_replace(['KABUPATEN', 'KOTA'], '', $perjalanan->return_kota_nama))) }}</span>
                            <span>{{ ucwords(strtolower(str_replace(['KABUPATEN', 'KOTA'], '', $perjalanan->depart_kota_nama))) }}</span>
                            <span>{{ ucwords(strtolower(str_replace(['KABUPATEN', 'KOTA'], '', $perjalanan->return_kota_nama))) }}</span>
                        </div>                                
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="mb-4 main-content-label">Personal Information</div> --}}
                    <form class="form-horizontal">
                        {{-- <div class="mb-4 main-content-label">Name</div> --}}
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Status Perjalanan</label>
                                </div>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control {{ $perjalanan->is_done == 1 ? 'bg-success text-white' : 'bg-danger text-white' }}"  
                                        placeholder="Status Perjalanan" 
                                        value="{{ $perjalanan->is_done == 1 ? 'Selesai' : 'Belum Selesai' }}" 
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>                        
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Tanggal Berangkat</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->tanggal_berangkat_format ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Tanggal Kembali</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->tanggal_kembali_format ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Budget</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light"  placeholder="Nick Name" value="Rp. {{ number_format($perjalanan->budget ?? 0, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Pemasukan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light"  placeholder="Nick Name" value="Rp. {{ number_format($perjalanan->income ?? 0, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Pengeluaran</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light"  placeholder="Nick Name" value="Rp. {{ number_format($perjalanan->expenditure ?? 0, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Total</label>
                                </div>
                                <div class="col-md-9">
                                    <input 
                                    type="text" 
                                    class="form-control 
                                    @if(($perjalanan->total ?? 0) < 0)
                                        bg-danger text-white
                                    @elseif(($perjalanan->total ?? 0) > 0)
                                        bg-success text-white
                                    @endif" 
                                    placeholder="Nick Name" value="Rp. {{ number_format($perjalanan->total ?? 0, 0, ',', '.') }}"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">Info Supir</div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Nama</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->supir_nama ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">No. Telepon</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->supir_telepon ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">Info Truk</div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">No. Polisi</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->truk_nopol ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium">Jenis</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-light" value="{{ $perjalanan->truk_nama ?? '-'}}" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                     
        </div>
    </div>
</div>
<!-- End::row-1 -->
@endsection