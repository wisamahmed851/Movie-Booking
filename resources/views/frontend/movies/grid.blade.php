@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset ('frontend/images/banner/banner02.jpg') }}"></div>
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
            <div class="search-tab bg_img" data-background="{{ asset ('frontend/images/ticket/ticket-bg01.jpg') }}">
                <div class="row align-items-center mb--20">
                    <div class="col-lg-6 mb-20">
                        <div class="search-ticket-header">
                            <h6 class="category">welcome to Movie Booking</h6>
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
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="14">12</option>
                                        <option value="14">14</option>
                                        <option value="16">16</option>
                                        <option value="18">18</option>
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
                            <ul class="grid-button">
                                <li class="active" data-layout="grid">
                                    <i class="fas fa-th"></i>
                                </li>
                                <li data-layout="list">
                                    <i class="fas fa-bars"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- End Second filter --}}

                    {{-- cards for movies --}}
                    <div class="tab-area" id="movie-grid">
                        @include('frontend.movies.partials.grid', ['movies' => $movies])
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
    $(document).ready(function() {
        let currentLayout = 'grid'; // Default layout

        // Handle layout change
        $(document).on('click', '.grid-button li', function(e) {
            e.preventDefault();

            // Get the selected layout type
            currentLayout = $(this).data('layout');

            // Add 'active' class to the selected button and remove from others
            $('.grid-button li').removeClass('active');
            $(this).addClass('active');

            // Trigger any necessary updates if needed
        });
        $(document).on('change', '.filter-input', function() {
            // Collect selected language IDs
            let filters = {
                languages: $('input[name="languages[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                genres: $('input[name="genres[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                sortBy: $('#sortDropdown').val(),
                Pagination: $('#Pagination').val(),
                layouts: currentLayout,
            };

            // Make AJAX call
            $.ajax({
                url: '{{ route('movies.loadmovies') }}',
                method: 'GET',
                data: filters,
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
        });
        $('#sortDropdown').on('change', function() {
            let filters = {
                languages: $('input[name="languages[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                genres: $('input[name="genres[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                sortBy: $('#sortDropdown').val(),
                Pagination: $('#Pagination').val(),
                layouts: currentLayout,
            };


            $.ajax({
                url: '{{ route('movies.loadmovies') }}',
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
        $('#Pagination').on('change', function() {
            let filters = {
                languages: $('input[name="languages[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                genres: $('input[name="genres[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                sortBy: $('#sortDropdown').val(),
                Pagination: $('#Pagination').val(),
                layouts: currentLayout,
            };

            $.ajax({
                url: '{{ route('movies.loadmovies') }}',
                method: 'GET',
                data: filters,
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
                Pagination: $('#Pagination').val(),
                layouts: currentLayout,
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
                window.location.href = "{{ route('movies.details', ':id') }}".replace(':id', selectedMovie);;
            }
        });
        $(document).on('click', '.card-style', function(e) {
            e.preventDefault();

            let selectedMovie = $(this).data('id');

            if (selectedMovie) {
                // Redirect to the movie details page with the selected movie ID
                window.location.href = `/movies/details/${selectedMovie}`;
            }
        });
        $(document).on('click', '.grid-button li', function(e) {
            e.preventDefault();

            // Get the selected layout type
            const layout = $(this).data('layout');

            // Add 'active' class to the selected button and remove from others
            $('.grid-button li').removeClass('active');
            $(this).addClass('active');

            // Collect filters
            let filters = {
                languages: $('input[name="languages[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                genres: $('input[name="genres[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                sortBy: $('#sortDropdown').val(),
                Pagination: $('#Pagination').val(),
                layouts: layout, // Include layout type
            };

            // AJAX request to fetch updated movies and pagination
            $.ajax({
                url: '{{ route('movies.loadmovies') }}', // Replace with your route for loading movies
                method: 'GET',
                data: filters,
                success: function(response) {
                    // Update the movie grid with new layout
                    $('#movie-grid').html(response.moviesHtml);

                    // Update pagination
                    $('#paginationControll').html(response.pagination);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                },
            });
        });

        // Handle pagination clicks
        $(document).on('click', '#paginationControll a', function(e) {
            e.preventDefault();

            // Get the URL for pagination
            let url = $(this).attr('href');

            // Collect filters
            let filters = {
                languages: $('input[name="languages[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                genres: $('input[name="genres[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
                sortBy: $('#sortDropdown').val(),
                Pagination: $('#Pagination').val(),
                layouts: currentLayout,
                // Use the current active layout
            };

            // AJAX request to fetch paginated results
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
                },
            });
        });


    });
    </script>
@endpush
