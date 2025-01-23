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
        <div class="p-4 " style="background-color: #3f424c;">
            <form id="cinemaEditForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                <option value="{{ $city->id }}" {{ $cinema->city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
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
                                <input type="time" class="form-control" name="start_time[]"
                                    value="{{ old('start_time[]', $timing->start_time) }}" required>
                            </div>
                            <div class="col-md-5">
                                <label for="end_time[]" class="form-label text-white">End Time</label>
                                <input type="time" class="form-control" name="end_time[]"
                                    value="{{ old('end_time[]', $timing->end_time) }}" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-show-timing">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>


                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitCinema" class="btn btn-primary">Update Cinema</button>
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
            // Add new show timing row
            $('#addShowTiming').on('click', function() {
                const newRow = `
                    <div class="row align-items-center mb-3 show-timing-row">
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
                    </div>`;
                $('#showTimingsContainer').append(newRow);
            });

            // Remove show timing row
            $(document).on('click', '.remove-show-timing', function() {
                $(this).closest('.show-timing-row').remove();
            });

            // Handle form submission
            $('#cinemaEditForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: "{{ route('cinemas.update', $cinema->id) }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();
                            window.location.href = "{{ route('cinemas.index') }}";
                        } else {
                            Toastify({
                                text: response.message,
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let key in errors) {
                            errorMessages += errors[key].join(' ') + '\n';
                        }
                        Toastify({
                            text: errorMessages.trim(),
                            backgroundColor: "red",
                            duration: 5000
                        }).showToast();
                    }
                });
            });
        });
    </script>
@endpush
