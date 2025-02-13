@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6 rounded" style="background-color: #3f424c;">
                <div class=" rounded p-4">
                    <div class="card-header  d-flex justify-content-between align-items-center gap-1 text-white"
                        style="background-color: #3f424c; padding-top: 25px;">
                        <h4 class="card-title flex-grow-1">Create City</h4>
                        <a href="{{ route('city.index') }}" class="btn btn-sm btn-primary">
                            Cities List
                        </a>
                    </div>
                    <form id="CityCreate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label text-white">City</label>
                            <input type="text" class="form-control" id="CityName" name="name"
                                placeholder="Enter City name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add City</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Sign Up End -->
    <script>
        /*  $(document).ready(function() {
                $('#CityCreate').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route('city.store') }}',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000
                                }).showToast();
                                window.location.href = "{{ route('city.index') }}";
                            } else if (response.status === 'error') {
                                let errors = response.message;
                                let errorMessages = '';
                                for (let field in errors) {
                                    if (errors.hasOwnProperty(field)) {
                                        errorMessages += errors[field][0] + '\n';
                                    }
                                }
                                Toastify({
                                    text: errorMessages.trim(),
                                    backgroundColor: "red",
                                    duration: 5000
                                }).showToast();
                            }
                        },
                    });
                });
            }); */
        $(document).ready(function() {
            handleAjaxFormSubmit('#CityCreate', '{{ route('city.store') }}', '{{ route('city.index') }}');
        });
    </script>
@endpush
