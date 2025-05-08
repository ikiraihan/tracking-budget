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
                                            <h6 class="fw-medium mb-4 fs-17">Silahkan login untuk melanjutkan.</h6>
                                            <!-- Laravel Login Form -->
                                            <div id="login-form-wrapper">
                                                <!-- Form Login Biasa -->
                                                <form id="login-form" action="/login" method="POST">
                                                    @csrf

                                                    <!-- Email Input -->
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input class="form-control @error('username') is-invalid @enderror"
                                                            placeholder="Masukkan username" type="text" name="username" required>
                                                        @error('username')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Password Input -->
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Password</label>
                                                        <input class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Masukkan password" type="password" name="password" required>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-primary btn-block w-100">Sign In</button>
                                                </form>

                                            </div>

                                            <!-- Footer Links -->
                                            {{-- <div class="main-signin-footer mt-5">
                                                <p>Belum memiliki akun ? 
                                                    <a href="/register">Registrasi</a>
                                                </p>
                                            </div> --}}
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
                    showConfirmButton: true,
                    //timer: 3000
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
    </script>
    
</body>

</html>