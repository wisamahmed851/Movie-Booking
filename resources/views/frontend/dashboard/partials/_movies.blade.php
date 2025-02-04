<div class="row mb-30-none justify-content-center">
    @foreach ($movies as $movie)
        <div class="col-sm-6 col-lg-4">
            <div class="movie-grid" data-id="{{ $movie['id'] }}">
                <div class="movie-thumb c-thumb">
                    <a href="{{ route('movies.details', $movie['id']) }}">
                        <img src="{{ asset('storage/' . $movie['cover_image']) }}" alt="movie">
                    </a>
                </div>
                <div class="movie-content bg-one">
                    <h5 class="title m-0">
                        <a href="{{ route('movies.details', $movie['id']) }}">{{ $movie['title'] }}</a>
                    </h5>
                    <ul class="movie-rating-percent">
                        <li>
                            <div class="thumb">
                                <img src="{{ asset('Frontend/images/movie/tomato.png') }}" alt="movie">
                            </div>
                            <span class="content">88%</span>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ asset('Frontend/images/movie/cake.png') }}" alt="movie">
                            </div>
                            <span class="content">88%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
