@extends('admin.layouts.layouts') <!-- Replace 'layout.master' with the actual name of your main layout file -->

@section('content')
    <div class="container mt-5">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px;">
            <h4 class="card-title flex-grow-1">Create User</h4>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
                Users List
            </a>
        </div>
        <div class="p-4" style="background-color: #3f424c;">
            <form id="userCreateForm" method="POST" action="{{ route('users.store') }}">
                @csrf

                <!-- Name and Email -->
                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label text-white">Username</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter username" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label text-white">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                            required>
                    </div>
                </div>

                <!-- Password and Confirm Password -->
                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label text-white">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter password" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="password_confirmation" class="form-label text-white">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm password" required>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
                    <label class="form-check-label text-white" for="termsCheckbox">
                        I accept the <a href="#!" class="text-primary">terms</a> and <a href="#!"
                            class="text-primary">privacy policy</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" id="submitUser" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Sign Up End -->
@endsection
@push('scripts')
     <script>
        $(document).ready(function() {
            handleAjaxFormSubmit('#userCreateForm', '{{ route('users.store') }}', '{{ route('users.index') }}');
        });
    </script>
@endpush
