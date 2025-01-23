@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Movie</h2>
        <div class="p-4 rounded" style="background-color: #3f424c;">
            <form id="movieEditForm" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label text-white">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                        value="{{ $movie->title }}" required>
                </div>
                <!-- YouTube Trailer URL -->
                <div class="mb-3">
                    <label for="trailer_url" class="form-label text-white">Trailer URL (YouTube)</label>
                    <input type="url" class="form-control" id="trailer_url" name="trailer"
                        value="{{ $movie->trailler }}" placeholder="Enter YouTube trailer URL" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"
                        required>{{ $movie->description }}</textarea>
                </div>
                <!-- Release Date -->
                <div class="mb-3">
                    <label for="release_date" class="form-label text-white">Release Date</label>
                    <input type="date" class="form-control" id="release_date" name="release_date"
                        value="{{ $movie->release_date }}" required>
                </div>

                <!-- Duration -->
                <div class="mb-3">
                    <label for="duration" class="form-label text-white">Duration (in minutes)</label>
                    <input type="number" class="form-control" id="duration" name="duration"
                        placeholder="Enter duration in minutes" value="{{ $movie->duration }}" required>
                </div>

                <!-- Is Trending Checkbox -->
                <div class="mb-3">
                    <input type="hidden" name="isTrending" value=0>
                    <input type="checkbox" class="form-check-input" id="isTrending" name="isTrending" value="1"
                        {{ $movie->isTrending == 1 ? 'checked' : '' }}>
                    <label class="form-check-label text-white" for="isTrending">Is Trending</label>
                </div>

                <!-- Is Exclusive Checkbox -->
                <div class="mb-3">
                    <input type="hidden" name="isExclusive" value=0>
                    <input type="checkbox" class="form-check-input" id="isExclusive" name="isExclusive" value="1"
                        {{ $movie->isExclusive == 1 ? 'checked' : '' }}>
                    <label class="form-check-label text-white" for="isExclusive">Is Exclusive</label>
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
                                            value="{{ $genre->id }}" class="form-check-input me-2"
                                            {{ in_array($genre->id, $movie->genre_ids) ? 'checked' : '' }}>
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
                                            value="{{ $language->id }}" class="form-check-input me-2"
                                            {{ in_array($language->id, $movie->language_ids) ? 'checked' : '' }}>
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
                        <input type="file" class="form-control" id="coverImage" name="cover_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label text-white">Banner Image</label>
                        <input type="file" class="form-control" id="bannerImage" name="banner_image"
                            accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="sliderImages" class="form-label text-white">Slider Images</label>
                        <input type="file" class="form-control" id="sliderImages" name="slider_images[]"
                            accept="image/*" multiple>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitMovie" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            handleEditFormSubmission('#movieEditForm', {
                url: '{{ route('movies.update', ['id' => $movie->id]) }}',
                useFormData: false, // Serialize form data as no files are included
                redirectUrl: "{{ route('movies.index') }}" // Redirect after success
            });
        });
    </script>
@endpush
