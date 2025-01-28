@extends('frontend.layouts.layouts')

@section('content')
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('frontend/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
                <!-- Profile Card -->
                <div class="col-lg-4" data-background="{{ asset('frontend/images/banner/banner01.jpg') }}">
                    <div class="card mb-4" style="background-color: #00123200; border: none;">
                        <div class="card-body text-center">
                            <img src="{{ asset('frontend/css/img/ava3.webp') }}" alt="avatar"
                                class="rounded-circle img-fluid"
                                style="width: 150px; border: 4px solid; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            <h5 class="my-3"
                                style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                John Smith</h5>
                            <p class="text-muted mb-1" style="color: #9FA6B0;">Full Stack Developer</p>
                            <p class="text-muted mb-4" style="color: #9FA6B0;">Bay Area, San Francisco, CA</p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn"
                                    style="background: linear-gradient(45deg, #9455B9, #FF9E77); color: #fff; border-radius: 5px; border: none;">Follow</button>
                                <button type="button" class="btn btn-outline"
                                    style="background: transparent; color: #9455B9; border: 1px solid; background: linear-gradient(45deg, #9455B9, #FF9E77); border-radius: 5px;">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Details Card -->
                <div class="col-lg-8">
                    <div class="card mb-4" style="background-color: #00123200; border: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" style="color: #9FA6B0;">Johnatan Smith</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" style="color: #9FA6B0;">example@example.com</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" style="color: #9FA6B0;">(097) 234-5678</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Mobile</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" style="color: #9FA6B0;">(098) 765-4321</p>
                                </div>
                            </div>
                            <hr style="border-color: #9455B9; background: linear-gradient(45deg, #9455B9, #FF9E77);">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"
                                        style="background: linear-gradient(45deg, #9455B9, #FF9E77); -webkit-background-clip: text; color: transparent;">
                                        Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" style="color: #9FA6B0;">Bay Area, San Francisco, CA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
