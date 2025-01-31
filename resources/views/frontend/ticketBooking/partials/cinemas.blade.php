<div class="row justify-content-center">
    <div class="col-lg-9 mb-5 mb-lg-0">
        <ul class="seat-plan-wrapper bg-five">
            @foreach ($formattedData['cinemas'] as $cinemaName => $shows)
                <li>
                    <div class="movie-name">
                        <div class="icons">
                            <i class="far fa-heart"></i>
                            <i class="fas fa-heart"></i>
                        </div>
                        <a href="#0" class="name">{{ $cinemaName }}</a>
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div class="movie-schedule">
                        @foreach ($shows as $show)
                            <div class="item">
                                {{ \Carbon\Carbon::parse($show['start_time'])->format('H:i') }} 
                            </div>
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
        
    </div>
    <div class="col-lg-3 col-md-6 col-sm-10">
        <div class="widget-1 widget-banner">
            <div class="widget-1-body">
                <a href="#0">
                    <img src="assets/images/sidebar/banner/banner03.jpg" alt="banner">
                </a>
            </div>
        </div>
    </div>
</div>