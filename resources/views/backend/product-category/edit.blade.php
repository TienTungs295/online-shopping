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
                                            @include('backend.product-category.tree_select',['product_categories' => $product_categories,'selected_id' => isset($product_category) ? $product_category["parent_id"] : '','parent_id' => 0,'prefix'=> ""])
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
                                    <div class="col-md-12">
                                        <label class="form-label">Ảnh</label>
                                        <input type="text" id="image"
                                               value="{!! old('image', isset($product_category->image) ? url('uploads/images/'.$product_category->image) : '')!!}"
                                               name="image">
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
@section('morescripts')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};

        // IMAGE
        var image_url = $("#image").val();
        var config = {
            ajaxConfig: {
                url: APP_URL + "/rest/tai-anh",
                method: "post",
                paramsBuilder: function (uploaderFile) {
                    let form = new FormData();
                    form.append("file", uploaderFile.file);
                    form.append("sub-folder", "categories");
                    return form
                },
                ajaxRequester: function (config, uploaderFile, progressCallback, successCallback, errorCallback) {
                    $.ajax({
                        url: config.url,
                        contentType: false,
                        processData: false,
                        method: config.method,
                        data: config.paramsBuilder(uploaderFile),
                        success: function (response) {
                            successCallback(response)
                        },
                        error: function (response) {
                            console.error("Error", response)
                            errorCallback("Error")
                        },
                        xhr: function () {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (e) {
                                let progressRate = (e.loaded / e.total) * 100;
                                progressCallback(progressRate)
                            })
                            return xhr;
                        }
                    })
                },
                responseConverter: function (uploaderFile, response) {
                    return {
                        url: APP_URL + "/" + response.data.file_path,
                        name: response.data.file_name,
                    }
                }
            }
        }
        // if (image_url != null && image_url != "" & image_url != undefined) {
        //     let start_position = image_url.lastIndexOf("/") + 1;
        //     let image_name = image_url.substring(start_position, image_url.length);
        //     config.defaultValue = [{
        //         name: image_name,
        //         url: image_url
        //     }]
        // }
        $("#image").uploader(config)
            .on("upload-success", function (file, data) {

            }).on("file-remove", function () {

        });
        // END IMAGE
    </script>
@endsection
