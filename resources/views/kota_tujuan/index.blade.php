@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="mb-2">
        <a href="/kota-tujuan/create" type="button" class="btn btn-primary-transparent">
            Tambah Tujuan Akhir
        </a>
    </div>
    <div class="card custom-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">Data Tujuan Akhir</div>
            {{-- <ul class="nav nav-pills nav-style-2 mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#aktif" role="tab" aria-selected="true">Aktif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tidak-aktif" role="tab" aria-selected="false">Tidak Aktif</a>
                </li>
            </ul> --}}
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- Tab Aktif -->
                <div class="tab-pane fade show active text-muted" id="aktif" role="tabpanel">
                    <div class="table-responsive">
                        <table id="datatable-aktif" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th style="width: 20px;">Aksi</th>
                                    <th>Nama</th>
                                    <th>Uang Tambahan Setoran</th>
                                    <th>Status Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kotaTujuans as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="/kota-tujuan/edit/{{ $item->id }}" class="btn btn-warning-transparent"><i class="fas fa-edit"></i>
                                                </a>                                                           
                                                <form action="/kota-tujuan/delete/{{ $item->id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-danger-transparent"
                                                        onclick="return confirm('Hapus Data?')"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>  
                                            </div> 
                                        </td>
                                        <td>{{ $item->nama ?? '-' }}</td>
                                        <td>Rp. {{ number_format($item->uang_setoran_tambahan ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($item->is_active ?? true)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#datatable-aktif').DataTable({
            responsive: true,
            deferRender: true,
            pageLength: 10,
            language: {
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Selanjutnya',
                    previous: 'Sebelumnya'
                },
                search: "",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            },
            initComplete: function () {
                $('div.dataTables_filter input').attr('placeholder', 'Cari data...').addClass('form-control');
            }
        });

        $('#datatable-tidak-aktif').DataTable({
            responsive: true,
            deferRender: true,
            pageLength: 10,
            language: {
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Selanjutnya',
                    previous: 'Sebelumnya'
                },
                search: "",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            },
            initComplete: function () {
                $('div.dataTables_filter input').attr('placeholder', 'Cari data...').addClass('form-control');
            }
        });
    });
</script>
@endsection
