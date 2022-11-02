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
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col" class="text-center">Ngày cập nhật</th>
                                    <th scope="col" class="text-center">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($product_categories))
                                    @foreach($product_categories as $data)
                                        <tr>
                                            <th scope="row">{!!$data["id"]!!}</th>
                                            <td>{!!$data["name"]!!}</td>
                                            <td class="text-center">
                                                {!! date('H:i:s d-m-Y', strtotime($data["updated_at"])) !!}
                                            </td>
                                            <td class="text-center">
                                                <a href="{!! route('updateCategoryView',['id' => $data["id"]]) !!}"
                                                   class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{!! route('deleteCategory',['id' => $data["id"]]) !!}"
                                                      class="d-inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn cho hành động này không?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="4">Không có dữ liệu</td>
                                    </tr>
                                @endif
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
