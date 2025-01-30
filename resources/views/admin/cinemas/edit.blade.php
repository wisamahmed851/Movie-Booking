@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px;">
            <h4 class="card-title flex-grow-1">Edit Cinema</h4>
            <a href="{{ route('cinemas.index') }}" class="btn btn-sm btn-primary">
                Cinemas List
            </a>
        </div>
        <div class="p-4" style="background-color: #3f424c;">
            <form id="cinemaEditForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-top: 10px; border: 1px solid #fff; padding: 10px; border-radius: 5px;">
                    <div class="row">
                        <!-- Title -->
                        <div class="mb-3 col-md-4">
                            <label for="title" class="form-label text-white">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $cinema->name) }}" placeholder="Enter title" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3 col-md-4">
                            <label for="address" class="form-label text-white">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address', $cinema->address) }}" placeholder="Enter address" required>
                        </div>

                        <!-- Cities -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label text-white">Cities</label>
                            <select class="form-select" name="city_id" required>
                                <option value="" disabled>Select a city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $cinema->city_id == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label text-white">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"
                            required>{{ old('description', $cinema->description) }}</textarea>
                    </div>
                </div>

                <div style="margin-top: 10px; border: 1px solid #fff; padding: 10px; border-radius: 5px;">
                    <!-- Show Timings -->
                    <h5 class="text-white mt-4">Show Timings</h5>
                    <p class="text-white">Add or edit the timings for shows available at this cinema. Each row represents a
                        separate show timing for the day.</p>

                    <div class="mb-3">
                        <button type="button" id="addShowTiming" class="btn btn-secondary">Add More</button>
                    </div>

                    <div id="showTimingsContainer">
                        @foreach ($cinema->timings as $timing)
                            <div class="row align-items-center mb-3 show-timing-row">
                                <div class="col-md-5">
                                    <label for="start_time[]" class="form-label text-white">Start Time</label>
                                    <input type="time" class="form-control time-input" name="start_time[]"
                                        value="{{ old('start_time[]', $timing->start_time) }}" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="end_time[]" class="form-label text-white">End Time</label>
                                    <input type="time" class="form-control time-input" name="end_time[]"
                                        value="{{ old('end_time[]', $timing->end_time) }}" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-show-timing">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="margin-top: 10px; border: 1px solid #fff; padding: 10px; border-radius: 5px;">
                    <!-- Seats Configuration -->
                    <h5 class="text-white mt-4">Seats Configuration</h5>


                    @php
                        // Get seat categories with null coalescing
                        $silver = $cinema->CinemaSeatsCategories->where('seat_category', 'silver')->first();
                        $gold = $cinema->CinemaSeatsCategories->where('seat_category', 'gold')->first();
                        $platinum = $cinema->CinemaSeatsCategories->where('seat_category', 'platinum')->first();
                    @endphp

                    <!-- Silver Seats -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enableSilver" name="enable_silver"
                                {{ $silver ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="enableSilver">Enable Silver Seats</label>
                        </div>
                        <div id="silverSeatsConfig" class="mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="silver_row" name="silver_row"
                                        value="{{ old('silver_row', $silver->series_alphabet ?? '') }}"
                                        placeholder="Enter Silver Seats Series Alphabet" {{ $silver ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="silver_seats" name="silver_seats"
                                        value="{{ old('silver_seats', $silver->no_of_seats ?? '') }}"
                                        placeholder="Enter No of Silver Seats" {{ $silver ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="silver_price" name="silver_price"
                                        value="{{ old('silver_price', $silver->price_per_seat ?? '') }}"
                                        placeholder="Enter Per Silver Seat Price" {{ $silver ? '' : 'disabled' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gold Seats -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enableGold" name="enable_gold"
                                {{ $gold ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="enableGold">Enable Gold Seats</label>
                        </div>
                        <div id="goldSeatsConfig" class="mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="gold_row" name="gold_row"
                                        value="{{ old('gold_row', $gold->series_alphabet ?? '') }}"
                                        placeholder="Enter Gold Seats Series Alphabet" {{ $gold ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="gold_seats" name="gold_seats"
                                        value="{{ old('gold_seats', $gold->no_of_seats ?? '') }}"
                                        placeholder="Enter No of Gold Seats" {{ $gold ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="gold_price" name="gold_price"
                                        value="{{ old('gold_price', $gold->price_per_seat ?? '') }}"
                                        placeholder="Enter Per Gold Seat Price" {{ $gold ? '' : 'disabled' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Platinum Seats -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enablePlatinum" name="enable_platinum"
                                {{ $platinum ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="enablePlatinum">Enable Platinum Seats</label>
                        </div>
                        <div id="platinumSeatsConfig" class="mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="platinum_row" name="platinum_row"
                                        value="{{ old('platinum_row', $platinum->series_alphabet ?? '') }}"
                                        placeholder="Enter Platinum Seats Series Alphabet"
                                        {{ $platinum ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="platinum_seats" name="platinum_seats"
                                        value="{{ old('platinum_seats', $platinum->no_of_seats ?? '') }}"
                                        placeholder="Enter No of Platinum Seats" {{ $platinum ? '' : 'disabled' }}>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="platinum_price" name="platinum_price"
                                        value="{{ old('platinum_price', $platinum->price_per_seat ?? '') }}"
                                        placeholder="Enter Per Platinum Seat Price" {{ $platinum ? '' : 'disabled' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Cinema</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Ensure the time picker icon is visible */
        .time-input::-webkit-calendar-picker-indicator {
            filter: invert(1);
            /* Makes the icon visible on dark backgrounds */
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').each(function() {
                toggleFields(this);
            }).on('change', function() {
                toggleFields(this);
            });
        });

        function toggleFields(checkbox) {
            $(checkbox).closest('div').next('div').find('input').prop('disabled', !checkbox.checked);
        }
    </script>
    <script>
        $(document).ready(function() {
            // Add show timings dynamically
            document.getElementById('addShowTiming').addEventListener('click', function() {
                var container = document.getElementById('showTimingsContainer');
                var newRow = document.createElement('div');
                newRow.classList.add('row', 'align-items-center', 'mb-3', 'show-timing-row');
                newRow.innerHTML = `
                <div class="col-md-5">
                    <label for="start_time[]" class="form-label text-white">Start Time</label>
                    <input type="time" class="form-control time-input" name="start_time[]" required>
                </div>
                <div class="col-md-5">
                    <label for="end_time[]" class="form-label text-white">End Time</label>
                    <input type="time" class="form-control time-input" name="end_time[]" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-show-timing">Remove</button>
                </div>
            `;
                container.appendChild(newRow);
            });

            // Remove show timing row
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-show-timing')) {
                    e.target.closest('.show-timing-row').remove();
                }
            });
            handleEditFormSubmission('#cinemaEditForm', {
                url: '{{ route('cinemas.update', ['id' => $cinema->id]) }}',
                useFormData: false, // Serialize form data as no files are included
                redirectUrl: "{{ route('cinemas.index') }}" // Redirect after success

            });
        });
    </script>
@endpush
