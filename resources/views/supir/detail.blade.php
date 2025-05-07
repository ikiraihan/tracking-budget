@extends('layouts.main')

@section('content')
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="GET"  id="filterForm" action="/supir/detail/{{ $supir->id }}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="filterModalLabel">Filter Perjalanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Tambahkan field filter sesuai kebutuhan -->
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="text" id="daterange" name="date_range" class="form-control form-control-sm" value="{{ old('date_range', $dateRange ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-control form-control-sm @error('is_done') is-invalid @enderror" name="is_done" id="is_done">
                    <option value="" {{ old('is_done', $isDone) === null ? 'selected' : '' }}>-- Semua Status --</option>
                    <option value="1" {{ old('is_done', $isDone) === '1' ? 'selected' : '' }}>Selesai</option>
                    <option value="0" {{ old('is_done', $isDone) === '0' ? 'selected' : '' }}>Belum Selesai</option>
                </select>
                @error('is_done')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="resetFilter">Reset Filter</button>
            <button type="submit" class="btn btn-primary" id="applyFilter">Terapkan</button>
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
                    @if ($supir->path_photo_diri)
                    <div class="me-4">
                        <img src="{{ asset($supir->path_photo_diri) }}" 
                             alt="Foto Supir" 
                             class="img-thumbnail rounded" 
                             style="width: auto; height: 200px; object-fit: cover;">
                    </div>
                    @endif
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
                                <th style="width: 5px">No</th>
                                <th>ID Perjalanan</th>
                                <th>Tanggal Perjalanan</th>
                                <th>Nama Truk</th>
                                <th>Jalur</th>
                                <th>Uang Kembali</th>
                                {{-- <th>Sisa</th> --}}
                                <th>Bayaran Supir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perjalanans as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ $item->hash ?? '-' }}</td>
                                    <td>{{ $item->tanggal_berangkat_format ?? 'N/A' }} - {{ $item->tanggal_kembali_format ?? 'N/A' }}</td>
                                    <td>{{ $item->truk_nama ?? '-' }}</td>
                                    <td>
                                        @if ($item->jalur == 'full-tol')
                                            Full Tol
                                        @elseif ($item->jalur == 'setengah-tol')
                                            Setengah Tol
                                        @elseif ($item->jalur == 'bawah')
                                            Bawah
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Rp. {{ number_format($item->uang_kembali ?? 0, 0, ',', '.') }}</td>
                                    {{-- <td>Rp. {{ number_format($item->sisa ?? 0, 0, ',', '.') }}</td> --}}
                                    <td>Rp. {{ number_format($item->bayaran_supir ?? 0, 0, ',', '.') }}</td>
                                    {{-- <th class="{{ ($item->total ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                        Rp. {{ number_format($item->total ?? 0, 0, ',', '.') }}
                                    </th> --}}
                                    <td>
                                        @if ($item->is_done)
                                            <span class="badge bg-success ">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Belum Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="5" class="text-end">Total Keseluruhan:</td>
                                <td>Rp. {{ number_format($perjalanans->sum('uang_kembali') ?? 0, 0, ',', '.') }}</td>
                                {{-- <td>Rp. {{ number_format($perjalanans->sum('sisa') ?? 0, 0, ',', '.') }}</td> --}}
                                <td>Rp. {{ number_format($perjalanans->sum('bayaran_supir') ?? 0, 0, ',', '.') }}</td>
                                {{-- <td class="{{ $perjalanan->sum('total') < 0 ? 'text-danger' : 'text-success' }}">
                                    Rp. {{ number_format($perjalanan->sum('total') ?? 0, 0, ',', '.') }}
                                </td> --}}
                                <td></td>
                            </tr>
                        </tfoot>                      
                    </table>
                </div>
            </div>                     
        </div>
    </div>
</div>
<!-- End::row-1 -->
@endsection
{{-- @push('scripts')
<script>
    $(document).ready(function() {
        // Initialize daterangepicker
        $('#daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' - ',
                applyLabel: 'Pilih',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                firstDay: 1
            },
            opens: 'right',
            showDropdowns: true,
            autoUpdateInput: false,
            @if($dateRange && strpos($dateRange, ' - ') !== false)
                startDate: moment('{{ explode(' - ', $dateRange)[0] }}'),
                endDate: moment('{{ explode(' - ', $dateRange)[1] }}'),
            @else
                startDate: moment(),
                endDate: moment(),
            @endif
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('#daterange').on('cancel.daterangepicker', function() {
            $(this).val('');
        });

        // Single calendar for mobile
        $('#daterange').on('show.daterangepicker', function(ev, picker) {
            picker.container.find('.calendar.right').hide();
            picker.container.find('.calendar.left').css('float', 'none');
            picker.container.find('.daterangepicker').css('width', 'auto');
        });

        // Handle form submission
        $('#applyFilter').on('click', function(e) {
            e.preventDefault();
            var form = $('#filterForm');
            var params = [];
            var dateRange = $('#daterange').val();
            var trukId = $('#truk_id').val();
            var supirId = $('#supir_id').val();
            var isDone = $('#is_done').val();
            if (dateRange && dateRange !== '') {
                params.push('date_range=' + encodeURIComponent(dateRange));
            }
            if (trukId && trukId !== '') {
                params.push('truk_id=' + encodeURIComponent(trukId));
            }
            if (supirId && supirId !== '') {
                params.push('supir_id=' + encodeURIComponent(supirId));
            }
            if (isDone && isDone !== '') {
                params.push('is_done=' + encodeURIComponent(isDone));
            }
            var url = form.attr('action');
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            window.location.href = url;
        });

        // Handle reset button
        $('#resetFilter').on('click', function() {
            $('#daterange').val('');
            $('#truk_id').val('');
            $('#supir_id').val('');
            $('#is_done').val('');
            $('#daterange').data('daterangepicker').setStartDate(moment());
            $('#daterange').data('daterangepicker').setEndDate(moment());
        });
    });
</script>
@endpush --}}