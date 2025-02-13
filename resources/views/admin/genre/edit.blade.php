@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6" style="background-color: #3f424c;">
                <div class=" rounded p-4" style="background-color: #3f424c; padding-top: 25px;">
                    <div class="card-header  d-flex justify-content-between align-items-center gap-1 text-white"
                        style="background-color: #3f424c; padding-top: 25px;">
                        <h4 class="card-title flex-grow-1">Edit Genre</h4>
                        <a href="{{ route('genres.index') }}" class="btn btn-sm btn-primary">
                            Genre List
                        </a>
                    </div>
                    <form id="genereCreate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label text-white">Genre Name</label>
                            <input type="text" class="form-control" id="genreName" name="name"
                                placeholder="Enter genre name" required value="{{ $genre->name }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Genre</button>
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
            handleEditFormSubmission('#genereCreate', {
                url: '{{ route('genres.update', ['id' => $genre->id]) }}',
                useFormData: true, // Serialize form data as no files are included
                redirectUrl: "{{ route('genres.index') }}" // Redirect after success
            });

        });
    </script>
@endpush
