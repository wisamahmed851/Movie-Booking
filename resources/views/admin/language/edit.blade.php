@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6" style="background-color: #3f424c;">
                <div class=" rounded p-4" style="background-color: #3f424c; padding-top: 25px;">
                    <div class="card-header  d-flex justify-content-between align-items-center gap-1 text-white"
                        style="background-color: #3f424c; ">
                        <h4 class="card-title flex-grow-1">Edit Languages</h4>
                        <a href="{{ route('languages.index') }}" class="btn btn-sm btn-primary">
                            Languages List
                        </a>
                    </div>
                    <form id="languageCreate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label text-white">Language Name</label>
                            <input type="text" class="form-control" id="genreName" name="name"
                                placeholder="Enter genre name" required value="{{ $language->name }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Language</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Sign Up End -->
    <script>
        $(document).ready(function() {
            handleEditFormSubmission('#languageCreate', {
                url: '{{ route('languages.update', ['id' => $language->id]) }}',
                useFormData: false, // Serialize form data as no files are included
                redirectUrl: "{{ route('languages.index') }}" // Redirect after success

            });
        });
    </script>
@endpush
