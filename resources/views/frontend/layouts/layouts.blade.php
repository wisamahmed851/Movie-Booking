<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pixner.net/boleto/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:04:01 GMT -->

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
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.animatedheadline.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="icon" href="{{ asset('frontend/css/img/mdb-favicon.ico" type="image/x-icon') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('frontendcss/bootstrap-profiles.min.css') }}" />

    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon') }}">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- jQuery (required for Magnific Popup) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Magnific Popup JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


    <title>Movie Booking</title>
    @stack('styles')

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
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{ route('front.index') }}">
                        <img src="{{ asset('frontend/images/logo/logo.png') }}" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('front.index') }}"
                            class="{{ Request::routeIs('front.index') ? 'active' : '' }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('movies.grid') }}"
                            class="{{ Request::routeIs('movies.grid') ? 'active' : '' }}">Movie Grid</a>
                    </li>
                    <li>
                        <a href="{{ route('pages.about') }}"
                            class="{{ Request::routeIs('pages.about') ? 'active' : '' }}">About Us</a>
                    </li>
                    <li>
                        <a href="{{ route('blogs.list') }}"
                            class="{{ Request::routeIs('blogs.list') ? 'active' : '' }}">Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('pages.contact') }}"
                            class="{{ Request::routeIs('pages.contact') ? 'active' : '' }}">contact</a>
                    </li>
                </ul>
                <a @if (Auth::check()) @if (Request::routeIs('user.profile')) href="{{ route('auth.logout') }} "@else
href="{{ route('user.profile') }} " @endif
                @else href="{{ route('user.login') }} " @endif
                    class="signupRegiste">
                    @if (Auth::check())
                        @if (Request::routeIs('user.profile'))
                            <i class="fas fa-user"></i>
                            <span>Logout</span>
                        @else
                            <i class="fas fa-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                        @endif
                    @else
                        <i class="fas fa-user"></i>
                        <span>Sign in</span>
                    @endif
                </a>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <!-- ==========Header-Section========== -->


    @yield('content')


    <!-- ==========Newslater-Section========== -->
    <footer class="footer-section">
        <div class="newslater-section padding-bottom">
            <div class="container">
                <div class="newslater-container bg_img" data-background="images/newslater/newslater-bg01.jpg">
                    <div class="newslater-wrapper">
                        <h5 class="cate">subscribe to Boleto </h5>
                        <h3 class="title">to get exclusive benifits</h3>
                        <form class="newslater-form">
                            <input type="text" placeholder="Your Email Address">
                            <button type="submit">subscribe</button>
                        </form>
                        <p>We respect your privacy, so we never share your info</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="footer-top">
                <div class="logo">
                    <a href="{{route('front.index')}}">
                        <img src="{{ asset('frontend/images/footer/logo.png') }}" alt="footer">
                    </a>
                </div>
                <ul class="social-icons">
                    <li>
                        <a href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="" class="active">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer-bottom">
                <div class="footer-bottom-area">
                    <div class="left">
                        <p>Copyright © 2020.All Rights Reserved By <a href="">Boleto </a></p>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- ==========Newslater-Section========== -->


    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/heandline.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleAjaxFormSubmit(formId, url, redirectUrl = null) {
            $(document).ready(function() {
                $(formId).on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    let formData;
                    if ($(this).attr('enctype') === 'multipart/form-data') {
                        formData = new FormData(this); // Handle file uploads
                    } else {
                        formData = $(this).serialize(); // Serialize for non-file forms
                    }

                    // Add specific data if necessary (e.g., unchecked checkboxes)
                    if (!$('#isTrending').is(':checked')) {
                        formData instanceof FormData && formData.append('isTrending', 0);
                    }
                    if (!$('#isExclusive').is(':checked')) {
                        formData instanceof FormData && formData.append('isExclusive', 0);
                    }

                    $.ajax({
                        url: url, // Dynamic URL
                        type: 'POST',
                        data: formData,
                        processData: !(formData instanceof FormData), // Required for FormData
                        contentType: !(formData instanceof FormData) ?
                            'application/x-www-form-urlencoded' : false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000
                                }).showToast();
                                if (redirectUrl) {
                                    window.location.href = redirectUrl;
                                }
                            } else if (response.status === 'error') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "red",
                                    duration: 5000
                                }).showToast();
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (const key in errors) {
                                errorMessage += errors[key].join(' ') + '\n';
                            }
                            Toastify({
                                text: errorMessage.trim(),
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    });
                });
            });
        }

        function submitAjaxForm(formSelector, url, redirectUrl = null) {
            $(document).ready(function() {
                $(formSelector).on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        url: url, // Dynamic URL passed as a parameter
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000
                                }).showToast();

                                // Redirect if redirectUrl is provided
                                if (redirectUrl) {
                                    window.location.href = redirectUrl;
                                }
                            } else {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "red",
                                    duration: 3000
                                }).showToast();
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON?.errors; // Check if errors exist
                            var errorMessages = '';

                            if (errors) {
                                for (var field in errors) {
                                    errorMessages += errors[field][0] + '\n';
                                }
                            } else if (xhr.responseJSON?.message) {
                                errorMessages = xhr.responseJSON.message;
                            } else {
                                errorMessages = "An unexpected error occurred.";
                            }

                            console.log(errorMessages); // Log errors for debugging
                            Toastify({
                                text: errorMessages,
                                duration: 5000,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#ff5f6d",
                            }).showToast();
                        }
                    });
                });
            });
        }
    </script>
    @stack('scripts')


</body>


<!-- Mirrored from pixner.net/boleto/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:04:56 GMT -->

</html>
