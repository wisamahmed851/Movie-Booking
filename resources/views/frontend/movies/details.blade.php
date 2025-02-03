@php
    $hours = floor($movie->duration / 60);
    $minutes = $movie->duration % 60;
@endphp
@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner bg_img" data-background="{{ asset('storage/' . $movie->bannerImage->banner_image_path) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-thumb">
                    <img src="{{ asset('storage/' . $movie->coverImage->cover_image_path) }}" alt="{{ $movie->title }}">
                    <a href="{{ $movie->trailler }}" class="video-popup">
                        <img src="{{ asset('frontend/images/movie/video-button.png') }}" alt="movie">
                    </a>
                </div>
                <div class="details-banner-content offset-lg-3">
                    <h3 class="title">{{ $movie->title }}</h3>
                    <div class="tags">
                        @foreach ($genres as $genre)
                            <a href="" class="genre-link">{{ $genre->name }}</a>
                        @endforeach
                    </div>
                    @foreach ($languages as $laguage)
                        <a href="#0" class="button">{{ $laguage->name }}</a>
                    @endforeach

                    <div class="social-and-duration">
                        <div class="duration-area">
                            <div class="item">
                                <i class="fas fa-calendar-alt"></i><span>{{ $movie->release_date }}</span>
                            </div>
                            <div class="item">
                                <i
                                    class="far fa-clock"></i><span>{{ $hours > 0 ? $hours . 'h ' : '' }}{{ $minutes > 0 ? $minutes . 'min' : '' }}</span>
                            </div>
                        </div>
                        <ul class="social-share">
                            <li><a href="#0"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#0"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#0"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a href="#0"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#0"><i class="fab fa-google-plus-g"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
    <section class="book-section bg-one">
        <div class="container">
            <div class="book-wrapper offset-lg-3">
                <div class="left-side">
                    <!-- Tomatometer (Critic Score) -->
                    <div class="item">
                        <div class="item-header">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/movie/tomato2.png') }}" alt="movie">
                            </div>
                            <div class="counter-area">
                                <span class="counter-item odometer"
                                    data-odometer-final="{{ $movie->tomatometer ?? 0 }}">0</span>
                            </div>
                        </div>
                        <p>tomatometer</p>
                    </div>

                    <!-- Audience Score -->
                    <div class="item">
                        <div class="item-header">
                            <div class="thumb">
                                <img src="{{ asset('frontend/images/movie/cake2.png') }}" alt="movie">
                            </div>
                            <div class="counter-area">
                                <span class="counter-item odometer"
                                    data-odometer-final="{{ round($movie->average_rating * 20) }}">0</span>
                            </div>
                        </div>
                        <p>audience Score</p>
                    </div>

                    <!-- User Rating Display -->
                    <div class="item">
                        <div class="item-header">
                            <h5 class="title">{{ number_format($movie->average_rating, 1) }}</h5>
                            <div class="rated">
                                @php
                                    $fullStars = floor($movie->average_rating);
                                    $hasHalf = $movie->average_rating - $fullStars > 0;
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-heart"></i>
                                @endfor

                                @if ($hasHalf)
                                    <i class="fas fa-heart-half-alt"></i>
                                @endif

                                @for ($i = 0; $i < 5 - $fullStars - ($hasHalf ? 1 : 0); $i++)
                                    <i class="far fa-heart"></i>
                                @endfor
                            </div>
                        </div>
                        <p>Users Rating</p>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <div class="rated rate-it">
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-heart"></i>
                            </div>
                            <h5 class="title">{{ number_format($movie->average_rating, 1) }}</h5>
                        </div>
                        <p><a href="#" data-toggle="modal" data-target="#ratingModal">Rate It</a></p>
                        <!-- Updated line -->
                    </div>
                </div>
                <a class="custom-button" href="{{ route('movies.ticket-plan', $movie->id) }}">book tickets</a>
            </div>
        </div>
    </section>
    <!-- ==========Book-Section========== -->

    <!-- ==========Movie-Section========== -->
    <section class="movie-details-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center flex-wrap-reverse mb--50">
                <div class="col-lg-3 col-sm-10 col-md-6 mb-50">
                    {{-- <div class="widget-1 widget-offer">
                        <h3 class="title">Applicable offer</h3>
                        <div class="offer-body">
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{ asset ('Frontend/images/sidebar/offer01.png') }}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">Amazon Pay Cashback Offer</a>
                                    </h6>
                                    <p>Win Cashback Upto Rs 300*</p>
                                </div>
                            </div>
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{ asset ('Frontend/images/sidebar/offer02.png') }}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">PayPal Offer</a>
                                    </h6>
                                    <p>Transact first time with Paypal and
                                        get 100% cashback up to Rs. 500</p>
                                </div>
                            </div>
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{ asset ('Frontend/images/sidebar/offer03.png') }}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">HDFC Bank Offer</a>
                                    </h6>
                                    <p>Get 15% discount up to INR 100*
                                        and INR 50* off on F&B T&C apply</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{ asset ('Frontend/images/sidebar/banner/banner01.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-9 mb-50">
                    <div class="movie-details">
                        <h3 class="title">photos</h3>
                        <div class="details-photos owl-carousel">
                            @if ($movie->slider_images)
                                @foreach ($movie->slider_images as $slider)
                                    <div class="thumb">
                                        <a href="" class="img-pop">
                                            <img src="{{ asset('storage/' . $slider) }}" alt="movie">
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                No images available
                            @endif


                        </div>
                        <div class="tab summery-review">
                            <ul class="tab-menu">
                                <li class="active">
                                    summery
                                </li>
                                <li>
                                    user review <span>147</span>
                                </li>
                            </ul>
                            <div class="tab-area">
                                <div class="tab-item active">
                                    <div class="item">
                                        <h5 class="sub-title">Description</h5>
                                        <p>{{ $movie->description }}</p>
                                    </div>
                                    <div class="item">
                                        <div class="header">
                                            <h5 class="sub-title">cast</h5>
                                            <div class="navigation">
                                                <div class="cast-prev"><i class="flaticon-double-right-arrows-angles"></i>
                                                </div>
                                                <div class="cast-next"><i class="flaticon-double-right-arrows-angles"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="casting-slider owl-carousel">
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast01.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">Bill Hader</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As Richie Tozier</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast02.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">nora hardy</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As raven</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast03.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">alvin peters</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As magneto</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast04.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">josh potter</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As quicksilver</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="header">
                                            <h5 class="sub-title">crew</h5>
                                            <div class="navigation">
                                                <div class="cast-prev-2"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                                <div class="cast-next-2"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                            </div>
                                        </div>
                                        <div class="casting-slider-two owl-carousel">
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast05.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">pete warren</a></h6>
                                                    <span class="cate">actor</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast06.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">howard bass</a></h6>
                                                    <span class="cate">executive producer</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast07.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">naomi smith</a></h6>
                                                    <span class="cate">producer</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{ asset('Frontend/images/cast/cast08.jpg') }}"
                                                            alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">tom martinez</a></h6>
                                                    <span class="cate">producer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="movie-review-item">
                                        <div class="author">
                                            <div class="thumb">
                                                <a href="#0">
                                                    <img src="{{ asset('Frontend/images/cast/cast02.jpg') }}"
                                                        alt="cast">
                                                </a>
                                            </div>
                                            <div class="movie-review-info">
                                                <span class="reply-date">13 Days Ago</span>
                                                <h6 class="subtitle"><a href="#0">minkuk seo</a></h6>
                                                <span><i class="fas fa-check"></i> verified review</span>
                                            </div>
                                        </div>
                                        <div class="movie-review-content">
                                            <div class="review">
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                            </div>
                                            <h6 class="cont-title">Awesome Movie</h6>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat
                                                enim non ante egestas vehicula. Suspendisse potenti. Fusce malesuada
                                                fringilla lectus venenatis porttitor. </p>
                                            <div class="review-meta">
                                                <a href="#0">
                                                    <i class="flaticon-hand"></i><span>8</span>
                                                </a>
                                                <a href="#0" class="dislike">
                                                    <i class="flaticon-dont-like-symbol"></i><span>0</span>
                                                </a>
                                                <a href="#0">
                                                    Report Abuse
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-review-item">
                                        <div class="author">
                                            <div class="thumb">
                                                <a href="#0">
                                                    <img src="{{ asset('Frontend/images/cast/cast04.jpg') }}"
                                                        alt="cast">
                                                </a>
                                            </div>
                                            <div class="movie-review-info">
                                                <span class="reply-date">13 Days Ago</span>
                                                <h6 class="subtitle"><a href="#0">rudra rai</a></h6>
                                                <span><i class="fas fa-check"></i> verified review</span>
                                            </div>
                                        </div>
                                        <div class="movie-review-content">
                                            <div class="review">
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                            </div>
                                            <h6 class="cont-title">Awesome Movie</h6>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat
                                                enim non ante egestas vehicula. Suspendisse potenti. Fusce malesuada
                                                fringilla lectus venenatis porttitor. </p>
                                            <div class="review-meta">
                                                <a href="#0">
                                                    <i class="flaticon-hand"></i><span>8</span>
                                                </a>
                                                <a href="#0" class="dislike">
                                                    <i class="flaticon-dont-like-symbol"></i><span>0</span>
                                                </a>
                                                <a href="#0">
                                                    Report Abuse
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-review-item">
                                        <div class="author">
                                            <div class="thumb">
                                                <a href="#0">
                                                    <img src="{{ asset('Frontend/images/cast/cast01.jpg') }}"
                                                        alt="cast">
                                                </a>
                                            </div>
                                            <div class="movie-review-info">
                                                <span class="reply-date">13 Days Ago</span>
                                                <h6 class="subtitle"><a href="#0">rafuj</a></h6>
                                                <span><i class="fas fa-check"></i> verified review</span>
                                            </div>
                                        </div>
                                        <div class="movie-review-content">
                                            <div class="review">
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                            </div>
                                            <h6 class="cont-title">Awesome Movie</h6>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat
                                                enim non ante egestas vehicula. Suspendisse potenti. Fusce malesuada
                                                fringilla lectus venenatis porttitor. </p>
                                            <div class="review-meta">
                                                <a href="#0">
                                                    <i class="flaticon-hand"></i><span>8</span>
                                                </a>
                                                <a href="#0" class="dislike">
                                                    <i class="flaticon-dont-like-symbol"></i><span>0</span>
                                                </a>
                                                <a href="#0">
                                                    Report Abuse
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-review-item">
                                        <div class="author">
                                            <div class="thumb">
                                                <a href="#0">
                                                    <img src="{{ asset('Frontend/images/cast/cast03.jpg') }}"
                                                        alt="cast">
                                                </a>
                                            </div>
                                            <div class="movie-review-info">
                                                <span class="reply-date">13 Days Ago</span>
                                                <h6 class="subtitle"><a href="#0">bela bose</a></h6>
                                                <span><i class="fas fa-check"></i> verified review</span>
                                            </div>
                                        </div>
                                        <div class="movie-review-content">
                                            <div class="review">
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                                <i class="flaticon-favorite-heart-button"></i>
                                            </div>
                                            <h6 class="cont-title">Awesome Movie</h6>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat
                                                enim non ante egestas vehicula. Suspendisse potenti. Fusce malesuada
                                                fringilla lectus venenatis porttitor. </p>
                                            <div class="review-meta">
                                                <a href="#0">
                                                    <i class="flaticon-hand"></i><span>8</span>
                                                </a>
                                                <a href="#0" class="dislike">
                                                    <i class="flaticon-dont-like-symbol"></i><span>0</span>
                                                </a>
                                                <a href="#0">
                                                    Report Abuse
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="load-more text-center">
                                        <a href="#0" class="custom-button transparent">load more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Movie-Section========== -->
    <!-- Rating Modal -->
    <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title">Rate {{ $movie->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('movies.rate', $movie->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="rating-area text-center">
                            <div class="stars">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating"
                                        value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-heart"></i></label>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit Rating</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <style>
        .rating-area .stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            direction: rtl;
            /* Right to left for better UX */
        }

        .rating-area input[type="radio"] {
            display: none;
        }

        .rating-area label {
            color: #ddd;
            cursor: pointer;
            font-size: 30px;
        }

        .rating-area input[type="radio"]:checked~label,
        .rating-area input[type="radio"]:hover~label,
        .rating-area label:hover,
        .rating-area label:hover~label {
            color: #e12454;
        }
    </style>
@endpush
