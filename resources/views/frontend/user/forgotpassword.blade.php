<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pixner.net/boleto/demo/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:07:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <title>Boleto - Online Ticket Booking Website HTML Template</title>


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
                        <span class="cate">Reset Your Password</span>
                        <h2 class="title">Forgot Password?</h2>
                    </div>
                    <form class="account-form" id="forgetPassForm" method="POST" href=>
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="email">Enter Your Email<span>*</span></label>
                            <input type="email" name="email" placeholder="Enter Your Email" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Send OTP">
                        </div>
                    </form>
                    <div class="option">
                        Remember your password? <a href="{{ route('user.login') }}">Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========Sign-In-Section========== -->


    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });


            submitAjaxForm('#forgetPassForm', "{{ route('user.send.otp') }}", "{{ route('user.otp.form') }}");

        });
    </script>
</body>




<!-- Mirrored from pixner.net/boleto/demo/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:07:34 GMT -->

</html>
