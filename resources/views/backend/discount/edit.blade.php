@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($disacount))
                    Cập nhật mã giảm giá
                @else
                    Thêm mới mã giảm giá
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
                                  action="{!! isset($disacount)? route('updateDiscount',['id' => $disacount->id]) : route('createDiscount') !!}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Mã<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               id="code"
                                               value="{!! old('code', isset($disacount->code) ? $disacount->code : '')!!}"
                                               class="form-control" name="code" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label class="form-label">Ngày bắt đầu</label>
                                        <div class="input-group">
                                            <input type="text" readonly
                                                   value="{!! old('start_date', isset($flash_sale->start_date) ? $flash_sale->start_date->format('d-m-Y') : '')!!}"
                                                   class="datepicker form-control"
                                                   name="start_date"/>
                                            <span class="input-group-text"><i
                                                    class="bi bi-calendar2-week"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Ngày kết thúc</label>
                                        <div class="input-group">
                                            <input type="text" readonly id="end_date"
                                                   value="{!! old('end_date', isset($flash_sale->end_date) ? $flash_sale->end_date->format('d-m-Y') : '')!!}"
                                                   class="datepicker form-control"
                                                   name="end_date"/>
                                            <span class="input-group-text"><i
                                                    class="bi bi-calendar2-week"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="display: inline-flex;align-items: flex-end;">
                                        <div class="form-check">
                                            <input class="form-check-input" id="unlimited_time" type="checkbox" value=""
                                                   name="unlimited_time">
                                            <label class="form-check-label">
                                                Không thời hạn
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6"
                                         style="display: inline-flex;align-items: flex-end; height: 64px">
                                        <div class="form-check">
                                            <input class="form-check-input" id="un_limited" type="checkbox" value=""
                                                   name="un_limited">
                                            <label class="form-check-label">
                                                Giới hạn
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="quantity-block" style="display: none">
                                        <div id="quantity-form">
                                            <label class="form-label">Số lượng<span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                   value="{!! old('quantity', isset($disacount->quantity) ? $disacount->quantity : '')!!}"
                                                   class="form-control" id="quantity" name="quantity" min="1" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Loại mã giảm giá</label>
                                        <select class="form-select" id="type_option" name="type_option">
                                            <option value="amount">VNĐ</option>
                                            <option value="percentage">%</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Giảm giá<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number"
                                                   value="{!! old('value', isset($disacount->value) ? $disacount->value : '')!!}"
                                                   class="form-control" name="value" min="1" required>
                                            <span class="input-group-text" id="percentage-icon" style="display: none">
                                                <i class="bi bi-percent"></i></span>
                                            <span class="input-group-text" id="cash-icon">
                                                <i class="bi bi-cash"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Áp dụng cho</label>
                                        <select class="form-select" id="target" name="target">
                                            <option value="all-orders">Toàn bộ đơn hàng</option>
                                            <option value="specific-product">Sản phẩm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" id="product-block" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label">Sản phẩm</label>
                                        <input class="form-control" id="product-autocomplete">
                                        <input type="hidden" id="product_ids" name="product_ids"
                                               value="{!! old('product_ids', isset($product->product_ids) ? $product->product_ids : '') !!}">
                                    </div>

                                    <div class="col-md-6" id="discount-on-block">
                                        <label class="form-label">Kiểu áp dụng</label>
                                        <select class="form-select" id="discount_on" name="discount_on">
                                            <option value="per-order">Một lần cho mỗi đơn đặt hàng</option>
                                            <option value="per-every-item">Một lần cho mỗi sản phẩm trong giỏ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" id="products-selected">
                                    {{--                                    @if(isset($product) && !$product->related_products->isEmpty())--}}
                                    {{--                                        @foreach($product->related_products as $data)--}}
                                    {{--                                            <div class="product-item" id="{!! $data->id !!}">--}}
                                    {{--                                                <div class="alert alert-light border-dark alert-dismissible "--}}
                                    {{--                                                     role="alert">--}}
                                    {{--                                                    <div>--}}
                                    {{--                                                        <img style="margin-right: 20px"--}}
                                    {{--                                                             src="{!! url('uploads/images/'.$data->image)  !!}"--}}
                                    {{--                                                             alt="" width="60" height="60">--}}
                                    {{--                                                        <span>{!! $data->name !!}</span>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <button type="button" class="btn-close remove-product"--}}
                                    {{--                                                            btn-id="{!! $data->id !!}"></button>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    @endif--}}
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($disacount))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('discountView') !!}">
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
@section("morescripts")
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        showHideQuantity();
        showHideProduct();
        showHideDiscountOn();
        changeIcon();
        $(".datepicker").datepicker({changeYear: true});
        $("#product-autocomplete").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: APP_URL + "/rest/product/find-by-name?name=" + request.term,
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

                let product_ids = $("#product_ids").val();
                let product_id_array = [];
                if (product_ids != null && product_ids != undefined && product_ids != "") {
                    product_id_array = product_ids.split(",");
                }
                if (!product_id_array.includes("" + ui.item.id)) {
                    product_id_array.push("" + ui.item.id);
                }
                product_ids = product_id_array.toString();
                $("#product_ids").val(product_ids);

                $("#products-selected").append(dom);
                $(this).val("");
                return false;
            }
        });

        $(document).on('click', '.remove-product', function (event) {
            let product_id = event.target.getAttribute("btn-id");
            $("#" + product_id).remove();

            let product_ids = $("#product_ids").val();
            let product_id_array = [];
            if (product_ids != null && product_ids != undefined && product_ids != "") {
                product_id_array = product_ids.split(",");
            }
            if (product_id_array.includes("" + product_id)) {
                let index = product_id_array.indexOf(product_id)
                product_id_array.splice(index, 1);
            }
            product_ids = product_id_array.toString();
            $("#product_ids").val(product_ids);

        });

        $("#un_limited").click(function (event) {
            showHideQuantity();
        });

        $("#unlimited_time").click(function (event) {
            disableEndDate();
        });

        $("#target").on("change", function (event) {
            showHideProduct();
            showHideDiscountOn();
        });

        $("#type_option").on("change", function (event) {
            changeIcon();
        });

        $('#code').keyup(function () {
            if (this.value != "" && this.value != null && this.value != undefined)
                this.value = this.value.toLocaleUpperCase();
        });

        function showHideQuantity() {
            if ($("#un_limited").prop("checked") == true) {
                $("#quantity-block").show();
                $("#quantity").attr({
                    min: 1,
                    required: true
                });
            } else {
                $("#quantity-block").hide();
                $("#quantity").removeAttr("min");
                $("#quantity").removeAttr("required");
            }
        }

        function showHideProduct() {
            if ($("#target").val() == "specific-product") {
                $("#product-block").show();
                $("#products-selected").show();
            } else {
                $("#product-block").hide();
                $("#products-selected").hide();
            }
        }

        function showHideDiscountOn() {
            if ($("#target").val() == "specific-product")
                $("#discount-on-block").show();
            else
                $("#discount-on-block").hide();
        }

        function changeIcon() {
            if ($("#type_option").val() == "amount") {
                $("#cash-icon").show();
                $("#percentage-icon").hide();
            } else {
                $("#cash-icon").hide();
                $("#percentage-icon").show();
            }
        }

        function disableEndDate() {
            if ($("#unlimited_time").prop("checked") == true) {
                $("#end_date").prop('disabled', true);
                $("#end_date").val("");
            } else {
                $("#end_date").prop('disabled', false);
            }
        }
    </script>
@endsection

