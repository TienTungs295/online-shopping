@extends('backend.layouts.master')
@section('content')
<div class="main-inner">
    <div class="pagetitle">
        <h4>
            @if(isset($product_label))
                Cập nhật nhãn
            @else
                Thêm mới nhãn
            @endif
        </h4>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('backend.errors.note')
                    <div class="card-body">
                        <form method="POST"
                              action="{!! isset($product_label)? route('updateLabel',['id' => $product_label->id]) : route('createLabel') !!}">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tên nhãn<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           value="{!! old('name', isset($product_label->name) ? $product_label->name : '')!!}"
                                           class="form-control" name="name" maxlength="255" placeholder="Tên nhãn" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputColor" class="col-sm-2 col-form-label">Màu</label>
                                <div class="col-sm-10">
                                    <input type="color" class="form-control form-control-color" name="color"
                                           value="{!! old('color', isset($product_label->color) ? $product_label->color : '#4154f1')!!}"
                                           title="Chọn màu">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save2 me-1"></i>
                                    @if(isset($product_label))
                                    Cập nhật
                                    @else
                                    Thêm mới
                                    @endif
                                </button>
                                <a class="btn btn-danger" href="{!! route('labelView') !!}">
                                    <i class="bi bi-arrow-return-left me-1"></i>
                                    Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
