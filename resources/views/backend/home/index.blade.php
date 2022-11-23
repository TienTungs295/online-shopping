@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div>
            <div class="pagetitle">
                <h1>Trang chủ</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">

                    <!-- Left side columns -->
                    <div class="col">
                        <div class="row">

                            <!-- Order -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">


                                    <div class="card-body">
                                        <h5 class="card-title">Đơn hàng đang chờ xử lý</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_pending_order !!}</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Order -->

                            <!-- Review -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Đánh giá đang chờ xử lý</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-chat-left-text"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_pending_review!!}</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Review -->

                            <!-- Product -->
                            <div class="col-xxl-4 col-xl-12">

                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Sản phẩm</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-x-diamond-fill"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_product!!}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Product -->

                            <!-- Category -->
                            <div class="col-xxl-4 col-xl-12">

                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Danh mục</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-list-ul"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_category!!}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Category -->

                            <!-- Post -->
                            <div class="col-xxl-4 col-xl-12">

                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Bài viết</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_post!!}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Post -->

                            <!-- Customer -->
                            <div class="col-xxl-4 col-xl-12">

                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Khách hàng</h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{!! $total_customer_account!!}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Customer -->
                        </div>
                    </div><!-- End Left side columns -->
                </div>
            </section>
        </div>
    @include('backend.errors.alert')
@endsection
