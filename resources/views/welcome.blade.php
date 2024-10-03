<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VIP Letter Management System | Government of Assam</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content=""
        name="VIP Letter Management System, Assam Secretariat, Assam Janata Bhawan,  Assam Janata Bhavan, Government of Assam, National Informatics Centre, NIC Assam">
    <meta content=""
        name="Streamline your correspondence with the VIP Letter Management System by the Government of Assam Secretariat. Efficiently manage and track official letters, ensuring prompt and organized communication for all VIP-related matters. Enhance productivity and transparency with our user-friendly platform. The software is designed and developed by National Informatics Centre, Assam. ">
    <link href="{{ asset('banoshree/images/favicon.png') }}" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@200;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('banoshree/node_modules/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('banoshree/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('banoshree/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-primary hero-header mb-1">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <img class="img-fluid" src="{{ asset('banoshree/images/bg.png') }}" alt="">
            </div>
            <div class="col-lg-9 text-center text-lg-start">
                <div class="row">
                    <div class=" offset-lg-3 col-lg-6">
                        <h3 class="fw-light text-white animated slideInRight">Government of Assam</h3>
                        <h1 class="display-4 text-white animated slideInRight">VIP <span
                                class="fw-light text-dark">Letter<sup><img
                                        src="{{ asset('banoshree/images/letter_sent.png') }}"
                                        alt="VIP Letter Management System" height="40"></sup></span> Management
                            System</h1>
                        <p class="text-white mb-4 animated slideInRight">Streamlining Correspondance in the Assam
                            Secretariat</p>
                        <a href="{{ route('login') }}" class="btn btn-dark py-2 px-4 me-3 animated slideInRight"><i
                                class="bi bi-lock"></i> Login with Parichay <i class="bi bi-arrow-right"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white footer">
        <div class="container wow fadeIn" data-wow-delay="0.1s">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">

                        Designed & Developed by <a class="border-bottom" href="https://assam.nic.in">National
                            Informatics Centre, Assam</a> </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            &copy; <a class="border-bottom" href="#">2024. CM Secretariat, Government of
                                Assam</a>. All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- JS -->
    <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('node_modules/wow/wow.min.js') }}"></script>
    <script src="{{ asset('node_modules/easing/easing.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>