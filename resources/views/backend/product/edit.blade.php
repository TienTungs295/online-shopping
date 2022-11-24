@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($product->id))
                    Cập nhật sản phẩm
                @else
                    Thêm mới sản phẩm
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
                                  action="{!! isset($product->id)? route('updateProduct',['id' => $product->id]) : route('createProduct') !!}">
                                @csrf
                                <input type="hidden" id="product-id" name="product_id"
                                       value="{!! isset($product->id) ? $product->id :"" !!}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tên<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               value="{!! old('name', isset($product->name) ? $product->name : '')!!}"
                                               class="form-control" name="name" maxlength="255" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Danh mục</label>
                                        <select class="form-select" name="category_id">
                                            <option value="0">Không danh mục</option>
                                            @if(!empty($product_categories))
                                                @foreach($product_categories as $data)
                                                    <option
                                                        value="{!! $data["id"] !!}" {!! isset($product->id) && $product->category_id == $data["id"] ? 'selected' : ''!!}>{!! $data["name"] !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 d-flex-align-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input"
                                                   value="{!! old('is_featured', isset($product->is_featured) ? $product->is_featured : '')!!}"
                                                   name="is_featured"
                                                   {!! old('is_featured', isset($product->is_featured) && $product->is_featured == 1 ? 'checked' : '')!!} type="checkbox">
                                            <label class="form-label ml-10">Đặc trưng</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex-align-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input"
                                                   value="{!! old('is_trending', isset($product->is_trending) ? $product->is_trending : '')!!}"
                                                   name="is_trending"
                                                   {!! old('is_trending', isset($product->is_trending) && $product->is_trending == 1 ? 'checked' : '')!!} type="checkbox">
                                            <label class="form-label ml-10">Thịnh hàng</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Nội dung</label>
                                        <textarea class="3m-editor" name="content">
                                            {!! old('content', isset($product->content) ? $product->content : '') !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Ảnh</label>
                                        <input type="text" id="image"
                                               value="{!! old('image', isset($product->image) ? $product->image : '')!!}"
                                               name="image">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Ảnh đi kèm</label>
                                        <input type="text" id="images"
                                               value="{!! old('images', isset($product->images) ? $product->images : '')!!}"
                                               name="images">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text"
                                               value="{!! old('sku', isset($product->sku) ? $product->sku : '')!!}"
                                               class="form-control" name="sku" maxlength="255">
                                    </div>
                                    <div class="col-md-6 d-inline-flex-align-end">
                                        <div class="form-check">
                                            <input class="form-check-input" id="is-contact" type="checkbox"
                                                   value="{!! old('is_contact', isset($product->is_contact) ? $product->is_contact : 0)!!}"
                                                   {!! old('is_contact', isset($product->is_contact) && $product->is_contact == 1 ? 'checked' : '')!!}
                                                   name="is_contact">
                                            <label class="form-check-label">
                                                Giá liên hệ?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="price-block">
                                    <div class="col-md-4">
                                        <label class="form-label">Giá</label>
                                        <input type="number"
                                               value="{!! old('price', isset($product->price) ? $product->price : '')!!}"
                                               class="form-control" name="price">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Giá sale</label>
                                        <input type="number"
                                               value="{!! old('sale_price', isset($product->sale_price) ? $product->sale_price : '')!!}"
                                               class="form-control" name="sale_price">
                                    </div>
                                    <div class="col-md-4 d-inline-flex-align-end">
                                        <div class="form-check">
                                            <input class="form-check-input" id="apply-time" type="checkbox" value=""
                                                   name="apply_time">
                                            <label class="form-check-label">
                                                Thời gian áp dụng ?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 dis-none" id="apply-time-block">
                                    <div class="col-md-5">
                                        <label class="form-label">Ngày bắt đầu</label>
                                        <div class="input-group">
                                            <input type="text" readonly id="start-date"
                                                   value="{!! old('start_date', isset($product->start_date) ? date('d-m-Y H:i:s', strtotime($product->start_date)): '')!!}"
                                                   class="form-control" style="background: #fff"
                                                   name="start_date"/>
                                            <span class="input-group-text"><i
                                                    class="bi bi-calendar2-week"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Ngày kết thúc</label>
                                        <div class="input-group">
                                            <input type="text" readonly id="end-date"
                                                   value="{!! old('end_date', isset($product->end_date) ? date('d-m-Y H:i:s', strtotime($product->end_date)) : '')!!}"
                                                   class="form-control" style="background: #fff"
                                                   name="end_date"/>
                                            <span class="input-group-text"><i
                                                    class="bi bi-calendar2-week"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-inline-flex-align-end dis-none" id="is-flash-sale-block">
                                        <div class="form-check">
                                            <input class="form-check-input" id="is-flash-sale" type="checkbox"
                                                   value="{!! old('is_flash_sale', isset($product->is_flash_sale) ? $product->is_flash_sale : '')!!}"
                                                   {!! old('is_flash_sale', isset($product->is_flash_sale) && $product->is_flash_sale == 1 ? 'checked' : '')!!}
                                                   name="is_flash_sale">
                                            <label class="form-check-label">
                                                Flash Sale ?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="wrap-qty-block">
                                    <div class="col-md-4 d-inline-flex-align-end">
                                        <div class="form-check">
                                            <input class="form-check-input" id="with-storehouse-management"
                                                   type="checkbox"
                                                   value="{!! old('with_storehouse_management', isset($product->with_storehouse_management) ? $product->with_storehouse_management : '')!!}"
                                                   {!! old('with_storehouse_management', isset($product->with_storehouse_management) && $product->with_storehouse_management == 1 ? 'checked' : '')!!}
                                                   name="with_storehouse_management">
                                            <label class="form-check-label">
                                                Quản lý số lượng ?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="quantity-block">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number"
                                                   value="{!! old('quantity', isset($product->quantity) ? $product->quantity : '')!!}"
                                                   class="form-control" name="quantity">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-inline-flex-align-end">
                                        <div class="form-check" id="allow-checkout-when-out-of-stock-block">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="{!! old('allow_checkout_when_out_of_stock', isset($product->allow_checkout_when_out_of_stock) ? $product->allow_checkout_when_out_of_stock : '')!!}"
                                                   {!! old('allow_checkout_when_out_of_stock', isset($product->allow_checkout_when_out_of_stock) && $product->allow_checkout_when_out_of_stock == 1 ? 'checked' : '')!!}
                                                   name="allow_checkout_when_out_of_stock">
                                            <label class="form-check-label">
                                                Cho phép đặt hàng khi hết hàng
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="stock-status-block">
                                    <div class="col">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-control" name="stock_status" id="">
                                            <option
                                                value="1" {!! isset($product->id) && $product->stock_status == 1 ? 'selected' : ''!!}>
                                                Còn hàng
                                            </option>
                                            <option
                                                value="0" {!! isset($product->id) && $product->stock_status  == 0 ? 'selected' : ''!!}>
                                                Hết hàng
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" id="stock-status-block">
                                    <div class="col">
                                        <label class="form-label d-block">Bộ sưu tập</label>
                                        @if(!empty($collections))
                                            @foreach($collections as $data)
                                                <div class="form-check d-inline-flex mr-10">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="{!! $data->id !!}"
                                                           name="collections[]"
                                                        {!! isset($product->collection_ids) && in_array($data->id, $product->collection_ids) ? 'checked' : ''!!}>
                                                    <label class="ml-10 form-check-label">
                                                        {!! $data->name !!}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3" id="stock-status-block">
                                    <div class="col">
                                        <label class="form-label d-block">Nhãn</label>
                                        @if(!empty($labels))
                                            @foreach($labels as $data)
                                                <div class="form-check d-inline-flex mr-10">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="{!! $data->id !!}"
                                                           name="labels[]" {!! isset($product->label_ids) && in_array($data->id, $product->label_ids) ? 'checked' : ''!!}>
                                                    <label class="ml-10 form-check-label">
                                                        {!! $data->name !!}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Sản phẩm liên quan</label>
                                        <input class="form-control" id="product-autocomplete">
                                        <input type="hidden" id="related_product_ids" name="related_product_ids"
                                               value="{!! old('related_product_ids', isset($product->related_product_ids) ? $product->related_product_ids : '') !!}">
                                    </div>
                                </div>
                                <div class="row mb-3" id="products-selected">
                                    @if(isset($product->id) && !$product->related_products->isEmpty())
                                        @foreach($product->related_products as $data)
                                            <div class="product-item" id="{!! $data->id !!}">
                                                <div class="alert alert-light border-dark alert-dismissible "
                                                     role="alert">
                                                    <div>
                                                        <img style="margin-right: 20px"
                                                             src="{!! url('uploads/images/'.$data->image)  !!}"
                                                             alt="" width="60" height="60">
                                                        <span>{!! $data->name !!}</span>
                                                    </div>
                                                    <button type="button" class="btn-close remove-product"
                                                            btn-id="{!! $data->id !!}"></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($product->id))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('productView') !!}">
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
        if ($("#start-date").val() != "" || $("#end-date").val() != "") {
            $("#apply-time").prop('checked', true);
        }
        if ($("#end-date").val() != "") {
            $("#is-flash-sale-block").removeClass('dis-none');
        }
        showHideApplyTime();
        showHideStoreManagement();
        showHidePriceAndTime();
        $(function () {
            $("#start-date").datetimepicker({
                changeYear: true,
                timeFormat: 'H:mm:ss',
                showOn: 'focus',
                showButtonPanel: true,
                closeText: 'Xóa',
                onClose: function () {
                    var event = arguments.callee.caller.caller.caller.arguments[0];
                    if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                        $(this).val('');
                    }
                }
            })
        });
        $(function () {
            $("#end-date").datetimepicker({
                changeYear: true,
                timeFormat: 'H:mm:ss',
                onSelect: function (date, datepicker) {
                    if (date == "") {
                        $("#is-flash-sale-block").addClass('dis-none');
                        $("#is-flash-sale").prop('checked', false);
                    } else {
                        $("#is-flash-sale-block").removeClass('dis-none');
                    }
                },
                showOn: 'focus',
                showButtonPanel: true,
                closeText: 'Xóa',
                onClose: function () {
                    var event = arguments.callee.caller.caller.caller.arguments[0];
                    if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                        $(this).val('');
                        $("#is-flash-sale").prop('checked', false);
                        $("#is-flash-sale-block").addClass('dis-none');
                    }
                },
            })
        });
        var APP_URL = {!! json_encode(url('/')) !!};
        var exclude_id = $("#product-id").val();

        // IMAGES
        var image_strings = $("#images").val();
        var configForImages = {
            ajaxConfig: {
                url: APP_URL + "/rest/tai-anh",
                method: "post",
                paramsBuilder: function (uploaderFile) {
                    let form = new FormData();
                    form.append("file", uploaderFile.file)
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
                            let resData = response.data || {};
                            if (resData.status === "error") toastr.error(resData.message);
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
            },
            multiple: true,
        }
        // if (image_strings != null && image_strings != "" & image_strings != undefined) {
        //     let defaul_values = [];
        //     let image_urls = image_strings.split(",")
        //     for (let i = 0; i < image_urls.length; i++) {
        //         let image_url = image_urls[i];
        //         let start_position = image_url.lastIndexOf("/") + 1;
        //         let image_name = image_url.substring(start_position, image_url.length);
        //         defaul_values.push({
        //             name: image_name,
        //             url: image_url
        //         })
        //     }
        //     configForImages.defaultValue = defaul_values;
        // }
        $("#images").uploader(configForImages)
            .on("upload-success", function (file, data) {

            }).on("file-remove", function () {

        });
        // END IMAGES

        // IMAGE
        var image_url = $("#image").val();
        var config = {
            ajaxConfig: {
                url: APP_URL + "/rest/tai-anh",
                method: "post",
                paramsBuilder: function (uploaderFile) {
                    let form = new FormData();
                    form.append("file", uploaderFile.file)
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
                            let resData = response.data || {};
                            if (resData.status === "error") toastr.error(resData.message);
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
        $("#product-autocomplete").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: APP_URL + "/rest/product/find-by-name?exclude_id=" + exclude_id + "&name=" + request.term,
                    contentType: "json",
                    method: "GET",
                    success: function (res) {
                        let data = res.data || {};
                        let products = data.products || [];
                        let product_data = [];
                        if (products.length == 0 || products.length == undefined) {
                            response([]);
                            return;
                        }
                        products.forEach(function (item, index) {
                            product_data.push({
                                label: item.name,
                                value: item.name,
                                id: item.id,
                                image: item.image,
                            })
                        });
                        response(product_data);
                    },
                    error: function (response) {
                        console.error("Error", response)
                    }
                })
            },
            search: function (event, ui) {

            },
            select: function (event, ui) {
                let existElement = $(document).find("#" + ui.item.id);
                if (existElement.length != 0) {
                    $(this).val("");
                    return false;
                }
                var dom = `<div class="product-item" id="` + ui.item.id + `">
                                <div class="alert alert-light border-dark alert-dismissible " role="alert">
                                        <div>
                                            <img style="margin-right: 20px" src="` + APP_URL + `/uploads/images/` + ui.item.image + `" alt="" width="60" height="60">
                                            <span>` + ui.item.value + `</span>
                                        </div>
                                        <button type="button" class="btn-close remove-product" btn-id="` + ui.item.id + `"></button>
                                </div>
                           </div>`;

                let product_ids = $("#related_product_ids").val();
                let product_id_array = [];
                if (product_ids != null && product_ids != undefined && product_ids != "") {
                    product_id_array = product_ids.split(",");
                }
                if (!product_id_array.includes("" + ui.item.id)) {
                    product_id_array.push("" + ui.item.id);
                }
                product_ids = product_id_array.toString();
                $("#related_product_ids").val(product_ids);

                $("#products-selected").append(dom);
                $(this).val("");
                return false;
            }
        });

        $(document).on('click', '.remove-product', function (event) {
            let product_id = event.target.getAttribute("btn-id");
            $("#" + product_id).remove();

            let product_ids = $("#related_product_ids").val();
            let product_id_array = [];
            if (product_ids != null && product_ids != undefined && product_ids != "") {
                product_id_array = product_ids.split(",");
            }
            if (product_id_array.includes("" + product_id)) {
                let index = product_id_array.indexOf(product_id)
                product_id_array.splice(index, 1);
            }
            product_ids = product_id_array.toString();
            $("#related_product_ids").val(product_ids);

        });

        $("#apply-time").click(function (event) {
            showHideApplyTime();
        });

        function showHideApplyTime() {
            if ($("#apply-time").prop("checked") == true) {
                $("#apply-time-block").addClass("d-flex");
            } else {
                $("#apply-time-block").removeClass("d-flex");
                $("#apply-time-block").hide();
            }
        }

        $("#with-storehouse-management").click(function (event) {
            showHideStoreManagement();
        });

        function showHideStoreManagement() {
            if ($("#with-storehouse-management").prop("checked") == true) {
                $("#quantity-block").show();
                $("#allow-checkout-when-out-of-stock-block").show();
                $("#stock-status-block").removeClass("d-flex");
                $("#stock-status-block").hide();
            } else {
                $("#quantity-block").hide();
                $("#allow-checkout-when-out-of-stock-block").hide();
                $("#stock-status-block").addClass("d-flex");
            }
        }

        $("#is-contact").click(function (event) {
            showHidePriceAndTime();
        });

        function showHidePriceAndTime() {
            if ($("#is-contact").prop("checked") == true) {
                $("#price-block").addClass("dis-none");
                $("#apply-time-block").removeClass("d-flex");
                $("#apply-time-block").hide();
                $("#wrap-qty-block").addClass("dis-none");
            } else {
                $("#price-block").removeClass("dis-none");
                $("#wrap-qty-block").removeClass("dis-none");
                showHideApplyTime();
                showHideStoreManagement();
            }
        }

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
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {title: file.name});
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body {  font-family: Roboto, sans-serif; font-size:14px }'
        });
    </script>
@endsection

