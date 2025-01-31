@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner" data-background="assets/images/banner/banner04.jpg">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">Venus</h3>
                    <div class="tags">
                        <a href="#0">City Walk</a>
                        <a href="#0">English - 2D</a>
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
                    <span class="date">MON, SEP 09 2020</span>
                    <select class="select-bar">
                        <option value="sc1">09:40</option>
                        <option value="sc2">13:45</option>
                        <option value="sc3">15:45</option>
                        <option value="sc4">19:50</option>
                    </select>
                </div>
                <div class="item">
                    <h5 class="title">05:00</h5>
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
                <h5 class="subtitle">silver plus</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        <li class="seat-line">
                            <ul class="seat--area">
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="seat-line">
                            <ul class="seat--area">
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f7</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f8</span>
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f9</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f10</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f11</span>
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>


                <h5 class="subtitle">gold plus</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        <li class="seat-line">
                            <ul class="seat--area">
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="seat-line">
                            <ul class="seat--area">
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f7</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f8</span>
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                                <li class="front-seat">
                                    <ul>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f9</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f10</span>
                                        </li>
                                        <li class="single-seat seat-free">
                                            <img src="{{ asset('Frontend/images/movie/seat01-free.png') }}"
                                                alt="seat">

                                            <span class="sit-num">f11</span>
                                        </li>
                                        <li class="single-seat">
                                            <img src="{{ asset('Frontend/images/movie/seat01.png') }}" alt="seat">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="proceed-book bg_img" data-background="assets/images/movie/movie-bg-proceed.jpg">
                <div class="proceed-to-book">
                    <div class="book-item">
                        <span>You have Choosed Seat</span>
                        <h3 class="title">d9, d10</h3>
                    </div>
                    <div class="book-item">
                        <span>total price</span>
                        <h3 class="title">$150</h3>
                    </div>
                    <div class="book-item">
                        <a href="movie-checkout.html" class="custom-button">proceed</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
@endsection
