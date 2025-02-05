<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket</title>
    <style>
        .ticket { width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details, .seats { margin: 20px 0; }
        .seat-info { margin: 10px 0; display: flex; justify-content: space-between; }
        .seat-info span { font-size: 14px; }
        .category-header { font-size: 16px; font-weight: bold; margin-top: 20px; }
        .total { text-align: center; margin-top: 30px; font-weight: bold; font-size: 18px; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1><strong>Movie:</strong> {{ $booking->movie_title }}</h1>
            <h3><strong>Cinema:</strong> {{ $booking->cinema_name }}</h3>
        </div>
        
        <div class="details">
            <p><strong>Show Date:</strong> {{ date('d M Y', strtotime($booking->show_date)) }}</p>
            <p><strong>Show Time:</strong> {{ date('h:i A', strtotime($booking->show_start_time)) }} - {{ date('h:i A', strtotime($booking->show_end_time)) }}</p>
        </div>

        <div class="seats">
            <h4><strong>Seats</strong></h4>
            
            @php
                $categories = collect();
                foreach($seats as $seat) {
                    $categories->push($seat->seat_category);
                }
                $categories = $categories->unique();
            @endphp

            @foreach($categories as $category)
                <div class="category-header">{{ $category }}</div>

                @foreach($seats as $seat)
                    @if($seat->seat_category == $category)
                        <div class="seat-info">
                            <span>Seat {{ $seat->seat_number }}</span>
                            <span>Rs {{ number_format($seat->price_per_seat) }}</span>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>

        <div class="total">
            <p><strong>Total Price:</strong> Rs {{ number_format($booking->total_price, 2) }}</p>
        </div>
    </div>
</body>
</html>
