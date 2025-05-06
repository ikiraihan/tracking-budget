@extends('layouts.main')

@section('content')   
<style>
    /* Default styles for larger screens */
    #daterange {
        font-size: 12px;
        padding: 6px;
        max-width: 100%;
    }

    /* Media query for mobile devices (e.g., screens smaller than 576px) */
    @media (max-width: 576px) {
        /* Adjust the input field */
        #daterange {
            font-size: 10px; /* Smaller font size */
            padding: 4px; /* Reduced padding */
            height: 30px; /* Smaller height */
        }

        /* Adjust the modal size */
        .modal-dialog {
            max-width: 90%; /* Make modal narrower */
            margin: 10px auto; /* Center with smaller margins */
        }

        /* Adjust the datepicker container */
        .daterangepicker {
            font-size: 10px; /* Smaller font size for datepicker */
            width: 280px !important; /* Smaller width */
            min-width: unset !important; /* Override min-width */
        }

        /* Adjust calendar table */
        .daterangepicker .calendar-table {
            padding: 2px; /* Reduce padding */
        }

        /* Adjust calendar cells */
        .daterangepicker td,
        .daterangepicker th {
            padding: 2px !important; /* Smaller padding */
            width: 20px !important; /* Smaller cell size */
            height: 20px !important; /* Smaller cell height */
            line-height: 20px !important; /* Adjust line height */
            font-size: 10px; /* Smaller font */
        }

        /* Adjust buttons in the datepicker */
        .daterangepicker .btn {
            font-size: 10px; /* Smaller button text */
            padding: 3px 6px; /* Smaller button padding */
        }

        /* Adjust the ranges section (if used) */
        .daterangepicker .ranges {
            font-size: 10px; /* Smaller font for ranges */
        }

        /* Adjust the modal content */
        .modal-content {
            padding: 10px; /* Reduce padding */
        }

        /* Adjust modal header, body, and footer */
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 8px !important; /* Smaller padding */
        }

        /* Adjust modal title */
        .modal-title {
            font-size: 14px; /* Smaller title */
        }

        /* Adjust form labels and inputs */
        .modal-body .form-label {
            font-size: 12px; /* Smaller label text */
        }

        .modal-body .form-control {
            font-size: 10px; /* Smaller input text */
            padding: 4px; /* Smaller input padding */
            height: 28px; /* Smaller input height */
        }

        /* Adjust modal buttons */
        .modal-footer .btn {
            font-size: 10px; /* Smaller button text */
            padding: 4px 8px; /* Smaller button padding */
        }
    }
</style>   
<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    Data Perjalanan
                </div>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fa fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-perjalanan" class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 5px">No</th>
                                <th style="width: 80px;">Aksi</th>
                                <th>ID Perjalanan</th>
                                <th>Tanggal Perjalanan</th>
                                <th>Nama Truk</th>
                                <th>Jalur</th>
                                <th>Uang Kembali</th>
                                <th>Sisa</th>
                                <th>Bayaran Supir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perjalanan as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>
                                        <div class="btn-list">
                                            <a href="/perjalanan/detail/{{ $item->id }}"class="btn btn-teal-transparent showPerjalanan">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="/perjalanan/edit/{{ $item->id }}" class="btn btn-warning-transparent">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/perjalanan/delete/{{ $item->id }}" method="POST" class="d-inline btn-form">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="btn btn-danger-transparent"
                                                    onclick="return confirm('Hapus Data?')"
                                                    data-id="{{ $item->id ?? '' }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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
                                    <td>Rp. {{ number_format($item->sisa ?? 0, 0, ',', '.') }}</td>
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
                                <td colspan="6" class="text-end">Total Keseluruhan:</td>
                                <td>Rp. {{ number_format($perjalanan->sum('uang_kembali') ?? 0, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($perjalanan->sum('sisa') ?? 0, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($perjalanan->sum('bayaran_supir') ?? 0, 0, ',', '.') }}</td>
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
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="GET" id="filterForm" action="/perjalanan">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="text" id="daterange" name="date_range" class="form-control form-control-sm" value="{{ old('date_range', $dateRange ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Truk</label>
                        <select class="form-control form-control-sm @error('truk_id') is-invalid @enderror" name="truk_id" id="truk_id">
                            <option value="" {{ old('truk_id', $trukId ?? '') === '' ? 'selected' : '' }}>-- Pilih Truk --</option>
                            @foreach($truks as $truk)
                                <option value="{{ $truk->id }}" {{ old('truk_id', $trukId ?? '') == $truk->id ? 'selected' : '' }}>
                                    {{ $truk->no_polisi }} - {{ $truk->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('truk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supir</label>
                        <select class="form-control form-control-sm @error('supir_id') is-invalid @enderror" name="supir_id" id="supir_id">
                            <option value="" {{ old('supir_id', $trukId ?? '') === '' ? 'selected' : '' }}>-- Pilih Supir --</option>
                            @foreach($supirs as $supir)
                                <option value="{{ $supir->id }}" {{ old('supir_id', $supirId ?? '') == $supir->id ? 'selected' : '' }}>
                                    {{ $supir->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('truk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
@endsection
@push('scripts')
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
@endpush
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables baru
        $('#datatable-perjalanan').DataTable({
            dom: 'Bftip',// fp // Menyertakan search box (f), tabel (t), informasi (i), dan pagination (p)
            language: {
                search: 'Cari:',
                zeroRecords: 'Tidak ada data yang cocok',
                searchPlaceholder: 'Masukkan kata kunci...'
            },
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Hitung total untuk kolom Budget, Pemasukkan, Pengeluaran, dan Total
                var budgetTotal = api.column(5, { search: 'applied' }).data().reduce(function(a, b) {
                    return a + parseFloat(b.replace(/[^0-9.-]+/g, '') || 0);
                }, 0);
                var incomeTotal = api.column(6, { search: 'applied' }).data().reduce(function(a, b) {
                    return a + parseFloat(b.replace(/[^0-9.-]+/g, '') || 0);
                }, 0);
                var expenditureTotal = api.column(7, { search: 'applied' }).data().reduce(function(a, b) {
                    return a + parseFloat(b.replace(/[^0-9.-]+/g, '') || 0);
                }, 0);
                var totalTotal = api.column(8, { search: 'applied' }).data().reduce(function(a, b) {
                    return a + parseFloat(b.replace(/[^0-9.-]+/g, '') || 0);
                }, 0);

                // Format total dengan pemisah ribuan
                $(api.column(5).footer()).html('Rp. ' + budgetTotal.toLocaleString('id-ID'));
                $(api.column(6).footer()).html('Rp. ' + incomeTotal.toLocaleString('id-ID'));
                $(api.column(7).footer()).html('Rp. ' + expenditureTotal.toLocaleString('id-ID'));
                $(api.column(8).footer()).html(
                    '<span class="' + (totalTotal < 0 ? 'text-danger' : 'text-success') + '">' +
                    'Rp. ' + totalTotal.toLocaleString('id-ID') +
                    '</span>'
                );
            }
        });
    });
</script>