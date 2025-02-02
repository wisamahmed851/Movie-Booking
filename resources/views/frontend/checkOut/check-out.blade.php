@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner"
        data-background="{{ asset('storage/' . $checkoutData['movie_image']) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">{{ $checkoutData['movie_title'] }}</h3>
                    <div class="tags">

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
                    <a href="movie-ticket-plan.html" class="custom-button back-button">
                        <i class="flaticon-double-right-arrows-angles"></i>back
                    </a>
                </div>
                <div class="item date-item">
                    <span class="date">
                        {{ \Carbon\Carbon::parse($checkoutData['show_date'])->format('D, M d Y') }}
                    </span>
                    <span class="timming-show">
                        {{ \Carbon\Carbon::parse($checkoutData['start_time'])->format('h:i A') }}
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
    <div class="movie-facility padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">


                    <div class="checkout-widget checkout-card mb-0">
                        {{-- <h5 class="title">Payment Option </h5>
                       <ul class="payment-option">
                            <li class="active">
                                <a href="#0">
                                    <img src="assets/images/payment/card.png" alt="payment">
                                    <span>Credit Card</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <img src="assets/images/payment/card.png" alt="payment">
                                    <span>Debit Card</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <img src="assets/images/payment/paypal.png" alt="payment">
                                    <span>paypal</span>
                                </a>
                            </li>
                        </ul>
                        <h6 class="subtitle">Enter Your Card Details </h6> --}}
                        {{-- <form class="payment-card-form">
                            <div class="form-group w-100">
                                <label for="card1">Card Details</label>
                                <input type="text" id="card1">
                                <div class="right-icon">
                                    <i class="flaticon-lock"></i>
                                </div>
                            </div>
                            <div class="form-group w-100">
                                <label for="card2"> Name on the Card</label>
                                <input type="text" id="card2">
                            </div>
                            <div class="form-group">
                                <label for="card3">Expiration</label>
                                <input type="text" id="card3" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label for="card4">CVV</label>
                                <input type="text" id="card4" placeholder="CVV">
                            </div>
                            <div class="form-group check-group">
                                <input id="card5" type="checkbox" checked>
                                <label for="card5">
                                    <span class="title">QuickPay</span>
                                    <span class="info">Save this card information to my Boleto account and make faster
                                        payments.</span>
                                </label>
                            </div>
                        </form> --}}
                        <form method="POST" action="{{ route('movies.confirm-booking') }}">
                            @csrf
                            <input type="hidden" name="assign_movies_details_id"
                                value="{{ $checkoutData['assign_movies_details_id'] }}">
                            <input type="hidden" name="total_price" value="{{ $checkoutData['total_price'] }}">
                            <input type="hidden" name="selected_seats"
                                value="{{ json_encode($checkoutData['selected_seats']) }}">

                            <div class="checkout-widget checkout-card mb-0">
                                <div class="form-group">
                                    <button type="submit" class="custom-button">Confirm Booking</button>
                                </div>
                                <p class="notice">
                                    By Clicking "Confirm Booking" you agree to the <a href="#0">terms and
                                        conditions</a>
                                </p>
                            </div>
                        </form>
                        {{-- <p class="notice">
                            By Clicking "Make Payment" you agree to the <a href="#0">terms and conditions</a>
                        </p> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="booking-summery bg-one">
                        <h4 class="title">booking summery</h4>
                        <ul>
                            <li>
                                <h6 class="subtitle">{{ $checkoutData['movie_title'] }}</h6>
                            </li>
                            <li>
                                <h6 class="subtitle"><span>{{ $checkoutData['cinema_name'] }}</span><span>02</span></h6>
                                <div class="info">
                                    <span class="date">
                                        {{ \Carbon\Carbon::parse($checkoutData['show_date'])->format('D, M d Y') }}
                                        {{ \Carbon\Carbon::parse($checkoutData['start_time'])->format('h:i A') }}
                                    </span>
                                </div>
                            </li>

                        </ul>
                        <ul class="side-shape">
                            <li>
                                <h6 class="subtitle">Selected Seats</h6>
                                @foreach ($checkoutData['selected_seats'] as $seat)
                            <li>
                                <span class="info"><span>{{ $seat['seat_number'] }}</span>
                                    <span>{{ $seat['price_per_seat'] }} Rs</span></span>
                            </li>
                            @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="proceed-area  text-center">
                        <h6 class="subtitle"><span>Tottal Amount</span><span>{{ $checkoutData['total_price'] }} Rs</span>
                        </h6>
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
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
