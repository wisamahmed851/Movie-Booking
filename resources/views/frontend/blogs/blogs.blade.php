@extends('frontend.layouts.layouts')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="main-page-header speaker-banner bg_img"
        data-background="{{ asset('frontend/images/banner/banner07.jpg') }}">
        <div class="container">
            <div class="speaker-banner-content">
                <h2 class="title">blog - 01</h2>
                <ul class="breadcrumb">
                    <li>
                        <a href="index.html">
                            Home
                        </a>
                    </li>
                    <li>
                        blog
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Blog-Section========== -->
    <section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-50 mb-lg-0">
                    <article>
                        @include('frontend.blogs.partials.blog', ['blogs' => $blogs])
                    </article>
                    <div class="pagination-area text-center">
                        @if ($blogs->lastPage() > 1)
                            <a href="{{ $blogs->previousPageUrl() }}"
                                class="{{ $blogs->currentPage() == 1 ? 'disabled' : '' }}">
                                <i class="fas fa-angle-double-left"></i><span>Prev</span>
                            </a>

                            @for ($i = 1; $i <= $blogs->lastPage(); $i++)
                                <a href="{{ $blogs->url($i) }}"
                                    class="{{ $blogs->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                            @endfor

                            <a href="{{ $blogs->nextPageUrl() }}"
                                class="{{ $blogs->currentPage() == $blogs->lastPage() ? 'disabled' : '' }}">
                                <span>Next</span><i class="fas fa-angle-double-right"></i>
                            </a>
                        @endif
                    </div>

                </div>
                <div class="col-lg-4 col-sm-10 col-md-8">
                    <aside>
                        <div class="widget widget-search">
                            <h5 class="title">search</h5>
                            <form class="search-form">
                                <input type="text" placeholder="Enter your Search Content" required>
                                <button type="submit"><i class="flaticon-loupe"></i>Search</button>
                            </form>
                        </div>
                        <div class="widget widget-post">
                            <h5 class="title">latest post</h5>
                            <div class="slider-nav">
                                <span class="flaticon-angle-pointing-to-left widget-prev"></span>
                                <span class="flaticon-right-arrow-angle widget-next active"></span>
                            </div>
                            <div class="widget-slider owl-carousel owl-theme">
                                <div class="item">
                                    <div class="thumb">
                                        <a href="#0">
                                            <img src="{{ asset('frontend/images/blog/slider01.jpg') }}" alt="blog">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="p-title">
                                            <a href="#0">Three Ways to Book Sporting Event Tickets</a>
                                        </h6>
                                        <div class="meta-post">
                                            <a href="#0" class="mr-4"><i class="flaticon-loupe"></i>20
                                                Comments</a>
                                            <a href="#0"><i class="flaticon-loupe"></i>466 View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="thumb">
                                        <a href="#0">
                                            <img src="{{ asset('frontend/images/blog/slider01.jpg') }}" alt="blog">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="p-title">
                                            <a href="#0">Three Ways to Book Sporting Event Tickets</a>
                                        </h6>
                                        <div class="meta-post">
                                            <a href="#0" class="mr-4"><i class="flaticon-loupe"></i>20
                                                Comments</a>
                                            <a href="#0"><i class="flaticon-loupe"></i>466 View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-follow">
                            <h5 class="title">Follow Us</h5>
                            <ul class="social-icons">
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="active">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        {{-- <div class="widget widget-categories">
                            <h5 class="title">categories</h5>
                            <ul>
                                <li>
                                    <a href="#0">
                                        <span>Showtimes & Tickets</span><span>50</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Latest Trailers</span><span>43</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Coming Soon </span><span>34</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>In Theaters</span><span>63</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Release Calendar </span><span>11</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Stars</span><span>30</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Horror Movie </span><span>55</span>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                        {{-- <div class="widget widget-tags">
                            <h5 class="title">featured tags</h5>
                            <ul>
                                <li>
                                    <a href="#0">creative</a>
                                </li>
                                <li>
                                    <a href="#0">design</a>
                                </li>
                                <li>
                                    <a href="#0">skill</a>
                                </li>
                                <li>
                                    <a href="#0">template</a>
                                </li>
                                <li>
                                    <a href="#0" class="active">landing</a>
                                </li>
                            </ul>
                        </div> --}}
                    </aside>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ==========Blog-Section========== -->
@endsection
@push('styles')
    <style>
        .title a, .description {
            display: block;
            /* Ensures the text behaves as a block element */
            word-wrap: break-word;
            /* Break long words if necessary */
            overflow-wrap: break-word;
            white-space: normal;
            /* Ensures the text wraps */
            max-width: 100%;
            /* Prevents it from overflowing */
        }
    </style>
    @push('scripts')
        <script>
            $(document).on('click', '.post-item', function(e) {
                e.preventDefault();

                let selectedBlog = $(this).data('id');

                if (selectedBlog) {
                    // Redirect to the movie details page with the selected movie ID
                    window.location.href = "{{ route('blogs.details', ':id') }}".replace(':id', selectedBlog);;
                }
            });
        </script>
    @endpush
