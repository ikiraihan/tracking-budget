<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/Teba_Express.png') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('Tema/dist/assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('Tema/dist/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('Tema/dist/assets/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('Tema/dist/assets/css/icons.min.css') }}" rel="stylesheet">
</head>

<body>
    @if (session('success'))
        <div id="msg-success" data-msg_success="{{ session('success') }}"></div>
    @endif

    @if (session('error'))
        <div id="msg-error" data-msg_error="{{ session('error') }}"></div>
    @endif
    <div class="container-fluid custom-page">
        <div class="row bg-white">
            <!-- The image half -->
            <div class="col-md-5 col-lg-5 col-xl-5 d-none d-md-flex bg-primary-transparent-3">
                <div class="row w-100 mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto w-100">
                        {{-- <img src="{{ asset('images/Teba_Express.png') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo"> --}}
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-7 col-lg-7 col-xl-7 bg-white py-4">
                <div class="login d-flex align-items-center py-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5">
                                        <a href="/" class="header-logo">
                                            <img src="{{ asset('images/Teba_Express.png') }}"
                                                class="desktop-logo ht-40" alt="logo">
                                            <img src="{{ asset('images/Teba_Express.png') }}"
                                                class="desktop-white ht-40" alt="logo">
                                        </a>
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h3>Tracking</h3>
                                            <h6 class="fw-medium mb-4 fs-17">Silahkan lakukan Registrasi Akun.</h6>
                                            <!-- Laravel Login Form -->
                                            <div id="login-form-wrapper">
                                                <!-- Form Login Biasa -->
                                                <form id="register-form" action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf        
                                                    <div class="row">                                       
                                                        <!-- Name Input -->
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                                                            <input class="form-control @error('name') is-invalid @enderror"
                                                                placeholder="Masukkan nama lengkap" type="text" name="name" value="{{ old('name') }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    
                                                        <!-- Username Input -->
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Username <span style="color: red;">*</span></label>
                                                            <input class="form-control @error('username') is-invalid @enderror"
                                                                placeholder="Masukkan username" type="text" name="username" value="{{ old('username') }}" required>
                                                            @error('username')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Foto Diri --}}
                                                        <div class="col-md-12 mb-2">
                                                            <label for="photo_diri" class="form-label">Foto Diri <span style="color: red;">*</span></label>
                                                            <input type="file" class="form-control" id="photo_diri" name="photo_diri" accept="image/*" required>                                    
                                                            <div class="mt-2">
                                                                <img id="preview-photo_diri" 
                                                                    src="#" 
                                                                    alt="Preview Foto Diri" 
                                                                    class="img-thumbnail" 
                                                                    width="150"
                                                                    style="display: none;">
                                                            </div>
                                                        </div>
                                                
                                                        {{-- Telepon --}}
                                                        <div class="col-md-6 mb-2">
                                                            <label for="telepon" class="form-label">Telepon <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                                                        </div>
                                                
                                                        {{-- Alamat --}}
                                                        <div class="col-md-6 mb-2">
                                                            <label for="alamat" class="form-label">Alamat <span style="color: red;">*</span></label>
                                                            <textarea class="form-control" id="alamat" name="alamat" rows="1" required></textarea>
                                                        </div>
                                                
                                                        {{-- <div class="col-md-6 mb-2">
                                                            <label for="no_ktp" class="form-label">No. KTP</label>
                                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp">
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <label for="photo_ktp" class="form-label">Foto KTP</label>
                                                            <input type="file" class="form-control" id="photo_ktp" name="photo_ktp" accept="image/*">                                    
                                                            <div class="mt-2">
                                                                <img id="preview-photo_ktp" 
                                                                    src="#" 
                                                                    alt="Preview Foto KTP" 
                                                                    class="img-thumbnail" 
                                                                    width="150"
                                                                    style="display: none;">
                                                            </div>
                                                        </div>
                                                
                                                        <div class="col-md-6 mb-2">
                                                            <label for="no_sim" class="form-label">No. SIM</label>
                                                            <input type="text" class="form-control" id="no_sim" name="no_sim">
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <label for="photo_sim" class="form-label">Foto SIM</label>
                                                            <input type="file" class="form-control" id="photo_sim" name="photo_sim" accept="image/*">
                                                            <div class="mt-2">
                                                                <img id="preview-photo_sim" 
                                                                    src="#" 
                                                                    alt="Preview Foto SIM" 
                                                                    class="img-thumbnail" 
                                                                    width="150"
                                                                    style="display: none;">
                                                            </div>
                                                        </div> --}}
                                                
                                                        {{-- Truk --}}
                                                        {{-- <div class="col-md-12 mb-3">
                                                            <label for="truk_id" class="form-label">Truk</label>
                                                            <select class="form-control" name="truk_id" id="truk_id" required>
                                                                <option value="">-- Pilih Truk --</option>
                                                                @foreach($truks as $truk)
                                                                    <option value="{{ $truk->id }}">{{ $truk->no_polisi }} - {{ $truk->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                    
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
                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-primary btn-block w-100">Daftar Akun</button>
                                                </form>
                                                

                                            </div>

                                            <!-- Footer Links -->
                                            <div class="main-signin-footer mt-5">
                                                {{-- <p>Belum memiliki akun ? 
                                                    <a href="#">Registrasi</a>
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('Tema/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('Tema/dist/assets/js/show-password.js') }}"></script>

    <!-- Sweetalerts JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Tambahkan ini -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>

    <script>
        $(document).ready(function() {

            if ($('#msg-success').data('msg_success') != null) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: $("#msg-success").data('msg_success'),

                    // timer: 3000
                });
            }

            if ($('#msg-error').data('msg_error') != null) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: $('#msg-error').data('msg_error'),
                    showConfirmButton: true,
                });
            }
        })

        document.addEventListener('DOMContentLoaded', function () {
            const fileInputs = ['photo', 'photo_diri', 'photo_ktp', 'photo_sim'];

            fileInputs.forEach(function(inputId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById('preview-' + inputId);

                if (input && preview) {
                    input.addEventListener('change', function(event) {
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
        });

        document.getElementById('photo_diri').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-photo_diri');
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 4 * 1024 * 1024) {
                    alert('File terlalu besar! Maksimum 4MB.');
                    event.target.value = ''; // Clear the input
                    preview.style.display = 'none';
                    return;
                }
                // Check file type
                if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                    alert('Hanya file JPG, JPEG, atau PNG yang diperbolehkan.');
                    event.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
    
</body>

</html>