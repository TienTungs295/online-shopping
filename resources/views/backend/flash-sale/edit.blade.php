@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($flash_sale->id))
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
                                  action="{!! isset($flash_sale->id) ? route('updateFlashSale',['id' => $flash_sale->id]) : route('createFlashSale') !!}">
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
                                        <input type="hidden" id="product_ids" name="product_ids"
                                               value="{!! old('product_ids', isset($flash_sale->product_ids) ? $flash_sale->product_ids : '') !!}">
                                    </div>
                                </div>
                                <div class="row mb-3" id="products-selected">
                                    @if(isset($flash_sale) && !$flash_sale->products->isEmpty())
                                        @foreach($flash_sale->products as $data)
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
                                                <div class="row mb-3">
                                                    <div class="col-sm-6">
                                                        <label class="form-label">Giá<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"
                                                               name="products_extra[{!! $data->id !!}][price]"
                                                               value="{!! isset($data->pivot->price) ? $data->pivot->price : ''!!}"
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label">Số lượng<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"
                                                               value="{!! isset($data->pivot->quantity) ? $data->pivot->quantity : ''!!}"
                                                               name="products_extra[{!! $data->id !!}][quantity]"
                                                               class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($flash_sale->id))
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
        var APP_URL = {!! json_encode(url('/')) !!};
        $(function () {
            $(".datepicker").datepicker({changeYear: true});
        });
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
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Giá<span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="products_extra[` + ui.item.id + `][price]" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Số lượng<span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="products_extra[` + ui.item.id + `][quantity]" class="form-control" required>
                                    </div>
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
    </script>
@endsection
