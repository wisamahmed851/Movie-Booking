<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pixner.net/boleto/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:04:01 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset ('Frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/jquery.animatedheadline.css') }}">
    <link rel="stylesheet" href="{{ asset ('Frontend/css/main.css') }}">

    <link rel="shortcut icon" href="{{ asset ('Frontend/images/favicon.png') }}" type="image/x-icon') }}">

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
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#0" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.html">
                        <img src="{{ asset ('Frontend/images/logo/logo.png') }}" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="{{route('front.index')}}" class="active">Home</a>
                    </li>
                    <li>
                        <a href="#0">movies</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('movies.grid')}}">Movie Grid</a>
                            </li>
                            <li>
                                <a href="{{route('movies.details')}}">Movie Details</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">events</a>
                        <ul class="submenu">
                            <li>
                                <a href="events.html">Events</a>
                            </li>
                            <li>
                                <a href="event-details.html">Event Details</a>
                            </li>
                            <li>
                                <a href="event-speaker.html">Event Speaker</a>
                            </li>
                            <li>
                                <a href="event-ticket.html">Event Ticket</a>
                            </li>
                            <li>
                                <a href="event-checkout.html">Event Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">sports</a>
                        <ul class="submenu">
                            <li>
                                <a href="sports.html">Sports</a>
                            </li>
                            <li>
                                <a href="sport-details.html">Sport Details</a>
                            </li>
                            <li>
                                <a href="sports-ticket.html">Sport Ticket</a>
                            </li>
                            <li>
                                <a href="sports-checkout.html">Sport Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">pages</a>
                        <ul class="submenu">
                            <li>
                                <a href="about.html">About Us</a>
                            </li>
                            <li>
                                <a href="apps-download.html">Apps Download</a>
                            </li>
                            <li>
                                <a href="sign-in.html">Sign In</a>
                            </li>
                            <li>
                                <a href="sign-up.html">Sign Up</a>
                            </li>
                            <li>
                                <a href="404.html">404</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">blog</a>
                        <ul class="submenu">
                            <li>
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="blog-details.html">Blog Single</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="contact.html">contact</a>
                    </li>
                    <li class="header-button pr-0">
                        <a href="sign-up.html">join us</a>
                    </li>
                </ul>
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
                    <a href="index-1.html">
                        <img src="{{ asset ('Frontend/images/footer/footer-logo.png') }}" alt="footer">
                    </a>
                </div>
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
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#0">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#0">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer-bottom">
                <div class="footer-bottom-area">
                    <div class="left">
                        <p>Copyright © 2020.All Rights Reserved By <a href="#0">Boleto </a></p>
                    </div>
                    <ul class="links">
                        <li>
                            <a href="#0">About</a>
                        </li>
                        <li>
                            <a href="#0">Terms Of Use</a>
                        </li>
                        <li>
                            <a href="#0">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#0">FAQ</a>
                        </li>
                        <li>
                            <a href="#0">Feedback</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- ==========Newslater-Section========== -->


    <script src="{{ asset ('Frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/plugins.js') }}"></script>
    <script src="{{ asset ('Frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/heandline.js') }}"></script>
    <script src="{{ asset ('Frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset ('Frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset ('Frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset ('Frontend/js/main.js') }}"></script>
</body>


<!-- Mirrored from pixner.net/boleto/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Jan 2025 20:04:56 GMT -->

</html>
