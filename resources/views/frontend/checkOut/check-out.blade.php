@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner"
        data-background="{{ asset('storage/' . $checkoutData['movie_image']) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">{{ $checkoutData['movie_title'] }}</h3>
                    <div class="tags"></div>
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
                    <a href="{{ route('movies.seat-plan', ['id' => $checkoutData['assign_movies_details_id']])}}" class="custom-button back-button">
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
                    <h5 class="time-remain"></h5>
                    <p></p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page-Title========== -->

    <!-- ==========Movie-Section========== -->
<div class="movie-facility padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="booking-summery bg-one">
                    <h4 class="title">Booking Summary</h4>
                    <ul>
                        <li>
                            <h6 class="subtitle">{{ $checkoutData['movie_title'] }}</h6>
                        </li>
                        <li>
                            <h6 class="subtitle">
                                <span>{{ $checkoutData['cinema_name'] }}</span>
                                <span>02</span>
                            </h6>
                            <div class="info">
                                <span class="date">
                                    {{ \Carbon\Carbon::parse($checkoutData['show_date'])->format('D, M d Y') }}
                                    {{ \Carbon\Carbon::parse($checkoutData['start_time'])->format('h:i A') }}
                                </span>
                            </div>
                        </li>
                    </ul>
                    <ul class="side-shape">
                        @foreach ($checkoutData['grouped_seats'] as $category => $seats)
                            <li>
                                <h6 class="subtitle">{{ $category }}</h6>
                                @foreach ($seats as $seat)
                                    <div class="info">
                                        <span>{{ $seat->seat_number }}</span>
                                        <span>{{ round($seat->price_per_seat) }} Rs</span>
                                    </div>
                                @endforeach
                            </li>
                        @endforeach
                    </ul>
                    <div class="proceed-area text-center">
                        <h6 class="subtitle">
                            <span>Total Amount</span>
                            <span>{{ $checkoutData['total_price'] }} Rs</span>
                        </h6>
                    </div>

                    @if (request('booking') === 'success' && session('last_booking_id'))
                        <div class="booking-confirmed">
                            <button class="custom-button" disabled>Booking Confirmed</button>
                            <div class="pdf-buttons mt-3">
                                <a href="{{ route('movies.ticket.view', ['id' => session('last_booking_id')]) }}"
                                    class="custom-button" target="_blank">View PDF</a>
                                <a href="{{ route('movies.ticket.download', ['id' => session('last_booking_id')]) }}"
                                    class="custom-button">Download PDF</a>
                            </div>
                        </div>
                    @else
                        <form id="payment-form">
                            @csrf
                            <div class="form-group">
                                <button type="button" id="pay-button" class="custom-button">Proceed to Payment</button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('movies.confirm-booking') }}" id="booking-form">
                            @csrf
                            <input type="hidden" name="assign_movies_details_id"
                                value="{{ $checkoutData['assign_movies_details_id'] }}">
                            <input type="hidden" name="total_price" value="{{ $checkoutData['total_price'] }}">
                            <input type="hidden" name="selected_seats"
                                value="{{ json_encode($checkoutData['grouped_seats']) }}">
                            <input type="hidden" id="movie_id" name="movie_id"
                                value="{{ $checkoutData['movie_id'] }}">

                            <div class="checkout-widget checkout-card mb-0">
                                <div class="form-group">
                                    <button type="submit" id="confirm-booking-button" class="custom-button"
                                        style="display: none;">Confirm Booking</button>
                                </div>
                                    <p class="notice">
                                        By Clicking "Confirm Booking" you agree to the <a href="#0">terms and
                                            conditions</a>
                                    </p>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
@endsection

@push('styles')
    <style>
        .pdf-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .booking-confirmed {
            text-align: center;
        }

        .booking-confirmed button[disabled] {
            background: #28a745;
            cursor: not-allowed;
        }

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
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stripe = Stripe("{{ config('services.stripe.key') }}");
            const payButton = document.getElementById('pay-button');
            const confirmBookingButton = document.getElementById('confirm-booking-button');

            // Check URL parameters for both payment and booking status
            const urlParams = new URLSearchParams(window.location.search);
            const paymentStatus = urlParams.get('payment');
            const bookingStatus = urlParams.get('booking');

            // Handle payment status
            if (paymentStatus === 'success') {
                confirmBookingButton.style.display = 'block';
                payButton.style.display = 'none';
                Toastify({
                    text: "Payment successful! You can now confirm your booking.",
                    backgroundColor: "green",
                    duration: 3000
                }).showToast();
            } else if (paymentStatus === 'failed') {
                Toastify({
                    text: "Payment failed. Please try again.",
                    backgroundColor: "red",
                    duration: 3000
                }).showToast();
            }

            // Handle booking confirmation
            if (bookingStatus === 'success' && {{ session('last_booking_id') ? 'true' : 'false' }}) {
                Toastify({
                    text: "Booking confirmed successfully!",
                    backgroundColor: "green",
                    duration: 3000
                }).showToast();

                // Hide payment-related elements
                if (payButton) payButton.style.display = 'none';
                if (confirmBookingButton) confirmBookingButton.style.display = 'none';
            }

            if (payButton) {
                payButton.addEventListener('click', async () => {
                    try {
                        const response = await fetch("{{ route('movies.ticket.payment') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                amount: {{ $checkoutData['total_price'] }} * 100, // Ensure it's multiplied by 100
                                currency: 'usd'
                            })
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const session = await response.json();
                        const result = await stripe.redirectToCheckout({
                            sessionId: session.id
                        });

                        if (result.error) {
                            Toastify({
                                text: result.error.message,
                                backgroundColor: "red",
                                duration: 3000
                            }).showToast();
                        }
                    } catch (error) {
                        console.error('Payment error:', error);
                        Toastify({
                            text: "Payment processing failed. Please try again.",
                            backgroundColor: "red",
                            duration: 3000
                        }).showToast();
                    }
                });
            }
        });
    </script>
@endpush