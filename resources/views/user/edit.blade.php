@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Data Supir
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/user/update/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')                       
                            <div class="row">                                
                                {{-- Nama Supir --}}
                                <div class="col-md-6 mb-2">
                                    <label for="name" class="form-label">Nama <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nama Username --}}
                                <div class="col-md-6 mb-2">
                                    <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role_id" class="form-label">Role</label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Owner</option>
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="is_active" class="form-label">Status User</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is_active" required>
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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