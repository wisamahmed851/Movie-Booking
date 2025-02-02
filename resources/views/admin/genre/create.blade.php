@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6 " style="background-color: #3f424c;">
                <div class=" rounded p-4" style="background-color: #3f424c;">
                    <div class="card-header  d-flex justify-content-between align-items-center gap-1 text-white"
                        style="background-color: #3f424c; ">
                        <h4 class="card-title flex-grow-1 text-white">All Users List</h4>
                        <a href="{{ route('genres.index') }}" class="btn btn-sm btn-primary">
                            Genres List
                        </a>
                    </div>
                    <form id="genereCreate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label text-white text-blod">Genre Name</label>
                            <input type="text" class="form-control" id="genreName" name="name"
                                placeholder="Enter genre name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Genre</button>
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
            handleAjaxFormSubmit('#genereCreate', '{{ route('genres.store') }}', '{{ route('genres.index') }}');
        });
    </script>
@endpush
