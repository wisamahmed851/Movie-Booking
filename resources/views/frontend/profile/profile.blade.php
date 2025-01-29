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
                            @if ($user->imag)
                                <img src="{{ asset('storage/' . $user->imag) }}" alt="User Image"
                                    class="rounded-circle img-fluid"
                                    style="width: 150px; border: 4px solid; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            @else
                                <img src="{{ asset('frontend/css/img/ava3.webp') }}" alt="Default Avatar"
                                    class="rounded-circle img-fluid"
                                    style="width: 150px; border: 4px solid; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            @endif

                            <h5 class="my-3"
                                style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                {{ $user->name }}</h5>

                            @if (!$user->img)
                                <button class="update-info-btn " data-type="image"
                                    style="background: linear-gradient(45deg, #9455B9, #FF9E77); color: white; border-radius: 10px; padding: 15px 25px;">
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
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Full Name</p>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <p class="text-muted mb-0">{{ $user->name }}</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">

                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Email</p>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">

                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Phone</p>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-0">
                                        @if ($user->phone)
                                            {{ $user->phone }}
                                        @else
                                            Not Available
                                        @endif
                                    </p>
                                    @if (!$user->phone)
                                        <a class="btn btn-sm update-info-btn" data-type="phone"
                                            style="background: linear-gradient(45deg, #9455B9, #FF9E77); color: white; border-radius: 20px;">
                                            Add Phone
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">

                            <div class="row d-flex align-items-center">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Address</p>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-0">
                                        @if ($user->address)
                                            {{ $user->address }}
                                        @else
                                            Not Available
                                        @endif
                                    </p>
                                    @if (!$user->address)
                                        <a class="btn btn-sm update-info-btn" data-type="address"
                                            style="background: linear-gradient(45deg, #9455B9, #FF9E77); color: white; border-radius: 20px;">
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
            <div class="modal-content" style="background-color: #001232; color: white;">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateInfoModalLabel">Update Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateInfoForm">
                        @csrf
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" hidden>
                        <input type="hidden" id="infoType" name="infoType"> <!-- Field Type (phone, address, image) -->

                        <div id="inputField">
                            <!-- Input field will be inserted dynamically -->
                        </div>

                        <button type="submit" class="btn mt-3"
                            style="background: linear-gradient(45deg, #9455B9, #FF9E77); color: white; border-radius: 20px;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    @push('styles')
        <style>
            .update-info-btn {
                position: relative;
                z-index: 98;
            }
        </style>
    @endpush
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log("jQuery Loaded Successfully");

            $(document).on("click", ".update-info-btn", function() {
                console.log('Button Clicked!');

                let infoType = $(this).data("type");
                console.log("Update Type:", infoType);

                $("#infoType").val(infoType);
                let inputField = $("#inputField");
                inputField.empty();

                if (infoType === "image") {
                    inputField.append('<input type="file" name="image" class="form-control">');
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
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Something went wrong.");
                    }
                });
            });
        });
    </script>
@endpush
