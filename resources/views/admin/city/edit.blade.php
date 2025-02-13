@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6" style="background-color: #3f424c;">
                <div class=" rounded p-4" style="background-color: #3f424c; padding-top: 25px;">
                    <div class="card-header  d-flex justify-content-between align-items-center gap-1 text-white"
                    style="background-color: #3f424c; padding-top: 25px;">
                    <h4 class="card-title flex-grow-1">Edit City</h4>
                    <a href="{{ route('city.index') }}" class="btn btn-sm btn-primary">
                        City List
                    </a>
                </div>
                    <form id="cityCreate" method="POST" >
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label text-white">City Name</label>
                            <input type="text" class="form-control" id="genreName" name="name"
                                placeholder="Enter genre name" required value="{{ $city->name }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update City</button>
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
            handleEditFormSubmission('#cityCreate', {
                url: '{{ route('city.update', ['id' => $city->id]) }}',
                useFormData: false, // Serialize form data as no files are included
                redirectUrl: "{{ route('city.index') }}" // Redirect after success
                
            });
        });
  </script>
@endpush
