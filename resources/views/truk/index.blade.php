@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="mb-2">
        @if($role == 'admin')
        <a href="/truk/create" type="button" class="btn btn-primary-transparent">
            Tambah Truk
        </a>
        @endif
    </div>
    <div class="card custom-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">Data Truk</div>
            <ul class="nav nav-pills nav-style-2 mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#aktif" role="tab" aria-selected="true">Aktif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tidak-aktif" role="tab" aria-selected="false">Tidak Aktif</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- Tab Aktif -->
                <div class="tab-pane fade show active text-muted" id="aktif" role="tabpanel">
                    <div class="table-responsive">
                        <table id="datatable-aktif" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width: 5px">No</th> <!-- Added count column header -->
                                    <th>Aksi</th>
                                    <th>Foto</th>
                                    <th>Nama Truk</th>
                                    <th>No. Polisi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($truks as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="/truk/detail/{{ $item->id }}" class="btn btn-teal-transparent"><i class="fa-solid fa-eye"></i></a>
                                                {{-- @if($role == 'admin') --}}
                                                <a href="/truk/edit/{{ $item->id }}" class="btn btn-warning-transparent"><i class="fas fa-edit"></i></a>
                                                {{-- @endif --}}
                                                {{-- <form action="/truk/delete/{{ $item->id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger-transparent" onclick="return confirm('Hapus Data?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->path_photo)
                                                <img src="{{ asset($item->path_photo) }}" alt="Foto Truk" style="width: 120px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->nama ?? 'N/A' }}</td>
                                        <td>{{ $item->no_polisi ?? 'N/A' }}</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Tidak Aktif -->
                <div class="tab-pane fade text-muted" id="tidak-aktif" role="tabpanel">
                    <div class="table-responsive">
                        <table id="datatable-tidak-aktif" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width: 5px">No</th>
                                    <th>Aksi</th>
                                    <th>Foto</th>
                                    <th>No. Polisi</th>
                                    <th>Jenis Truk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trukInactives as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="/truk/detail/{{ $item->id }}" class="btn btn-teal-transparent"><i class="fa-solid fa-eye"></i></a>
                                                {{-- @if($role == 'admin') --}}
                                                <a href="/truk/edit/{{ $item->id }}" class="btn btn-warning-transparent"><i class="fas fa-edit"></i></a>
                                                <form action="/truk/delete/{{ $item->id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-transparent" onclick="return confirm('Apakah anda yakin ingin menghapus data secara permanen?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                {{-- @endif --}}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->path_photo)
                                                <img src="{{ asset($item->path_photo) }}" alt="Foto Truk" style="width: 120px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->no_polisi ?? 'N/A' }}</td>
                                        <td>{{ $item->nama ?? 'N/A' }}</td>
                                        <td><span class="badge bg-danger"> Nonaktif</span></td>
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
