<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description"
        content="eDak is a streamlined VIP letter management system developed by the National Informatics Centre for the Chief Minister's Office, Government of Assam. It enhances the efficiency of letter tracking and management, ensuring seamless communication and improved governance for VIP communications. Discover how eDak transforms the way letters are handled in Assam.">
    <meta name="keywords"
        content="eDak, VIP letter management system, Chief Minister's Office Assam, Government of Assam, National Informatics Centre, letter tracking, document management, streamlined communication, digital governance, Assam government services, electronic document management, VIP communication system, efficient letter handling">
    <meta name="author" content="National Informatics Centre, Government of Assam">
    <link rel="icon" type="image/png" href="{{ asset('banoshree/images/favicon.png') }}">
    <title>eDAK | Login | Government of Assam </title>
    <link rel="stylesheet" href="{{ asset('banoshree/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('banoshree/node_modules/boxicons/css/boxicons.min.css') }}">
    <link href="{{ asset('banoshree/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body id="login-rim-page">
    <div id="edak-login" class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-9 login-bg d-none d-xl-block">
                <img src="{{ asset('banoshree/images/hcm.svg') }}" alt="eDAK Background Image"
                    class="img-fluid login-img">
                <footer class="position-relative">
                    <div class="row row-cols-1 row-cols-sm-2 g-3">
                        <div class="col text-muted">
                            <p>Managed by <a href="https://cm.assam.gov.in/" target="_blank">Chief Minister's Office
                                    (CMO), Government of Assam</a>
                            </p>
                        </div>
                        <div class="col text-muted d-flex justify-content-start justify-content-sm-end">
                            <p>Designed &amp; Developed by <a href="https://assam.nic.in/" target="_blank">National
                                    Informatics Centre (NIC), Assam</a>
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
            <div
                class="col-sm-12 col-xl-3 ps-0 pe-0 pb-0 edak-login-form d-flex flex-column align-items-center justify-content-between">
                <div>
                    <picture class="d-xxl-none d-xxl-block d-xl-none">
                        <source srcset="{{ asset('banoshree/images/hcm.svg') }}" type="image/svg"
                            class="img-fluid d-block d-sm-block d-md-block d-lg-block d-xl-none login-img-mobile">
                        <img src="{{ asset('banoshree/images/hcm.svg') }}" alt="eDak ackground Image with Photo of HCM"
                            class="img-fluid d-block d-sm-block d-md-block d-lg-block d-xl-none login-img-mobile">
                    </picture>
                    <div>
                        <h2 class="mt-5 text-center d-none d-xl-block">
                            <i class='bx bxs-lock-open'></i> Official Login
                        </h2>
                        <hr>
                        <p class="mt-4 text-center">Login with Parichay Single Sign On</p>
                        <p class="text-center mt-4">
                            <a href="https://parichay.nic.in/pnv1/assets/login?sid=neuEjS53A8EzHjKLSBuRvLxE3HMA0vLu"
                                target="_blank">
                                <img src="{{ asset('banoshree/images/parichay-white.png') }}"
                                    alt="Login with eParichay Link" class="parichay-login pulse">
                            </a>
                        </p>
                        <h4 class="mt-4 text-center">OR</h4>
                        <p class="mt-4 mb-4 text-center">Login with your Email and Password</p>
                        <form class="px-xl-0 px-5" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="username" class="form-label">Registered Email</label>
                                <input type="email" class="form-control" placeholder="Email"
                                    @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Password"
                                    @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label for="remember" class="form-label">Remember Me</label>
                            </div>
                            <button type="submit"
                                class="btn mb-3 d-grid gap-2 col-12 mx-auto btn-lg text-capitalize">LOGIN </button>
                            <div class="row">
                                <div class="col-12 forgotpass">
                                    <p>Forgot Password? <a href="#">RESET NOW</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <footer
                        class="mt-30 d-block d-sm-block d-md-block d-lg-block d-xl-none mobile-footer position-relative">
                        <div class="row row-cols-1 row-cols-sm-2 g-3">
                            <div class="col">
                                <p>Designed &amp; Developed by <a href="https://assam.nic.in/" target="_blank">NIC,
                                        Assam</a>
                                </p>
                            </div>
                            <div class="col d-flex justify-content-start justify-content-sm-end">
                                <p>Managed by <a href="https://cm.assam.gov.in/" target="_blank">CMO, Government of
                                        Assam</a>
                                </p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('banoshree/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
