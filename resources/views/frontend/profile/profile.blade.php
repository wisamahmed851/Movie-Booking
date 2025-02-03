@extends('frontend.layouts.layouts')

@section('content')
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('frontend/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
                <!-- Profile Card -->
                <div class="col-lg-4" data-background="{{ asset('frontend/images/banner/banner01.jpg') }}">
                    <div class="card mb-4" style="background-color: #001232; border: none;">
                        <div class="card-body text-center">
                            <div class="profile-img-container position-relative d-inline-block" style="width: 150px;">
                                <img src="{{ asset($user->img ?: 'frontend/css/img/ava3.webp') }}" alt="User Image"
                                    class="profile-img rounded-circle img-fluid"
                                    style="width: 150px; border: 4px solid; background: linear-gradient(45deg, #e6485f, #5560FF); cursor: pointer; transition: 0.3s;">

                                <!-- Hover Overlay -->
                                <div class="hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="background: rgba(0, 0, 0, 0.5); color: white; font-size: 14px; font-weight: bold; border-radius: 50%; opacity: 0; transition: opacity 0.3s;">
                                    Click to Change Image
                                </div>
                            </div>
                            <h5 class="my-3"
                                style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                {{ $user->name }}</h5>

                            @if (!$user->img)
                                <button class="update-info-btn " data-type="img"
                                    style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 10px; padding: 15px 25px;">
                                    Add Image
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="col-lg-8">
                    <div class="card mb-4" style="background-color: #001232; border: none;">
                        <div class="card-body">
                            <!-- Name -->
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                        Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 text-white">{{ $user->name }}</p> <!-- Changed text color to white -->
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #e6485f, #5560FF);">

                            <!-- Email -->
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                        Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 text-white">{{ $user->email }}</p> <!-- Changed text color to white -->
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #e6485f, #5560FF);">

                            <!-- Password -->
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                        Password</p>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <p class="mb-0 text-white">******</p> <!-- Changed text color to white -->
                                    <a class="btn btn-sm passworChange" data-bs-toggle="modal" data-bs-toggle="modal"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 20px;">
                                        Change Password
                                    </a>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #e6485f, #5560FF);">

                            <!-- Phone -->
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                        Phone</p>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <p class="mb-0 text-white">
                                        @if ($user->phone)
                                            {{ $user->phone }}
                                        @else
                                            Not Available
                                        @endif
                                    </p> <!-- Changed text color to white -->
                                    @if (!$user->phone)
                                        <a class="btn btn-sm update-info-btn" data-type="phone"
                                            style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 20px;">
                                            Add Phone
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #e6485f, #5560FF);">

                            <!-- Address -->
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #e6485f, #5560FF); -webkit-background-clip: text; color: transparent;">
                                        Address</p>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <p class="mb-0 text-white">
                                        @if ($user->address)
                                            {{ $user->address }}
                                        @else
                                            Not Available
                                        @endif
                                    </p> <!-- Changed text color to white -->
                                    @if (!$user->address)
                                        <a class="btn btn-sm update-info-btn" data-type="address"
                                            style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 20px;">
                                            Add Address
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Update Info Modal -->
    <div class="modal fade" id="modaaaaal" tabindex="-1" aria-labelledby="updateInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(0, 18, 50, 0.9); color: white; border-radius: 10px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="updateInfoModalLabel">Update Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <form id="updateInfoForm">
                        @csrf
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" hidden>
                        <input type="hidden" id="infoType" name="infoType">
                        <div id="inputField"></div>
                        <button type="submit" class="btn mt-3"
                            style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 20px; border: none;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for changing password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(0, 18, 50, 0.9); color: white; border-radius: 10px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required
                                style="background-color: #001232; color: white; border: 1px solid white;">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required
                                style="background-color: #001232; color: white; border: 1px solid white;">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                required style="background-color: #001232; color: white; border: 1px solid white;">
                        </div>
                        <button type="submit" class="btn"
                            style="background: linear-gradient(45deg, #e6485f, #5560FF); color: white; border-radius: 20px; border: none;">
                            Save Changes
                        </button>
                    </form>
                    <div id="errorMessage" class="mt-2 text-danger" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .update-info-btn,
        .passworChange {
            cursor: pointer;
            position: relative;
            z-index: 98;
            padding: 5px 15px;
        }

        .profile-img {
            cursor: pointer;
            position: relative;
            z-index: 98;
        }

        .profile-img-container:hover .hover-overlay {
            opacity: 1;
        }

        /* Ensure text is white */
        .text-white {
            color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the "Change Password" button
            const passwordChangeButton = document.querySelector('.passworChange');

            // Get the modal element
            const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

            // Open the modal when the button is clicked
            passwordChangeButton.addEventListener('click', function() {
                changePasswordModal.show();
            });
        });

        $(document).ready(function() {
            console.log("jQuery Loaded Successfully");

            $(document).on("click", ".update-info-btn, .profile-img", function() {
                console.log('Button Clicked!');

                let infoType = $(this).data("type") || "img"; // Ensure the default type is "img"
                console.log("Update Type:", infoType);

                $("#infoType").val(infoType);
                let inputField = $("#inputField");
                inputField.empty();

                if (infoType === "img") {
                    inputField.append('<input type="file" name="img" class="form-control">');
                } else {
                    inputField.append('<input type="text" name="' + infoType +
                        '" class="form-control" required>');
                }

                $("#modaaaaal").modal("show");
            });

            $("#updateInfoForm").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = "{{ route('user.updateInfo') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else if (response.status === 'error') {
                            Toastify({
                                text: response.message,
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            errorMessage += errors[key].join(' ') + '\n';
                        }
                        Toastify({
                            text: errorMessage.trim(),
                            backgroundColor: "red",
                            duration: 5000
                        }).showToast();
                    }
                });
            });

            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this); // Create FormData to handle form data
                let url = 'user/update-password'; // URL for updating password

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').val() // CSRF Token
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Show success toast message
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();

                            // Optionally, close the modal after success
                            $('#changePasswordModal').modal('hide');
                        } else if (response.status === 'error') {
                            // Show error message from the server
                            Toastify({
                                text: response.message,
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    },
                    error: function(xhr) {
                        // Handle errors if any (validation errors from backend)
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            errorMessage += errors[key].join(' ') + '\n';
                        }

                        // Show error toast with validation message
                        Toastify({
                            text: errorMessage.trim(),
                            backgroundColor: "red",
                            duration: 5000
                        }).showToast();
                    }
                });
            });
        });
    </script>
@endpush