@extends('frontend.layouts.layouts')

@section('content')
    <input type="hidden" value="{{ $formattedData['movie_id'] }}" id="movie_id">
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner"
        data-background="{{ asset('storage/app/public/' . $formattedData['banner_image']) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
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

    <!-- ==========Page-Title========== -->
    <section class="page-title bg-one">
        <div class="container">
            <div class="page-title-area">
                <div class="item md-order-1">
                    <a href="{{ route('movies.ticket-plan', ['id' => $formattedData['movie_id']]) }}"
                        class="custom-button back-button">
                        <i class="flaticon-double-right-arrows-angles"></i>back
                    </a>
                </div>
                <div class="item date-item">
                    <span class="date">
                        {{ \Carbon\Carbon::parse($formattedData['show_date'])->format('D, M d Y') }}
                    </span>
                    <span class="timming-show">
                        {{ \Carbon\Carbon::parse($formattedData['start_time'])->format('h:i A') }}
                    </span>
                </div>
                <div class="item">
                    <h5 class="time-remain">05:00</h5>
                    <p>Mins Left</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page-Title========== -->

    <!-- ==========Movie-Section========== -->
    <div class="seat-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="screen-area">
                <h4 class="screen">screen</h4>
                <div class="screen-thumb">
                    <img src="{{ asset('Frontend/images/movie/screen-thumb.png') }}" alt="ticket">
                </div>

                @foreach ($formattedData['seats'] as $category => $seats)
                    <h5 class="subtitle">{{ ucfirst($category) }} plus</h5>
                    <div class="screen-wrapper">
                        <ul class="seat-area">
                            @if ($seats->count() > 2)
                                @foreach ($seats->chunk(14) as $seatChunk)
                                    <li class="seat-line">
                                        <ul class="seat--area">
                                            @foreach ($seatChunk as $seat)
                                                <li class="front-seat">
                                                    <ul>
                                                        <li class="single-seat @if ($seat->is_booked) seat-booked @else seat-free @endif"
                                                            @if (!$seat->is_booked) data-seat-id="{{ $seat->id }}"data-seat-number="{{ $seat->seat_number }}"data-seat-price="{{ $seat->price_per_seat }}" @endif>
                                                            <img src="{{ asset($seat->is_booked ? 'Frontend/images/movie/seat01-booked.png' : 'Frontend/images/movie/seat01-free.png') }}"
                                                                alt="seat">
                                                            <span class="sit-num">{{ $seat->seat_number }}</span>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="proceed-book bg_img" data-background="assets/images/movie/movie-bg-proceed.jpg">
                <div class="proceed-to-book">
                    <div class="book-item">
                        <span>You have Choosed Seat</span>
                        <h3 class="title" id="selected-seats">No seats selected</h3>
                    </div>
                    <div class="book-item">
                        <span>total price</span>
                        <h3 class="title" id="total-price">$0</h3>
                    </div>
                    <div class="book-item">
                        <form id="seat-booking-form" action="{{ route('movies.check-out') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_seats" id="selected-seats-input">
                            <input type="hidden" name="total_price" id="total-price-input">
                            <input type="hidden" name="movie_id" value="{{ $formattedData['movie_id'] }}">
                            <input type="hidden" name="movie_title" value="{{ $formattedData['movie'] }}">
                            <input type="hidden" name="show_date" value="{{ $formattedData['show_date'] }}">
                            <input type="hidden" name="start_time" value="{{ $formattedData['start_time'] }}">
                            <input type="hidden" name="cinema_name" value="{{ $formattedData['cinema_name'] }}">
                            <input type="hidden" name="banner_image" value="{{ $formattedData['banner_image'] }}">
                            <input type="hidden" name="assign_movies_details_id"
                                value="{{ $formattedData['assign_movies_details_id'] }}">

                            <button type="submit" class="custom-button">proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
@endsection

@push('styles')
    <style>
        .timming-show {
            border-radius: 5px;
            padding-top: 5px;
            padding-bottom: 32px;
            padding-left: 15px;
            padding-right: 15px;
            background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);
            -webkit-box-shadow: 0px 10px 15px 0px rgba(59, 55, 188, 0.5);
            box-shadow: 0px 10px 15px 0px rgba(59, 55, 188, 0.5);
            border: none;
            height: 36px;
        }

        .seat-free.selected img {
            content: url("{{ asset('Frontend/images/movie/seat01-booked.png') }}");
        }

        .seat-booked {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .seat-booked img {
            content: url("{{ asset('Frontend/images/movie/seat01.png') }}") !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedSeats = [];
            let totalPrice = 0;

            // Function to update the selected seats and total price
            function updateSelectedSeats() {
                const selectedSeatsElement = document.getElementById('selected-seats');
                const totalPriceElement = document.getElementById('total-price');
                const selectedSeatsInput = document.getElementById('selected-seats-input');
                const totalPriceInput = document.getElementById('total-price-input');

                // Wrap selected seats into multiple lines if they exceed a certain length
                const maxSeatsPerLine = 5; // Adjust this value as needed
                let formattedSeats = '';
                selectedSeats.forEach((seat, index) => {
                    if (index > 0 && index % maxSeatsPerLine === 0) {
                        formattedSeats += '<br>'; // Add a line break after every `maxSeatsPerLine` seats
                    }
                    formattedSeats += seat.seatNumber + ', ';
                });

                // Remove the trailing comma and space
                formattedSeats = formattedSeats.replace(/,\s*$/, '');

                selectedSeatsElement.innerHTML = formattedSeats || 'No seats selected';
                totalPriceElement.textContent = `${totalPrice}.Rs`;
                selectedSeatsInput.value = selectedSeats.map(seat => seat.id).join(',');
                totalPriceInput.value = totalPrice;
            }

            // Add event listeners to each seat
            document.querySelectorAll('.single-seat.seat-free').forEach(seat => {
                seat.addEventListener('click', function() {
                    const seatId = this.getAttribute('data-seat-id');
                    const seatNumber = this.getAttribute('data-seat-number');
                    const seatPrice = parseFloat(this.getAttribute('data-seat-price'));

                    if (this.classList.contains('selected')) {
                        // Deselect the seat
                        this.classList.remove('selected');
                        selectedSeats = selectedSeats.filter(seat => seat.id !== seatId);
                        totalPrice -= seatPrice;
                    } else {
                        // Select the seat
                        this.classList.add('selected');
                        selectedSeats.push({
                            id: seatId,
                            seatNumber: seatNumber,
                            price: seatPrice
                        });
                        totalPrice += seatPrice;
                    }

                    updateSelectedSeats();
                });
            });

            let timeLeft = 300; // 5 minutes in seconds
            let timerDisplay = document.querySelector(".time-remain");

            function updateTimer() {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                timerDisplay.textContent = `${minutes}:${seconds}`;
                let movieId = document.getElementById("movie_id").value;
                let url = "{{ route('movies.details', ':movie_id') }}".replace(':movie_id', movieId);

                if (timeLeft > 0) {
                    timeLeft--;
                    setTimeout(updateTimer, 1000);
                } else {
                    window.location.href = url;
                }
            }
            updateTimer();
        });
    </script>
@endpush
