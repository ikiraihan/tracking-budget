@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Truk
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ url('/truk/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf                         
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="no_polisi" class="form-label">No. Polisi</label>
                                    <input type="text" class="form-control" name="no_polisi" id="no_polisi" required>
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label for="photo" class="form-label">Foto Truk</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                    
                                    <div class="mt-2">
                                        <img id="previewImage" 
                                             src="{{ !empty($truk->path_photo) ? asset($truk->path_photo) : '#' }}" 
                                             alt="Foto Truk" 
                                             class="img-thumbnail" 
                                             width="200"
                                             style="{{ empty($truk->path_photo) ? 'display:none;' : '' }}">
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/truk" class="btn btn-secondary">Kembali</i>
                                </a>
                            </div>
                        </form>
                                             
                    </div>
                </div>
                <div class="card-footer d-none border-top-0"></div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const preview = document.getElementById('previewImage');
    
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        }
    });
</script>
    