@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Ubah Password Supir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/user/password/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')                       
                            <div class="row">
                                <!-- Password Input -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Password <span style="color: red;">*</span></label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password" type="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                                
                                <!-- Confirm Password Input -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Konfirmasi Password <span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Ulangi password" type="password" name="password_confirmation" required>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="/user" class="btn btn-secondary">Kembali</a>
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
    