@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('frontend/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title  cd-headline clip"><span class="d-block">book your</span> tickets for
                    <span class="color-theme cd-words-wrapper p-0 m-0">
                        <b class="is-visible">Movie</b>
                        <b>Event</b>
                        <b>Sport</b>
                    </span>
                </h1>
                <p>Safe, secure, reliable ticketing.Your ticket to live entertainment!</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Ticket-Search========== -->
    <section class="search-ticket-section padding-top pt-lg-0">
        <div class="container">
            <div class="search-tab bg_img" data-background="{{ asset('frontend/images/ticket/ticket-bg01.jpg') }}">
                <div class="row align-items-center mb--20">
                    <div class="col-lg-6 mb-20">
                        <div class="search-ticket-header">
                            <h6 class="category">welcome to Movie Booking </h6>
                            <h3 class="title">what are you looking for</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-20">
                        <ul class="tab-menu ticket-tab-menu">
                            <li class="active">
                                <div class="tab-thumb">
                                    <img src="{{ asset('Frontend/images/ticket/ticket-tab01.png') }}" alt="ticket">
                                </div>
                                <span>movie</span>
                            </li>
                            <li>
                                <div class="tab-thumb">
                                    <img src="{{ asset('Frontend/images/ticket/ticket-tab02.png') }}" alt="ticket">
                                </div>
                                <span>events</span>
                            </li>
                            <li>
                                <div class="tab-thumb">
                                    <img src="{{ asset('Frontend/images/ticket/ticket-tab03.png') }}" alt="ticket">
                                </div>
                                <span>sports</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-area">
                    <div class="tab-item active">
                        <form class="ticket-search-form" id="movieFilterForm">
                            <div class="form-group large">
                                <input type="text" name="search" placeholder="Search for Movies">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/city.png') }}" alt="ticket">
                                </div>
                                <span class="type">city</span>
                                <select class="select-bar" name="city">
                                    <option value="">All Cities</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ request('city') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/date.png') }}" alt="ticket">
                                </div>
                                <span class="type">date</span>
                                <select class="select-bar" name="date">
                                    <option value="">All Dates</option>
                                    @foreach ($availableDates as $date)
                                        <option value="{{ $date }}"
                                            {{ request('date') == $date ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/cinema.png') }}" alt="ticket">
                                </div>
                                <span class="type">cinema</span>
                                <select class="select-bar" name="cinema">
                                    <option value="">All Cinemas</option>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->id }}"
                                            {{ request('cinema') == $cinema->id ? 'selected' : '' }}>
                                            {{ $cinema->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- Other tab items... -->
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Ticket-Search========== -->

    <!-- ==========Movie-Main-Section========== -->
    <section class="movie-section padding-top padding-bottom bg-two">
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
                <div class="col-lg-3 col-sm-10  mt-50 mt-lg-0">
                    <div class="widget-1 widget-facility">
                        <div class="widget-1-body">
                            <ul>
                                <li>
                                    <a href="">
                                        <span class="img"><img
                                                src="{{ asset('Frontend/images/sidebar/icons/sidebar01.png') }}"
                                                alt="sidebar"></span>
                                        <span class="cate">24X7 Care</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="img"><img
                                                src="{{ asset('Frontend/images/sidebar/icons/sidebar02.png') }}"
                                                alt="sidebar"></span>
                                        <span class="cate">100% Assurance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="img"><img
                                                src="{{ asset('Frontend/images/sidebar/icons/sidebar03.png') }}"
                                                alt="sidebar"></span>
                                        <span class="cate">Our Promise</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="">
                                <img src="{{ asset('Frontend/images/sidebar/banner/banner01.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                    <div class="widget-1 widget-trending-search">
                        <h3 class="title">Trending Searches</h3>
                        <div class="widget-1-body">
                            <ul>
                                <li>
                                    <h6 class="sub-title">
                                        <a href="">mars</a>
                                    </h6>
                                    <p>Movies</p>
                                </li>
                                <li>
                                    <h6 class="sub-title">
                                        <a href="">alone</a>
                                    </h6>
                                    <p>Movies</p>
                                </li>
                                <li>
                                    <h6 class="sub-title">
                                        <a href="">music event</a>
                                    </h6>
                                    <p>event</p>
                                </li>
                                <li>
                                    <h6 class="sub-title">
                                        <a href="">NBA Games 2020</a>
                                    </h6>
                                    <p>Sports</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="">
                                <img src="{{ asset('Frontend/images/sidebar/banner/banner02.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="article-section padding-bottom">
                        <div class="section-header-1">
                            <h2 class="title">movies</h2>
                            <a class="view-all" href="{{ route('movies.grid') }}">View All</a>
                        </div>
                        @include('frontend.dashboard.partials._movies', ['movies' => $movies])
                    </div>
                    <div class="article-section padding-bottom">
                        <div class="section-header-1">
                            <h2 class="title">events</h2>
                            <a class="view-all" href="">View All</a>
                        </div>
                        <div class="row mb-30-none justify-content-center">
                            <div class="col-sm-6 col-lg-4">
                                <div class="event-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="">
                                            <img src="{{ asset('Frontend/images/event/event01.jpg') }}" alt="event">
                                        </a>
                                        <div class="event-date">
                                            <h6 class="date-title">28</h6>
                                            <span>Dec</span>
                                        </div>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a href="">Digital Economy Conference 2020</a>
                                        </h5>
                                        <div class="movie-rating-percent">
                                            <span>327 Montague Street</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="event-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="">
                                            <img src="{{ asset('Frontend/images/event/event02.jpg') }}" alt="event">
                                        </a>
                                        <div class="event-date">
                                            <h6 class="date-title">28</h6>
                                            <span>Dec</span>
                                        </div>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a href="">web design conference 2020</a>
                                        </h5>
                                        <div class="movie-rating-percent">
                                            <span>327 Montague Street</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="event-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="">
                                            <img src="{{ asset('Frontend/images/event/event03.jpg') }}" alt="event">
                                        </a>
                                        <div class="event-date">
                                            <h6 class="date-title">28</h6>
                                            <span>Dec</span>
                                        </div>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a href="">digital thinkers meetup</a>
                                        </h5>
                                        <div class="movie-rating-percent">
                                            <span>327 Montague Street</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ==========Movie-Main-Section========== -->
    <style>
        .c-thumb img {
            width: 100%;
            height: 300px;
        }
    </style>
@endsection
@push('scipts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.movie-grid', function(e) {


                let selectedMovie = $(this).data('id');

                if (selectedMovie) {
                    // Redirect to the movie details page with the selected movie ID
                    window.location.href = "{{ route('movies.details', ':id') }}".replace(':id',
                        selectedMovie);
                }
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var delayTimer;

            // Handle form changes
            $('#movieFilterForm').on('change keyup', 'select, input[name="search"]', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(submitFilterForm, 500);
            });

            function submitFilterForm() {
                var formData = $('#movieFilterForm').serialize();

                $.ajax({
                    url: '{{ route('movies.filter') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // Update movies list
                        $('.movie-section .row.mb-30-none').html(response.moviesHtml);

                        // Update date options
                        var dateSelect = $('select[name="date"]');
                        dateSelect.empty().append('<option value="">All Dates</option>');

                        response.availableDates.forEach(function(dateStr) {
                            var date = new Date(dateStr);
                            var formattedDate = ('0' + date.getDate()).slice(-2) + '/' +
                                ('0' + (date.getMonth() + 1)).slice(-2) + '/' +
                                date.getFullYear();

                            dateSelect.append($('<option>', {
                                value: dateStr,
                                text: formattedDate,
                                selected: dateStr === "{{ request('date') }}"
                            }));
                        });
                    },
                    error: function(xhr) {
                        console.error('Filter error:', xhr.responseText);
                    }
                });
            }
        });
    </script>
@endpush
