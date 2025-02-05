<div class="movie-area mb-10">
@if ($movies)
    @foreach ($movies as $movie)
        <div class="movie-list">
            <div class="movie-thumb c-thumb">
                <!-- Dynamic link and background -->
                <a href="{{ route('movies.details', ['id' => $movie['id']]) }}"
                   class="w-100 bg_img h-100"
                   data-background="{{ asset('storage/' . $movie['cover_image']) }}"
                   style="background-image: url('{{ asset('storage/' . $movie['cover_image']) }}');">
                    <img class="d-sm-none" src="{{ asset('storage/' . $movie['cover_image']) }}" alt="{{ $movie['title'] }}">
                </a>
            </div>
            <div class="movie-content bg-one">
                <h5 class="title">
                    <!-- Dynamic link and title -->
                    <a href="{{ route('movies.details', ['id' => $movie['id']]) }}">{{ $movie['title'] }}</a>
                </h5>
                <p class="duration">{{ $movie['duration'] . ' Min' ?? 'Unknown duration' }}</p>
                <div class="movie-tags">
                    <!-- Dynamic tags -->
                    {{-- @foreach ($movie['tags'] as $tag)
                        <a href="#0">{{ $tag }}</a>
                    @endforeach --}}
                </div>
                <div class="release">
                    <span>Release Date : </span>
                    <a href="#0">
                        {{ $movie['release_date'] ? \Carbon\Carbon::parse($movie['release_date'])->format('F j, Y') : 'TBD' }}
                    </a>


                </div>
                <ul class="movie-rating-percent">
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('Frontend/images/movie/tomato.png') }}" alt="rating">
                        </div>
                        <span class="content" data-odometer-final="">{{ round($movie['tomatometer']) }}%</span>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('Frontend/images/movie/cake.png') }}" alt="rating">
                        </div>
                        <span class="content" data-odometer-final="">{{ round($movie['average_rating'] * 20) }}%</span>
                    </li>
                </ul>
                <div class="book-area">
                    <div class="book-ticket">
                        <div class="react-item">
                            <a href="#0">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/icons/heart.png') }}" alt="icons">
                                </div>
                            </a>
                        </div>
                        <div class="react-item mr-auto">
                            <a href="{{ route('movies.ticket-plan', $movie['id']) }}">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/icons/book.png') }}" alt="icons">
                                </div>
                                <span>book ticket</span>
                            </a>
                        </div>
                        <div class="react-item">
                            <a href="{{ $movie['trailer'] }}" class="video-popup">
                                <div class="thumb">
                                    <img src="{{ asset('Frontend/images/icons/play-button.png') }}" alt="icons">
                                </div>
                                <span>watch trailer</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @else
    <h1>No movies</h1>
</div>


@endif
<script>
    $(document).ready(function() {
        let currentLayout = 'grid'; // Default layout
        // Initialize the magnificPopup plugin
        $('.video-popup').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 300,
            preloader: false,
            fixedContentPos: false
        });
    });
</script>
