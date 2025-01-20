 @foreach ($movies as $movie)
     <div class="col-sm-6 col-lg-4">
         <div class="movie-grid">
             <div class="movie-thumb c-thumb">
                 <a href="movie-details.html">
                     <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}">
                 </a>
             </div>
             <div class="movie-content bg-one">
                 <h5 class="title m-0">
                     <a href="movie-details.html">{{ $movie->title }}</a>
                 </h5>
                 <ul class="movie-rating-percent">
                     <li>
                         <div class="thumb">
                             <img src="{{ asset('Frontend/images/movie/tomato.png') }}" alt="rating">
                         </div>
                         <span class="content">88%</span> {{-- Replace with dynamic rating if available --}}
                     </li>
                     <li>
                         <div class="thumb">
                             <img src="{{ asset('Frontend/images/movie/cake.png') }}" alt="rating">
                         </div>
                         <span class="content">88%</span> {{-- Replace with dynamic rating if available --}}
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 @endforeach
