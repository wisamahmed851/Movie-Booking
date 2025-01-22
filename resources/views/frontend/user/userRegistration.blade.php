<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pixner.net/boleto/demo/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:07:34 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset ('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/main.css') }}">

    <link rel="shortcut icon" href="{{ asset ('frontend/images/favicon.png" type="image/x-icon') }}">

    <title>Boleto  - Online Ticket Booking Website HTML Template</title>


</head>

<body>
    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->

    <!-- ==========Sign-In-Section========== -->
    <section class="account-section bg_img" data-background="assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area">
                    <div class="section-header-3">
                        <span class="cate">welcome</span>
                        <h2 class="title">to Boleto </h2>
                    </div>
                    <form class="account-form" id="registerForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Username<span>*</span></label>
                            <input type="text" name="name" placeholder="Enter Your Username" id="email1" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email<span>*</span></label>
                            <input type="email" name="email" placeholder="Enter Your Email" id="email1" required>
                        </div>
                        <div class="form-group">
                            <label for="pass1">Password<span>*</span></label>
                            <input type="password" name="password" placeholder="Password" id="pass1" required>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Confirm Password<span>*</span></label>
                            <input type="password" placeholder="Password" name="password_confirmation" id="pass2" required>
                        </div>
                        <div class="form-group checkgroup">
                            <input type="checkbox" id="bal" required checked>
                            <label for="bal">I agree to the <a href="#0">Terms, Privacy Policy</a> and <a href="#0">Fees</a></label>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Sign Up">
                        </div>
                    </form>
                    <div class="option">
                        Already have an account? <a href="{{route('user.login')}}">Login</a>
                    </div>
                    <div class="or"><span>Or</span></div>
                    <ul class="social-icons">
                        <li>
                            <a href="#0">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#0" class="active">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#0">
                                <i class="fab fa-google"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Sign-In-Section========== -->


    <script src="{{ asset ('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset ('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset ('frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset ('frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset ('frontend/js/main.js') }}"></script>
    <script>
         $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('user.register.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Toastify({
                                text: "Registration successful!",
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();
                            window.location.href = "/auth/login";
                        } else if (response.status === 'error') {
                            let errors = response.message;
                            let errorMessages = '';
                            for (let field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessages += errors[field][0] + '\n';
                                }
                            }
                            Toastify({
                                text: errorMessages.trim(),
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    },
                });
            });
        });
    </script>
</body>


<!-- Mirrored from pixner.net/boleto/demo/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:07:34 GMT -->
</html>
