@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Add New Movie</h2>
        <div class="p-4 rounded" style="background-color: #3f424c;">
            <form id="movieCreateForm" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label text-white">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                        required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"
                        required></textarea>
                </div>

                <!-- Dropdowns -->
                <div class="row g-3">
                    <!-- Genres -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label text-white">Genres</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="genresDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Select Genres
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="genresDropdown">
                                @foreach ($genres as $genre)
                                    <li>
                                        <input type="checkbox" id="genre-{{ $genre->id }}" name="genre_ids[]"
                                            value="{{ $genre->id }}" class="form-check-input me-2">
                                        <label for="genre-{{ $genre->id }}"
                                            class="form-check-label">{{ $genre->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Languages -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label text-white">Languages</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="languagesDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Select Languages
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="languagesDropdown">
                                @foreach ($languages as $language)
                                    <li>
                                        <input type="checkbox" id="language-{{ $language->id }}" name="language_ids[]"
                                            value="{{ $language->id }}" class="form-check-input me-2">
                                        <label for="language-{{ $language->id }}"
                                            class="form-check-label">{{ $language->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- File Uploads -->
                <div class="mt-4">
                    <label class="form-label text-white">Upload Images</label>
                    <div class="mb-3">
                        <label for="coverImage" class="form-label text-white">Cover Image</label>
                        <input type="file" class="form-control" id="coverImage" name="cover_image" accept="image/*"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label text-white">Banner Image</label>
                        <input type="file" class="form-control" id="bannerImage" name="banner_image" accept="image/*"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sliderImages" class="form-label text-white">Slider Images</label>
                        <input type="file" class="form-control" id="sliderImages" name="slider_images[]" accept="image/*"
                            multiple required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitMovie" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#movieCreateForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('movies.store') }}",
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
                            window.location.href = "{{ route('movies.index') }}";
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
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            errorMessage += errors[key].join(' ') + '\n';
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
