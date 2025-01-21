@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="assets/images/banner/banner02.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
                <p>Buy movie tickets in advance, find movie times watch trailers, read movie reviews and much more</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Ticket-Search========== -->
    <section class="search-ticket-section padding-top pt-lg-0">
        <div class="container">
            <div class="search-tab bg_img" data-background="assets/images/ticket/ticket-bg01.jpg') }}">
                <div class="row align-items-center mb--20">
                    <div class="col-lg-6 mb-20">
                        <div class="search-ticket-header">
                            <h6 class="category">welcome to Boleto </h6>
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
                        <form class="ticket-search-form">
                            <div class="form-group large">
                                <input type="text" placeholder="Search fo Movies">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/city.png') }}" alt="ticket">
                                </div>
                                <span class="type">city</span>
                                <select class="select-bar">
                                    <option value="london">London</option>
                                    <option value="dhaka">dhaka</option>
                                    <option value="rosario">rosario</option>
                                    <option value="madrid">madrid</option>
                                    <option value="koltaka">kolkata</option>
                                    <option value="rome">rome</option>
                                    <option value="khoksa">khoksa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/date.png') }}" alt="ticket">
                                </div>
                                <span class="type">date</span>
                                <select class="select-bar">
                                    <option value="26-12-19">23/10/2020</option>
                                    <option value="26-12-19">24/10/2020</option>
                                    <option value="26-12-19">25/10/2020</option>
                                    <option value="26-12-19">26/10/2020</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/cinema.png') }}" alt="ticket">
                                </div>
                                <span class="type">cinema</span>
                                <select class="select-bar">
                                    <option value="Awaken">Awaken</option>
                                    <option value="dhaka">dhaka</option>
                                    <option value="rosario">rosario</option>
                                    <option value="madrid">madrid</option>
                                    <option value="koltaka">kolkata</option>
                                    <option value="rome">rome</option>
                                    <option value="khoksa">khoksa</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="tab-item">
                        <form class="ticket-search-form">
                            <div class="form-group large">
                                <input type="text" placeholder="Search fo Events">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/city.png') }}" alt="ticket">
                                </div>
                                <span class="type">city</span>
                                <select class="select-bar">
                                    <option value="london">London</option>
                                    <option value="dhaka">dhaka</option>
                                    <option value="rosario">rosario</option>
                                    <option value="madrid">madrid</option>
                                    <option value="koltaka">kolkata</option>
                                    <option value="rome">rome</option>
                                    <option value="khoksa">khoksa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/date.png') }}" alt="ticket">
                                </div>
                                <span class="type">date</span>
                                <select class="select-bar">
                                    <option value="26-12-19">23/10/2020</option>
                                    <option value="26-12-19">24/10/2020</option>
                                    <option value="26-12-19">25/10/2020</option>
                                    <option value="26-12-19">26/10/2020</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/cinema.png') }}" alt="ticket">
                                </div>
                                <span class="type">event</span>
                                <select class="select-bar">
                                    <option value="angular">angular</option>
                                    <option value="startup">startup</option>
                                    <option value="rosario">rosario</option>
                                    <option value="madrid">madrid</option>
                                    <option value="koltaka">kolkata</option>
                                    <option value="Last-First">Last-First</option>
                                    <option value="wish">wish</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="tab-item">
                        <form class="ticket-search-form">
                            <div class="form-group large">
                                <input type="text" placeholder="Search fo Sports">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/city.png') }}" alt="ticket">
                                </div>
                                <span class="type">city</span>
                                <select class="select-bar">
                                    <option value="london">London</option>
                                    <option value="dhaka">dhaka</option>
                                    <option value="rosario">rosario</option>
                                    <option value="madrid">madrid</option>
                                    <option value="koltaka">kolkata</option>
                                    <option value="rome">rome</option>
                                    <option value="khoksa">khoksa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/date.png') }}" alt="ticket">
                                </div>
                                <span class="type">date</span>
                                <select class="select-bar">
                                    <option value="26-12-19">23/10/2020</option>
                                    <option value="26-12-19">24/10/2020</option>
                                    <option value="26-12-19">25/10/2020</option>
                                    <option value="26-12-19">26/10/2020</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/ticket/cinema.png') }}" alt="ticket">
                                </div>
                                <span class="type">sports</span>
                                <select class="select-bar">
                                    <option value="football">football</option>
                                    <option value="cricket">cricket</option>
                                    <option value="cabadi">cabadi</option>
                                    <option value="madrid">madrid</option>
                                    <option value="gadon">gadon</option>
                                    <option value="rome">rome</option>
                                    <option value="khoksa">khoksa</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Ticket-Search========== -->

    <!-- ==========Movie-Section========== -->
    <section class="movie-section padding-top padding-bottom">
        <div class="container">
            <form class="filter" method="GET">
                <div class="row flex-wrap-reverse justify-content-center">
                    {{-- left filter Section --}}

                    <!-- Languages Filter -->
                    <div class="col-sm-10 col-md-8 col-lg-3">
                        <div class="widget-1 widget-check">
                            <div class="widget-header">
                                <h5 class="m-title">Filter By</h5>
                            </div>
                            <div class="widget-1-body">
                                <h6 class="subtitle">Language</h6>
                                <div class="check-area">
                                    @foreach ($languages as $language)
                                        <div class="form-group">
                                            <input type="checkbox" name="languages[]" value="{{ $language->id }}"
                                                class="filter-input" id="lang{{ $language->id }}">
                                            <label for="lang{{ $language->id }}">{{ $language->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Genres Filter -->
                        <div class="widget-1 widget-check">
                            <div class="widget-1-body">
                                <h6 class="subtitle">Genre</h6>
                                <div class="check-area">
                                    @foreach ($genres as $genre)
                                        <div class="form-group">
                                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                                class="filter-input" id="genre{{ $genre->id }}">
                                            <label for="genre{{ $genre->id }}">{{ $genre->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Experience Filter (2D/3D) -->
                        {{-- <div class="widget-1 widget-check">
                            <div class="widget-1-body">
                                <h6 class="subtitle">Experience</h6>
                                <div class="check-area">
                                    <div class="form-group">
                                        <input type="checkbox" name="experience[]" value="2d" class="filter-input"
                                            id="mode2d">
                                        <label for="mode2d">2D</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="experience[]" value="3d" class="filter-input"
                                            id="mode3d">
                                        <label for="mode3d">3D</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
            </form>
            {{-- End left filter section --}}

            <div class="col-lg-9 mb-50 mb-lg-0">
                <div class="filter-tab tab">

                    {{-- second Filter  --}}
                    <div class="filter-area">
                        <div class="filter-main">
                            <div class="left">
                                <div class="item">
                                    <span class="show">Show :</span>
                                    <select class="select-bar " id="Pagination">
                                        <option value="4">4</option>
                                        <option value="15">15</option>
                                        <option value="18">18</option>
                                        <option value="6">6</option>
                                        <option value="24">24</option>
                                        <option value="27">27</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                                <div class="item">
                                    <span class="show">Sort By :</span>
                                    <select class="select-bar " id="sortDropdown">
                                        <option value="showing">now showing</option>
                                        <option value="exclusive">exclusive</option>
                                        <option value="trending">trending</option>
                                    </select>
                                </div>
                            </div>
                            <ul class="grid-button tab-menu">
                                <li class="active">
                                    <i class="fas fa-th"></i>
                                </li>
                                <li>
                                    <i class="fas fa-bars"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- End Second filter --}}

                    {{-- cards for movies --}}
                    <div class="tab-area">
                        <div class="tab-item active">
                            <div class="row mb-10 justify-content-center">
                                <div class="row" id="movie-grid">
                                    @include('frontend.movies.partials.movies', ['movies' => $movies])
                                </div>

                            </div>
                        </div>
                        {{--  <div class="tab-item">
                                <div class="movie-area mb-10">
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie01.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie01.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">alone</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                        <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie02.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie02.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">mars</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie03.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie03.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">venus</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie04.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie04.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">on watch</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie05.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie05.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">fury</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie06.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie06.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">trooper</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie07.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie07.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">horror night</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie08.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie08.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">the lost name</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie09.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie09.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">calm stedfast</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie10.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie10.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">criminal on party</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie11.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie11.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">halloween party</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="movie-list">
                                        <div class="movie-thumb c-thumb">
                                            <a href="movie-details.html" class="w-100 bg_img h-100" data-background="assets/images/movie/movie12.jpg') }}">
                                                <img class="d-sm-none" src="{{ asset ('Frontend/images/movie/movie12.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html">the most wanted</a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="#0">action</a>
                                                <a href="#0">adventure</a>
                                                <a href="#0">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href="#0"> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset ('Frontend/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/heart.png') }}" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                        <a href="#0">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/book.png') }}" alt="icons">
                                                            </div>
                                                            <span>book ticket</span>
                                                        </a>
                                                    </div>
                                                    <div class="react-item">
                                                            <a href="#0" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="{{ asset ('Frontend/images/icons/play-button.png') }}" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                    </div>

                    <!-- Pagination Area -->
                    <div class="pagination-text-center" id="paginationControll">
                        {!! $pagination !!}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ==========Movie-Section========== -->
    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* This ensures the items are centered */
        }

        .movie-thumb img {
            width: 100%;
            /* Ensures the image spans the width of the container */
            height: 300px;
            /* Set a fixed height for all images */
            object-fit: cover;
            /* Ensures the image covers the dimensions without distortion */
            border-radius: 5px;
            /* Optional: Adds rounded corners to the images */
        }
    </style>
@endsection

@push('scripts')
    <script>
        /*  document.addEventListener("DOMContentLoaded", function() {
                                        // Bind change events to filters
                                        const filterInputs = document.querySelectorAll('.filter-input');
                                        filterInputs.forEach(input => {
                                            input.addEventListener('change', function() {
                                                updateMovieList();
                                            });
                                        });

                                        // Delegate pagination link clicks to a parent element
                                        document.querySelector('.pagination-area').addEventListener('click', function(e) {
                                            if (e.target.classList.contains('pagination-link')) {
                                                e.preventDefault();
                                                const page = e.target.getAttribute('data-page');
                                                updateMovieList(page);
                                            }
                                        });
                                    });

                                    function updateMovieList(page = 1) {
                                        // Gather filters
                                        const formData = new FormData(document.getElementById('filters-form'));
                                        formData.append('page', page); // Include the page number

                                        // Convert FormData to URLSearchParams for GET requests
                                        const queryString = new URLSearchParams(formData).toString();

                                        // Fetch filtered data
                                        fetch(`/movies/loadmovies?${queryString}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                // Update the movie list HTML
                                                document.getElementById('movie-list').innerHTML = data.moviesHtml;

                                                // Update pagination
                                                updatePagination(data.pagination);
                                            })
                                            .catch(error => console.error('Error:', error));
                                    }

                                    function updatePagination(pagination) {
                                        const paginationArea = document.querySelector('.pagination-area');
                                        paginationArea.innerHTML = pagination; // Update the pagination area with new links
                                    } */

        $(document).ready(function() {
            $(document).on('change', '.filter-input', function() {
                // Collect selected language IDs
                let languages = [];
                $('input[name="languages[]"]:checked').each(function() {
                    languages.push($(this).val());
                });

                // Collect selected genre IDs
                let genres = [];
                $('input[name="genres[]"]:checked').each(function() {
                    genres.push($(this).val());
                });

                // Make AJAX call
                $.ajax({
                    url: '/movies/loadmovies',
                    method: 'GET',
                    data: {
                        languages: languages,
                        genres: genres,
                    },
                    success: function(response) {
                        // Update the movie grid
                        console.log(response);
                        $('#movie-grid').html(response.moviesHtml);

                        // Update pagination
                        $('#pagination').html(response.pagination);

                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
            $('#sortDropdown').on('change', function() {
                let selectedValue = $(this).val();


                $.ajax({
                    url: '/movies/loadmovies',
                    method: 'GET',
                    data: {
                        sortBy: selectedValue
                    },
                    success: function(response) {
                        // Update the movie grid
                        $('#movie-grid').html(response.moviesHtml);

                        // Update pagination
                        $('#pagination').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            })
            $('#Pagination').on('change', function() {
                let selectedValue = $(this).val();

                $.ajax({
                    url: '/movies/loadmovies',
                    method: 'GET',
                    data: {
                        Pagination: selectedValue
                    },
                    success: function(response) {
                        // Update the movie grid
                        console.log(response);

                        $('#movie-grid').html(response.moviesHtml);

                        // Update pagination
                        $('#paginationControll').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            })
            $(document).on('click', '#paginationControll a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                let filters = {
                    languages: $('input[name="languages[]"]:checked').map(function() {
                        return $(this).val();
                    }).get(),
                    genres: $('input[name="genres[]"]:checked').map(function() {
                        return $(this).val();
                    }).get(),
                    sortBy: $('#sortDropdown').val(),

                };
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: filters,
                    success: function(response) {
                        // Update the movie grid
                        $('#movie-grid').html(response.moviesHtml);

                        // Update pagination
                        $('#paginationControll').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            })
            $(document).on('click', '.movie-grid', function(e) {
                e.preventDefault();

                let selectedMovie = $(this).data('id');

                if (selectedMovie) {
                    // Redirect to the movie details page with the selected movie ID
                    window.location.href = `/movies/details/${selectedMovie}`;
                }
            });

        });
    </script>
@endpush
