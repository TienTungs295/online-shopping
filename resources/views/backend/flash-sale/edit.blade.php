@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($flash_sale))
                    Cập nhật flash sale
                @else
                    Thêm mới flash sale
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
                                  action="{!! isset($flash_sale)? route('updateFlashSale',['id' => $flash_sale->id]) : route('createFlashSale') !!}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-8">
                                        <label class="form-label">Tên<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               value="{!! old('name', isset($flash_sale->name) ? $flash_sale->name : '')!!}"
                                               class="form-control" name="name" maxlength="255" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Ngày hết hạn<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" readonly
                                                   value="{!! old('end_date', isset($flash_sale->end_date) ? $flash_sale->end_date->format('d-m-Y') : '')!!}"
                                                   class="datepicker form-control" style="background: #fff"
                                                   name="end_date"/>
                                            <span class="input-group-text"><i
                                                    class="bi bi-calendar2-week"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Sản phẩm</label>
                                        <input class="form-control" id="product-autocomplete">
                                        <input type="hidden" id="products" name="products" value="">
                                    </div>
                                </div>
                                <div class="row mb-3" id="products-selected">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($flash_sale))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('flashSaleView') !!}">
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
        $(function () {
            $(".datepicker").datepicker({changeYear: true});
        });
        var products = [{label: "Choice1", value: "value1"}, {label: "Choice2", value: "value2"}];
        // $.ajax({
        //     url: config.url,
        //     contentType: "json",
        //     method: "post",
        //     data: {},
        //     success: function (response) {
        //         let products = response.data || [];
        //         $("#products").autocomplete({
        //             source: products
        //         });
        //     },
        //     error: function (response) {
        //         console.error("Error", response)
        //     }
        // })

        $("#product-autocomplete").autocomplete({
            source: products,
            search: function (event, ui) {
                console.log(event.currentTarget.value);
            },
            select: function (event, ui) {
                let existElement = $(document).find("#" + ui.item.value);
                if (existElement.length != 0) {
                    return;
                }
                var dom = `<div class="product-item" id="` + ui.item.value + `">
                                <div class="alert alert-light border-dark alert-dismissible " role="alert">
                                        <div>
                                            <img style="margin-right: 20px" src="https://picsum.photos/seed/picsum/200/300" alt="" width="60" height="60">
                                            <span>Macbook</span>
                                        </div>
                                        <button type="button" class="btn-close remove-product" btn-id="` + ui.item.value + `"></button>
                                </div>
                           </div>`;

                let product_ids = $("#products").val();
                let product_id_array = [];
                if (product_ids != null && product_ids != undefined && product_ids != "") {
                    product_id_array = product_ids.split(",");
                }
                if (!product_id_array.includes("" + ui.item.value)) {
                    product_id_array.push("" + ui.item.value);
                }
                product_ids = product_id_array.toString();
                $("#products").val(product_ids);

                $("#products-selected").append(dom);
            }
        });

        $(document).on('click', '.remove-product', function (event) {
            let product_id = event.target.getAttribute("btn-id");
            $("#" + product_id).remove();

            let product_ids = $("#products").val();
            let product_id_array = [];
            if (product_ids != null && product_ids != undefined && product_ids != "") {
                product_id_array = product_ids.split(",");
            }
            if (product_id_array.includes("" + product_id)) {
                let index = product_id_array.indexOf(product_id)
                product_id_array.splice(index, 1);
            }
            product_ids = product_id_array.toString();
            $("#products").val(product_ids);

        });
    </script>
@endsection
