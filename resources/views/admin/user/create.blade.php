@extends('admin.layouts.layouts') <!-- Replace 'layout.master' with the actual name of your main layout file -->

@section('content')
<div class="container-fluid">
    
        
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('dashboard.index') }}" class="">
                        <h3 class="text-primary">DarkPan</h3>
                    </a>
                    
                </div>
                <form id="userCreateForm" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingText" name="name"
                            placeholder="jhondoe" autocomplete="on" required>
                        <label for="floatingText">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email"
                            placeholder="name@example.com" autocomplete="on" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="row gx-2">
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword"
                                    name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingConfirmPassword"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="floatingConfirmPassword">Confirm Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
                        <label class="form-check-label" for="termsCheckbox">
                            I accept the <a href="#!">terms</a> and <a href="#!">privacy policy</a>.
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                </form>
            
    
</div>


<!-- Sign Up End -->
<script>
    $(document).ready(function() {
        $('#userCreateForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('users.store') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Toastify({
                            text: "Registration successful!",
                            backgroundColor: "green",
                            duration: 3000
                        }).showToast();
                        window.location.href = "{{ route('users.index') }}";
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
    });
</script>
@endsection


