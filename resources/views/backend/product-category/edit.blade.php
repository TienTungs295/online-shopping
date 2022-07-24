@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($product_category))
                    Cập nhật danh mục
                @else
                    Thêm mới danh mục
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
                                  action="{!! isset($product_category)? route('updateCategory',['id' => $product_category->id]) : route('createCategory') !!}">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tên danh mục<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               value="{!! old('name', isset($product_category->name) ? $product_category->name : '')!!}"
                                               class="form-control" name="name" maxlength="255" required
                                               placeholder="Tên danh mục">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Danh mục cha<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="parent_id" required>
                                            <option value="0">Root</option>
                                            @include('backend.product-category.tree_select',['product_categories' => $product_categories,'product_category' => $product_category,'parent_id' => 0,'prefix'=> ""])
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                        <textarea class="form-control" placeholder="Mô tả" name="description"
                                                  id="description"
                                                  rows="2">{{ old('description', isset($product_category->description) ? $product_category->description : '')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Đặc trưng</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input"
                                                   value="{!! old('is_featured', isset($product_category->is_featured) ? $product_category->is_featured : '')!!}"
                                                   name="is_featured"
                                                   {!! old('is_featured', isset($product_category->is_featured) && $product_category->is_featured == 1 ? 'checked' : '')!!} type="checkbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($product_category))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('categoryView') !!}">
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
