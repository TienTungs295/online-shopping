@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>Bộ sưu tập</h4>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                            <div class="text-end">
                                <a href="{!! route('createCategoryView') !!}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-plus-lg me-1"></i> Thêm
                                    mới
                                </a>
                                <a href="{!! route('categoryView') !!}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-arrow-repeat me-1"></i> Làm mới
                                </a>
                            </div>
                            <table class="table table-hover table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col" class="text-center">Ngày cập nhật</th>
                                    <th scope="col" class="text-center">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                @include('backend.product-category.tree',['product_categories' => $product_categories,'parent_id' => 0,'prefix'=> ""])
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    @include('backend.errors.alert')
@endsection
