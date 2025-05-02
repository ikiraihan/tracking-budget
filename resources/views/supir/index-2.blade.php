@extends('layouts.main')

@section('content')

<!-- Start::row-1 -->
<div class="row">
    {{-- <div class="mb-2">
        <a href="/supir/create" type="button" class="btn btn-primary-transparent">
            Tambah Supir
        </a>
    </div> --}}
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Data Supir
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
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
                                <th style="width: 200px;">Foto SIM</th> --}}
                                <th>Jenis Truk</th>
                                <th>No. Polisi</th>
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
                                        @else
                                        <div class="btn-list">
                                            <a href="/supir/detail/{{ $item->id }}" class="btn btn-success-transparent">Verifikasi?</a>                                                                  
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
                                    </td> --}}
                                    <td>{{ $item->truk_nama ?? '-' }}</td>
                                    <td>{{ $item->truk_no_polisi ?? '-' }}</td>
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
<!-- End::row-1 -->
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#datatable-basic').DataTable({
            pagingType: 'full_numbers',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            autoWidth: false,
            columnDefs: [
                { width: '10px', targets: 1 } // Kolom Aksi (indeks 1)
            ];
            language: {
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Selanjutnya',
                    previous: 'Sebelumnya'
                }
            }
        });
    });
</script>
@endsection