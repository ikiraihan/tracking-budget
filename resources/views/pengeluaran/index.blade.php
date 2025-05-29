@extends('layouts.main')

@section('content')    
<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    Data Pengeluaran
                </div>
                <form action="" method="GET" class="ms-auto">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                <input type="text" class="form-control" id="date_range" name="date_range" value="{{ old('date_range', $dateRange) }}" placeholder="Pilih Range Tanggal">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="applyFilterPengeluaran" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-perjalanan" class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 5px">No</th>
                                <th style="width: 20px;">Aksi</th>
                                <th>Nama Truk</th>
                                <th>Uang Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluarans as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>
                                        <div class="btn-list">
                                            <button class="btn btn-teal-transparent" data-id="{{ $item->truk_id }}" data-bs-toggle="modal" data-bs-target="#detailPengeluaran">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $item->nama ?? '-' }}</td>
                                    <td>Rp. {{ number_format($item->uang_pengeluaran ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Total Keseluruhan:</td>
                                <td>Rp. {{ number_format($pengeluarans->sum('uang_pengeluaran') ?? 0, 0, ',', '.') }}</td>
                                {{-- <td class="{{ $perjalanan->sum('total') < 0 ? 'text-danger' : 'text-success' }}">
                                    Rp. {{ number_format($perjalanan->sum('total') ?? 0, 0, ',', '.') }}
                                </td> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->
<div class="modal fade" id="detailPengeluaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Pengeluaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pengeluaranList">
                <p class="text-muted">Memuat data pengeluaran...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     document.getElementById('applyFilterPengeluaran').addEventListener('click', function () {
        const dateRange = document.getElementById('date_range').value;
        const baseUrl = `/pengeluaran`;

        let queryParams = [];
        if (dateRange) {
            queryParams.push(`date_range=${dateRange}`);
        }

        const queryString = queryParams.length > 0 ? `?${queryParams.join('&')}` : '';
        const finalUrl = baseUrl + queryString;

        window.location.href = finalUrl;
    });

    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function () {
    const detailModal = document.getElementById('detailPengeluaran');
    const dateRange = @json($dateRange);

    detailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const trukId = button.getAttribute('data-id');
        const container = document.getElementById('pengeluaranList');

        container.innerHTML = `<p class="text-muted">Memuat data pengeluaran...</p>`;

        fetch(`/pengeluaran/show/${trukId}?date_range=${encodeURIComponent(dateRange)}`)
            .then(response => response.json())
            .then(data => {
                if (data.pengeluarans.length > 0) {
                    const listHtml = data.pengeluarans.map(p => {
                        const perjalananLink = p.perjalanan_hash && p.perjalanan_id
                            ? `<a href="/perjalanan/detail/${p.perjalanan_id}" target="_blank" class="text-decoration-underline text-primary">${p.perjalanan_hash}</a>`
                            : "-";

                        const fileLink = p.path_photo
                            ? `<a href="${p.path_photo}" target="_blank" class="text-decoration-underline text-primary">Lihat File</a>`
                            : "-";

                        return `
                            <div class="mb-3 text-start">
                                <label class="fw-semibold">ID Perjalanan</label>
                                <input type="text" class="form-control bg-light mb-2 text-primary text-decoration-underline" value="${p.perjalanan_hash ?? '-'}" readonly onclick="window.open('/perjalanan/detail/${p.perjalanan_id}', '_blank')">

                                <label class="fw-semibold">Nama Pengeluaran</label>
                                <input type="text" class="form-control bg-light mb-2" value="${p.nama}" readonly>

                                <label class="fw-semibold">Jumlah Pengeluaran</label>
                                <input type="text" class="form-control bg-light mb-2" value="Rp. ${Number(p.uang_pengeluaran).toLocaleString()}" readonly>

                                <label class="fw-semibold">Bukti Pembayaran</label>
                                <div>${fileLink}</div>
                            </div>
                            <hr>
                        `;
                    }).join("");

                    container.innerHTML = listHtml;
                } else {
                    container.innerHTML = `<p class="text-muted">Tidak ada data pengeluaran untuk truk ini.</p>`;
                }
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<p class="text-danger">Gagal memuat data.</p>`;
            });
    });
});
</script>

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
{{-- @section('script')
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
@endsection --}}