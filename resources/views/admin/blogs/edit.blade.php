@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px;">
            <h4 class="card-title flex-grow-1">Edit Blog</h4>
            <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-primary">
                Blog List
            </a>
        </div>
        <div class="p-4 " style="background-color: #3f424c;">
            <form id="blogEditForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Title -->
                    <div class="mb-3 col-md-4">
                        <label for="title" class="form-label text-white">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title', $blog->title) }}" placeholder="Enter title" required>
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-3 col-md-6">
                        <label for="cover_image" class="form-label text-white">Cover Image</label>
                        <input type="file" class="form-control" id="coverImage" name="cover_image" accept="image/*">
                        <small class="text-white">Leave empty if you don't want to change the image.</small>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-3">
                    <label for="short_description" class="form-label text-white">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2"
                        placeholder="Enter a brief description" required>{{ old('short_description', $blog->blogDetails->short_description) }}</textarea>
                </div>

                <!-- Long Description -->
                <div class="mb-3">
                    <label for="long_description" class="form-label text-white">Long Description</label>
                    <textarea class="form-control" id="long_description" name="long_description" rows="5"
                        placeholder="Enter detailed content" required>{{ old('long_description', $blog->blogDetails->long_description) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitblog" class="btn btn-primary">Update blog</button>
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('long_description');
    </script>
    <script>
        $(document).ready(function() {


            // Handle form submission
            handleEditFormSubmission('#blogEditForm', {
                url: '{{ route('blogs.update', ['id' => $blog->id]) }}',
                useFormData: true, // Serialize form data as no files are included
                redirectUrl: "{{ route('blogs.index') }}" // Redirect after success

            });
        });
    </script>
@endpush
