@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px;">
            <h4 class="card-title flex-grow-1">Assign Movies to Cinemas</h4>
            <a href="{{ route('assign.movies.index') }}" class="btn btn-sm btn-primary">
                Assign Movies List
            </a>
        </div>
        <div class="p-4" style="background-color: #3f424c;">
            <form id="assignMoviesForm" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Movie Dropdown -->
                <div class="mb-4">
                    <label for="movie_id" class="form-label text-white">Select Movie</label>
                    <select class="form-select" id="movie_id" name="movie_id" required>
                        <option value="" disabled selected>Select a movie</option>
                        @foreach ($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cinemas List -->
                <div class="mb-4">
                    <label class="form-label text-white">Select Cinemas</label>
                    @foreach ($cinemas as $cinema)
                        <div class="cinema-row mb-3 p-3" style="border: 1px solid #fff; border-radius: 5px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input cinema-checkbox" type="checkbox"
                                    id="cinema_{{ $cinema->id }}" name="cinemas[]" value="{{ $cinema->id }}" checked>
                                <label class="form-check-label text-white" for="cinema_{{ $cinema->id }}">
                                    {{ $cinema->name }}
                                </label>
                            </div>

                            <!-- Multiple Timings for the Cinema -->
                            <div class="mt-2 timing-container" id="timing_container_{{ $cinema->id }}">
                                <div class="timing-row mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="form-label text-white">Start Time</label>
                                            <select class="form-select cinema-timing"
                                                name="cinema_timings[{{ $cinema->id }}][]" required>
                                                <option value="" disabled selected>Select a timing</option>
                                                @foreach ($cinema->timings as $timing)
                                                    <option value="{{ $timing->id }}">
                                                        {{ \Carbon\Carbon::parse($timing->start_time)->format('g:i A') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label text-white">Show Date</label>
                                            <input type="date" class="form-control show-date"
                                                name="show_dates[{{ $cinema->id }}][]" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-success add-timing"
                                                data-cinema-id="{{ $cinema->id }}">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitAssignMovies" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        /* Ensure the calendar icon inside the date input is visible */
        .show-date::-webkit-calendar-picker-indicator {
            filter: invert(1);
            /* Invert color to make it visible on dark backgrounds */
            opacity: 1;
            /* Ensure visibility */
            cursor: pointer;
            /* Indicate it's clickable */
        }

        /* Adjust input field text color */
        .show-date {
            color: white;
            /* Make text readable */
            background-color: black;
            /* Match input background */
            border: 1px solid #dc3545;
            /* Adjust border color if needed */
        }

        /* Optional: Improve placeholder visibility */
        .show-date::placeholder {
            color: #aaa;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            // Disable timing and date fields if cinema checkbox is unchecked
            $('.cinema-checkbox').on('change', function() {
                const cinemaRow = $(this).closest('.cinema-row');
                const isChecked = $(this).is(':checked');

                // Disable all inputs and selects within the timing container
                cinemaRow.find('.timing-container input, .timing-container select').prop('disabled', !
                    isChecked);
                cinemaRow.find('.add-timing').prop('disabled', !isChecked);
            });

            // Add more timing rows
            $(document).on('click', '.add-timing', function() {
                const cinemaId = $(this).data('cinema-id');
                const cinemaTimings = {!! json_encode(
                    $cinemas->keyBy('id')->map(function ($cinema) {
                        return $cinema->timings->map(function ($timing) {
                            return [
                                'id' => $timing->id,
                                'start_time' => \Carbon\Carbon::parse($timing->start_time)->format('g:i A'),
                            ];
                        });
                    }),
                ) !!};

                const timingOptions = cinemaTimings[cinemaId].map(timing => `
                    <option value="${timing.id}">${timing.start_time}</option>
                `).join('');

                const timingRow = `
                    <div class="timing-row mb-2">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label text-white">Start Time</label>
                                <select class="form-select cinema-timing" name="cinema_timings[${cinemaId}][]" required>
                                    <option value="" disabled selected>Select a timing</option>
                                    ${timingOptions}
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-white">Show Date</label>
                                <input type="date" class="form-control show-date" name="show_dates[${cinemaId}][]" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-timing">-</button>
                            </div>
                        </div>
                    </div>`;
                $(`#timing_container_${cinemaId}`).append(timingRow);
            });

            // Remove timing row
            $(document).on('click', '.remove-timing', function() {
                $(this).closest('.timing-row').remove();
            });

            // Handle form submission
            handleAjaxFormSubmit('#assignMoviesForm', '{{ route('assign.movies.store') }}',
                '{{ route('assign.movies.index') }}');
        });
    </script>
@endpush
