<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket</title>
    <style>
        .ticket { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; }
        .details { margin: 20px 0; }
        .seat-info { margin: 10px 0; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>{{ $booking->movie_title }}</h1>
            <h3>{{ $booking->cinema_name }}</h3>
        </div>
        
        <div class="details">
            <p>Show Date: {{ date('d M Y', strtotime($booking->show_date)) }}</p>
            <p>Show Time: {{ date('h:i A', strtotime($booking->show_start_time)) }} - {{ date('h:i A', strtotime($booking->show_end_time)) }}</p>
            <p>Total Price: Rs {{ number_format($booking->total_price, 2) }}</p>
        </div>

        <div class="seats">
            <h4>Seats:</h4>
            @foreach($seats as $seat)
                <div class="seat-info">
                    Seat {{ $seat->seat_number }} - 
                    {{ $seat->seat_category }}
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
