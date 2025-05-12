<div class="tab-item active">
    <div class="row mb-10 justify-content-center">
        <div class="row">
            @foreach ($movies as $movie)
                <div
                    class="col-sm-6 col-lg-4 @if ($movies->count() == 1) col-lg-4 @endif @if ($movies->count() == 2) col-lg-4 @endif">
                    <!-- Changed id to class and added data-id -->
                    <div class="movie-grid" data-id="{{ $movie['id'] }}">
                        <div class="movie-thumb c-thumb">
                            <!-- Removed hardcoded href -->
                            <a href="javascript:void(0);">
                                <img src="{{ asset('storage/' . $movie['cover_image']) }}" alt="">
                            </a>
                        </div>
                        <div class="movie-content bg-one">
                            <h5 class="title m-0">
                                <!-- Removed hardcoded href -->
                                <a href="javascript:void(0);">{{ $movie['title'] }}</a>
                            </h5>
                            <ul class="movie-rating-percent">
                                <li>
                                    <div class="thumb">
                                        <img src="{{ asset('Frontend/images/movie/tomato.png') }}" alt="rating">
                                    </div>
                                    <span class="content">88%</span>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <img src="{{ asset('Frontend/images/movie/cake.png') }}" alt="rating">
                                    </div>
                                    <span class="content">88%</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
