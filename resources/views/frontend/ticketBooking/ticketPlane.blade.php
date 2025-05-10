@extends('frontend.layouts.layouts')

@section('content')
    <input type="hidden" value="{{ $formattedData['movie_id'] }}" id="movie_id">
    <!-- ==========Window-Warning-Section========== -->
    <section class="window-warning inActive">
        <div class="lay"></div>
        <div class="warning-item">
            <h6 class="subtitle">Welcome! </h6>
            <h4 class="title">Select Your Seats</h4>
            <div class="thumb">
                <img src="{{ asset('Frontend/images/movie/seat-plan.png') }}" alt="ticket">
            </div>
            <!-- Link for seat plans, updated to include dynamic show id -->
            <a class="custom-button seatPlanButton" style="cursor: pointer;f" id="seatPlanLink">Seat Plans<i
                    class="fas fa-angle-right"></i></a>
        </div>
    </section>
    <!-- ==========Window-Warning-Section========== -->

    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img"
        data-background="{{ asset('storage/app/public/' . $formattedData['banner_image']) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content">
                    <h3 class="title">{{ $formattedData['movie'] }}</h3>
                    <div class="tags">
                        @foreach ($formattedData['languages'] as $languagesName => $Languages)
                            <a href="#0">{{ $Languages }}</a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
    <section class="book-section bg-one">
        <div class="container">
            <form class="ticket-search-form two">
                <div class="form-group">
                    <div class="thumb">
                        <img src="{{ asset('Frontend/images/ticket/city.png') }}" alt="ticket">
                    </div>
                    <span class="type">city</span>
                    <select class="select-bar" name="city">
                        <option value="">Select City</option>
                        @foreach ($cities as $citi)
                            <option value="{{ $citi->id }}">{{ $citi->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="thumb">
                        <img src="{{ asset('Frontend/images/ticket/date.png') }}" alt="ticket">
                    </div>
                    <span class="type" name="date">date </span>
                    <select class="select-bar" name="date" id="date-dropdown">
                        <option value="">Select Date</option>
                        @foreach ($availableDates as $availableDate)
                            <option value="{{ $availableDate }}">{{ $availableDate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="thumb">
                        <img src="{{ asset('Frontend/images/ticket/cinema.png') }}" alt="ticket">
                    </div>
                    <span class="type">cinema</span>
                    <select class="select-bar" name="cinema">
                        <option value="">Select Cinema</option>
                        @foreach ($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </section>
    <!-- ==========Book-Section========== -->

    <!-- ==========Movie-Section========== -->
    <div class="ticket-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 mb-5 mb-lg-0">
                    <ul class="seat-plan-wrapper bg-five">
                        @foreach ($formattedData['cinemas'] as $cinemaName => $shows)
                            <li>
                                <div class="movie-name">
                                    <div class="icons">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <a href="#0" class="name">{{ $cinemaName }}</a>
                                    <div class="location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="movie-schedule">
                                    @foreach ($shows as $show)
                                        <div class="item">
                                            <!-- Assign unique ID to each show -->
                                            <input type="hidden" value="{{ $show['assigned_show_id'] }}"
                                                class="assigned_show_id">
                                            {{ \Carbon\Carbon::parse($show['start_time'])->format('H:i') }}
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-10">
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{ asset('Frontend/images/sidebar/banner/banner03.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Attach event listeners on initial page load
            attachEventListeners();

            // Listen to changes on the select dropdowns
            $('.select-bar').on('change', function() {
                let date = $('select[name="date"]').val();
                let cinema = $('select[name="cinema"]').val();
                let city = $('select[name="city"]').val();
                let movie_id = $('#movie_id').val();

                $.ajax({
                    url: "{{ route('movies.ticket-plan', ':movie_id') }}".replace(':movie_id',
                        movie_id),
                    method: "GET",
                    data: {
                        date: date,
                        cinema: cinema,
                        city: city
                    },
                    beforeSend: function() {
                        $('.seat-plan-wrapper').html('<p>Loading...</p>');
                    },
                    success: function(response) {
                        $('.seat-plan-wrapper').html(response);
                        // Re-attach event listeners after AJAX content is loaded
                        attachEventListeners();
                    },
                    error: function() {
                        attachEventListeners();
                        alert('Error fetching data. Please try again.');
                    }
                });
            });
        });

        function attachEventListeners() {
            var selectedShowId = null;

            $(".window-warning .lay").on("click", function() {
                $(".window-warning").addClass("inActive");
            });
            $(".seat-plan-wrapper li .movie-schedule .item").on(
                "click",
                function() {
                    $(".window-warning").removeClass("inActive");
                }
            );
            // Capture the selected show ID when a time is clicked
            $('.movie-schedule .item').on('click', function() {
                selectedShowId = $(this).find('.assigned_show_id').val();

            });

            $('#seatPlanLink').on('click', function(event) {
                if (selectedShowId) {
                    event.preventDefault();
                    // Use Laravel's route() helper to generate the URL dynamically
                    var url = "{{ route('movies.seat-plan', ':show_id') }}".replace(':show_id', selectedShowId);
                    window.location.href = url; // Redirect to the generated URL
                }
            });
        }
    </script>
@endpush
