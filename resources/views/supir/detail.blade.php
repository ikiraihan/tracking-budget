@extends('layouts.main')

@section('content')
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="GET" action="">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="filterModalLabel">Filter Perjalanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Tambahkan field filter sesuai kebutuhan -->
            <div class="mb-3">
              <label class="form-label">Nama Supir</label>
              <input type="text" name="supir" class="form-control" value="{{ request('supir') }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="is_done" class="form-select">
                <option value="">-- Semua --</option>
                <option value="1" {{ request('is_done') == '1' ? 'selected' : '' }}>Selesai</option>
                <option value="0" {{ request('is_done') == '0' ? 'selected' : '' }}>Belum Selesai</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Terapkan</button>
          </div>
        </div>
      </form>
    </div>
  </div>  
<!-- Start::row-1 -->
<div class="mt-1">
    <a href="/supir" class="btn btn-secondary">
        <i class="bi bi-arrow-left">Kembali</i>
    </a>
</div>
<br>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    <h3>Detail Supir</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-4">
                        <img src="{{ asset($supir->path_photo_diri) }}" 
                             alt="Foto Truk" 
                             class="img-thumbnail rounded" 
                             style="width: auto; height: 200px; object-fit: cover;">
                    </div>
                    <div>
                        <div class="card-title fs-6" style="text-transform: none;">Status Supir : 
                            @if ($item->is_active ?? true)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </div>
                        <div class="card-title fs-6" style="text-transform: none;">Nama : {{ $supir->nama  ?? '-'}}</div>
                        <div class="card-title fs-6" style="text-transform: none;">No. Telp: {{ $supir->telepon ?? '-'}}</div>
                        <div class="card-title fs-6" style="text-transform: none;">Alamat: {{ $supir->alamat ?? '-' }}</div>
                        <div class="card-title fs-6" style="text-transform: none;">
                            Truk yang Digunakan Sekarang: {{ $supir->truk && $supir->truk->nama ? $supir->truk->nama : '-' }} /
                            {{ $supir->truk && $supir->truk->no_polisi ? $supir->truk->no_polisi : '-' }}
                        </div>
                    </div>    
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Riwayat Perjalanan</h5>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>      
                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>Truk</th>
                                <th>Rute</th>
                                <th>Budget</th>
                                <th>Pemasukkan</th>
                                <th>Pengeluaran</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perjalanans as $item)
                                <tr>
                                    <td> {{ $supir->truk && $supir->truk->nama ? $supir->truk->nama : '-' }} /
                                        {{ $supir->truk && $supir->truk->no_polisi ? $supir->truk->no_polisi : '-' }}
                                    </td>
                                    <td>
                                        {{ 
                                            str_replace(['KABUPATEN', 'KOTA'], '', $item->return_kota_nama) . ' - ' . 
                                            str_replace(['KABUPATEN', 'KOTA'], '', $item->depart_kota_nama) . ' - ' . 
                                            str_replace(['KABUPATEN', 'KOTA'], '', $item->return_kota_nama) 
                                        }}
                                    </td>
                                    <td>Rp. {{ number_format($item->budget ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->income ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->expenditure ?? 0, 0, ',', '.') }}</td>
                                    <th class="{{ ($item->total ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                        Rp. {{ number_format($item->total ?? 0, 0, ',', '.') }}
                                    </th>
                                    <td>
                                        @if ($item->is_done)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Belum Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        
                            {{-- Total row --}}
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total Keseluruhan:</td>
                                <td>Rp. {{ number_format($perjalanans->sum('budget') ?? 0, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($perjalanans->sum('income') ?? 0, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($perjalanans->sum('expenditure') ?? 0, 0, ',', '.') }}</td>
                                <td class="{{ $perjalanans->sum('total') < 0 ? 'text-danger' : 'text-success' }}">
                                    Rp. {{ number_format($perjalanans->sum('total') ?? 0, 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>                     
        </div>
    </div>
</div>
<!-- End::row-1 -->
@endsection
@section('scripts')
<script>

</script>
@endsection