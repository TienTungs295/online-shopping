@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($blog))
                    Cập nhật bài viết
                @else
                    Thêm mới bài viết
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
                                  action="{!! isset($blog)? route('updateBlog',['id' => $blog->id]) : route('createBlog') !!}">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tên bài viết<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               value="{!! old('name', isset($blog->name) ? $blog->name : '')!!}"
                                               class="form-control" name="name" maxlength="255" required
                                               placeholder="Tên bài viết">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Ảnh</label>
                                    <div class="col-md-10">
                                        <input type="text" id="image"
                                               value="{!! old('image', isset($blog->image) ? url('uploads/images/'.$blog->image) : '')!!}"
                                               name="image">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nội dung</label>
                                    <div class="col-sm-10">
                                        <textarea class="3m-editor" name="content">
                                            {!! old('content', isset($blog->content) ? $blog->content : '') !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($blog))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('blogView') !!}">
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
    <script type="application/javascript">
        var image_url = $("#image").val();
        var config = {
            ajaxConfig: {
                url: APP_URL + "/rest/tai-anh",
                method: "post",
                paramsBuilder: function (uploaderFile) {
                    let form = new FormData();
                    form.append("file", uploaderFile.file);
                    form.append("sub-folder", "blogs");
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
        tinymce.init({
            selector: 'textarea.3m-editor',
            height: 500,
            br_in_pre: false,
            plugins: [
                'advlist autolink link image lists charmap preview hr',
                'visualblocks code fullscreen media',
                'table paste'
            ],
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | preview media fullscreen | ' +
                'forecolor backcolor emoticons',
            menubar: 'file edit insert format table',
            paste_as_text: true,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {

                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body {  font-family: Roboto, sans-serif; font-size:14px }'
        });
    </script>
@endsection
