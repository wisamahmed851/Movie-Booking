@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white" style="background-color: #3f424c; padding-top: 25px;">
            <h4 class="card-title flex-grow-1">Create a Blog</h4>
            <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-primary">
                Blog List
            </a>
        </div>
        <div class="p-4" style="background-color: #3f424c;">
            <form id="blogCreateForm" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Title -->
                    <div class="mb-3 col-md-6">
                        <label for="title" class="form-label text-white">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-3 col-md-6">
                        <label for="cover_image" class="form-label text-white">Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-3">
                    <label for="short_description" class="form-label text-white">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2" placeholder="Enter a brief description" required></textarea>
                </div>

                <!-- Long Description -->
                <div class="mb-3">
                    <label for="long_description" class="form-label text-white">Long Description</label>
                    <textarea class="form-control" id="long_description" name="long_description" rows="5" placeholder="Enter detailed content" required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitBlog" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Ensure the file input icon is visible on dark backgrounds */
        input[type="file"]::-webkit-file-upload-button {
            filter: invert(1); /* Makes the icon visible on dark backgrounds */
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle form submission
            handleAjaxFormSubmit('#blogCreateForm', '{{ route('blogs.store') }}', '{{ route('blogs.index') }}');
        });
    </script>
@endpush
