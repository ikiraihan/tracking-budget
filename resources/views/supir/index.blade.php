@extends('layouts.main')

@section('content')
<div class="container-fluid">
    {{-- <div class="mb-2">
        <a href="/truk/create" type="button" class="btn btn-primary-transparent">
            Tambah Truk
        </a>
    </div> --}}
    <div class="card custom-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">Data Supir</div>
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
                                    <th>No.</th>
                                    <th style="width: 10px;">Aksi</th>
                                    <th style="width: 200px;">Foto Diri</th>
                                    <th>Nama</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    {{-- <th>No. KTP</th>
                                    <th style="width: 200px;">Foto KTP</th>
                                    <th>No. SIM</th>
                                    <th style="width: 200px;">Foto SIM</th> 
                                    <th>Jenis Truk</th>
                                    <th>No. Polisi</th> --}}
                                    <th>Status Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supirs as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>
                                            @if($item->is_verifikasi == true)
                                            <div class="btn-list">
                                                <a href="/supir/detail/{{ $item->id }}" class="btn btn-teal-transparent"><i class="fa-solid fa-eye"></i></a>
                                                <a href="/supir/edit/{{ $item->id }}" class="btn btn-warning-transparent"><i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/supir/change-password/{{ $item->user_id }}" class="btn btn-primary-transparent"><i class="fas fa-key"></i></a>                                                                
                                                {{-- <form action="/supir/delete/{{ $item->user_id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-danger-transparent"
                                                        onclick="return confirm('Hapus Data?')"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>   --}}
                                            </div> 
                                            @else
                                            <div class="btn-list">
                                                <a href="/supir/verifikasi-form/{{ $item->id }}" class="btn btn-success-transparent">Verifikasi Akun?</a>                                                                  
                                            </div> 
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->path_photo_diri)
                                                <img src="{{ asset($item->path_photo_diri) }}" alt="Foto Diri" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ $item->telepon ?? '-' }}</td>
                                        <td>{{ $item->alamat ?? '-' }}</td>
                                        {{--
                                        <td>{{ $item->no_ktp ?? '-' }}</td>
                                        <td>
                                            @if ($item->path_photo_ktp)
                                            <a href="{{ asset($item->path_photo_ktp) }}" target="_blank" style="color: blue; text-decoration: underline;">
                                                Lihat Foto
                                            </a>
                                                <img src="{{ asset($item->path_photo_ktp) }}" alt="Foto KTP" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->no_sim ?? '-' }}</td>
                                        <td>
                                            @if ($item->path_photo_sim)
                                                <img src="{{ asset($item->path_photo_sim) }}" alt="Foto SIM" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td> 
                                        <td>{{ $item->truk_nama ?? '-' }}</td>
                                        <td>{{ $item->truk_no_polisi ?? '-' }}</td>  --}}
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

                <!-- Tab Tidak Aktif -->
                <div class="tab-pane fade text-muted" id="tidak-aktif" role="tabpanel">
                    <div class="table-responsive">
                        <table id="datatable-tidak-aktif" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width: 10px;">Aksi</th>
                                    <th style="width: 200px;">Foto Diri</th>
                                    <th>Nama</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    {{-- <th>No. KTP</th>
                                    <th style="width: 200px;">Foto KTP</th>
                                    <th>No. SIM</th>
                                    <th style="width: 200px;">Foto SIM</th> 
                                    <th>Jenis Truk</th>
                                    <th>No. Polisi</th> --}}
                                    <th>Status Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supirsInactive as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="/supir/detail/{{ $item->id }}" class="btn btn-teal-transparent"><i class="fa-solid fa-eye"></i></a>
                                                <a href="/supir/edit/{{ $item->id }}" class="btn btn-warning-transparent"><i class="fas fa-edit"></i>
                                                </a>
                                                <form action="" method="POST" class="d-inline">
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
                                        <td>
                                            @if ($item->path_photo_diri)
                                                <img src="{{ asset($item->path_photo_diri) }}" alt="Foto Diri" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ $item->telepon ?? '-' }}</td>
                                        <td>{{ $item->alamat ?? '-' }}</td>
                                        {{--
                                        <td>{{ $item->no_ktp ?? '-' }}</td>
                                        <td>
                                            @if ($item->path_photo_ktp)
                                            <a href="{{ asset($item->path_photo_ktp) }}" target="_blank" style="color: blue; text-decoration: underline;">
                                                Lihat Foto
                                            </a>
                                                <img src="{{ asset($item->path_photo_ktp) }}" alt="Foto KTP" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->no_sim ?? '-' }}</td>
                                        <td>
                                            @if ($item->path_photo_sim)
                                                <img src="{{ asset($item->path_photo_sim) }}" alt="Foto SIM" style="width: 200px; height: auto;">
                                            @else
                                                <span>Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->truk_nama ?? '-' }}</td>
                                        <td>{{ $item->truk_no_polisi ?? '-' }}</td> --}}
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
