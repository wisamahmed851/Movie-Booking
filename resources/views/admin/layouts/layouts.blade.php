<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Favicon -->
    <link href="{{ asset('Backend/img/favicon.ico') }}" rel="icon">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('Backend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('Backend/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('Backend/css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>


<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{ route('dashboard.index') }}" class="navbar-brand mx-2 mb-3">
                    <h3 class="text-primary">{{-- <i class="fa fa-user-edit me-2"></i> --}}MovieBooking</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('Backend/img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Jhon Doe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-item nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    {{-- user --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('users.index') || Request::routeIs('users.create') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>User
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('users.index') }}"
                                class="dropdown-item {{ Request::routeIs('users.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('users.create') }}"
                                class="dropdown-item {{ Request::routeIs('users.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Movies --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('movies.index') || Request::routeIs('movies.create') || Request::routeIs('movies.edit') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Movies
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('movies.index') }}"
                                class="dropdown-item {{ Request::routeIs('movies.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('movies.create') }}"
                                class="dropdown-item {{ Request::routeIs('movies.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Cinemas --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('cinemas.index') || Request::routeIs('cinemas.create') || Request::routeIs('cinemas.edit') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Cinemas
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('cinemas.index') }}"
                                class="dropdown-item {{ Request::routeIs('cinemas.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('cinemas.create') }}"
                                class="dropdown-item {{ Request::routeIs('cinemas.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Blogs --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('blogs.index') }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Blogs
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('blogs.index') }}"
                                class="dropdown-item {{ Request::routeIs('blogs.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('comments.index') }}"
                                class="dropdown-item {{ Request::routeIs('comments.index') ? 'active' : '' }}"
                                style="padding-left: 75px">Blogs Coments</a>
                            <a href="{{ route('blogs.create') }}"
                                class="dropdown-item {{ Request::routeIs('blogs.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Languages --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('languages.index') || Request::routeIs('languages.create') || Request::routeIs('languages.edit') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Languages
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('languages.index') }}"
                                class="dropdown-item {{ Request::routeIs('languages.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('languages.create') }}"
                                class="dropdown-item {{ Request::routeIs('languages.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Genres --}}
                    <div class="nav-item dropdown ">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ Request::routeIs('genres.index') || Request::routeIs('genres.create') || Request::routeIs('genres.edit') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Genres
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('genres.index') }}"
                                class="dropdown-item {{ Request::routeIs('genres.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('genres.create') }}"
                                class="dropdown-item {{ Request::routeIs('genres.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                    {{-- Cities --}}
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle  {{ Request::routeIs('city.index') || Request::routeIs('city.create') || Request::routeIs('city.edit') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-2"></i>Cities
                        </a>
                        <div class="dropdown-menu bg-transparent border-0"
                            style="padding-top: 0px; padding-bottom: 0px; padding-left: 0px; margin-left: 0px;">
                            <a href="{{ route('city.index') }}"
                                class="dropdown-item {{ Request::routeIs('city.index') ? 'active' : '' }}"
                                style="padding-left: 75px">List</a>
                            <a href="{{ route('city.create') }}"
                                class="dropdown-item {{ Request::routeIs('city.create') ? 'active' : '' }}"
                                style="padding-left: 75px">Create</a>
                        </div>
                    </div>
                </div>


            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ asset('Backend/img/user.jpg') }}"
                                alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            @yield('content')



            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('Backend/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('Backend/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Backend/js/main.js') }}"></script>
    @stack('scripts')
    <script>
        // Define a reusable AJAX submission function
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

        function handleEditFormSubmission(formSelector, config) {
            $(document).on('submit', formSelector, function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = config.useFormData ? new FormData(this) : form.serialize();
                let ajaxOptions = {
                    url: config.url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 4000
                            }).showToast();

                            if (config.redirectUrl) {
                                window.location.href = config.redirectUrl;
                            }
                        } else if (response.status === 'error') {
                            let errorMessages = Object.values(response.message).flat().join('\n');
                            Toastify({
                                text: errorMessages.trim(),
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    },
                    error: function(xhr) {
                        let errorMessages = Object.values(xhr.responseJSON.errors || {}).flat().join('\n');
                        Toastify({
                            text: errorMessages.trim(),
                            backgroundColor: "red",
                            duration: 5000
                        }).showToast();
                    }
                };

                if (config.useFormData) {
                    ajaxOptions.processData = false;
                    ajaxOptions.contentType = false;
                }

                // Include CSRF token header for serialized data
                if (!config.useFormData) {
                    ajaxOptions.headers = {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    };
                }

                $.ajax(ajaxOptions);
            });
        }
    </script>
</body>

</html>
