@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                Thông tin đơn đặt hàng
            </h4>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body pt-15-i pb-25-i">
                            <h5>Mã đơn hàng : #{!! $order->id !!}</h5>
                            <hr>
                            <div class="table-wrap">
                                <table class="w-100 order-table">
                                    <tbody>
                                    @if(!$order->orderProducts->isEmpty())
                                        @foreach($order->orderProducts as $order_product)
                                            <tr class="v-top">
                                                <td>
                                                    <div class="wrap-img">
                                                        @if(isset($order_product->product))
                                                            <img
                                                                class="thumb-image thumb-image-cartorderlist"
                                                                src="{!! url('uploads/images/'.$order_product->product->image) !!}"
                                                                alt="{!! $order_product->product->image !!}">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="pl-5 pr-5" style="min-width: 200px">
                                                    <span class="fw-bold">{!! $order_product->product_name !!}</span>
                                                    <br>
                                                    @if(isset($order_product->product))
                                                        @if(isset($order_product->product->sku))
                                                            (Mã sản phẩm:
                                                            <strong>{!! $order_product->product->sku !!}</strong>)
                                                        @endif
                                                    @else
                                                        (Sản phẩm hiện đã bị xóa)
                                                    @endif
                                                </td>
                                                <td class="pl-5 pr-5 text-right">
                                                    <div class="inline_block">
                                                        <span> {!! number_format(($order_product->price), 0, '', ',') !!} đ</span>
                                                    </div>
                                                </td>
                                                <td class="pl-5 pr-5 text-center">x</td>
                                                <td class="pl-5 pr-5">
                                                    <span>{!! $order_product->qty !!}</span>
                                                </td>
                                                <td class="pl-5 text-right">
                                                    {!! number_format(($order_product->price * $order_product->qty), 0, '', ',') !!} đ
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="5">
                                            <span class="fw-bold">
                                                Tạm tính:
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span>
                                                {!! number_format(($order->sub_total), 0, '', ',') !!} đ
                                            </span>
                                        </td>
                                    </tr>
                                    @if($order->coupon_code != null)
                                    <tr>
                                        <td colspan="5">
                                            <span class="fw-bold">
                                                Mã giảm giá:
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span class="alert alert-success coupon-text pt-10-i pb-10-i">
                                                {!! $order->coupon_code !!}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <span class="fw-bold">
                                                Khấu trừ:
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span>
                                                -  {!! number_format(($order->discount_value), 0, '', ',') !!} đ
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="5">
                                            <span class="fw-bold">
                                                Phí vận chuyển:
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span>
                                                {!! number_format(($order->shipping_fee), 0, '', ',') !!} đ
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <span class="fw-bold" style="font-size: 16px">
                                                Thành tiền:
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span class="fw-bold" style="font-size: 16px">
                                                {!! number_format(($order->sub_total_final), 0, '', ',') !!} đ
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            @if($order->status == 1)
                                <div class="text-right">
                                    <form method="POST" action="{!! route('changeOrderStatus',['id' => $order->id]) !!}"
                                          class="row g-3">
                                        @csrf
                                        <span>
                                <input type="hidden" name="expect_status" value="2">
                                    <button type="submit"
                                            class="btn btn-info btn-sm"><i class="bi bi-check2-circle me-1"></i>
                                        Xác nhận
                                    </button>
                                </span>
                                    </form>
                                </div>
                            @elseif($order->status > 1)
                                <div class="change-status-wrapper">
                                    <i class="__icon bi bi-check-lg"></i>
                                    <span class="__text">Đơn hàng đã được xác nhận</span>
                                </div>
                            @endif

                            {{--default--}}
                            @if($order->payment_method == 1)
                                @if($order->status >= 2)
                                    <hr>
                                @endif
                                @if($order->status == 2)
                                    <div class="text-right">
                                        <form method="POST"
                                              action="{!! route('changeOrderStatus',['id' => $order->id]) !!}"
                                              class="row g-3">
                                            @csrf
                                            <div class="container">
                                                <div class="row d-flex-align-end">
                                                    <div class="col-md-6 text-left">
                                                        <label class="form-label">Thực nhận:</label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                   value="{!! $order->sub_total_final !!}"
                                                                   name="received_price" class="form-control"
                                                                   aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">đ</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="submit"
                                                                class="btn btn-success btn-sm mt-15"><i
                                                                class="bi bi-coin me-1"></i>
                                                            Xác nhận thanh toán
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="expect_status" value="3">
                                        </form>
                                    </div>
                                @elseif($order->status >2)
                                    <div class="change-status-wrapper">
                                        <i class="__icon bi bi-check-lg"></i>
                                        <span class="__text">Số tiền: <span
                                                class="text-lowercase">
                                                {!! number_format(($order->received_price), 0, '', ',') !!} đ
                                            </span>   đã được thanh toán</span>
                                    </div>
                                @endif

                                @if($order->status >= 3)
                                    <hr>
                                @endif
                                @if($order->status == 3)
                                    <div class="text-right">
                                        <form method="POST"
                                              action="{!! route('changeOrderStatus',['id' => $order->id]) !!}"
                                              class="row g-3">
                                            @csrf
                                            <span>
                                    <button type="submit"
                                            class="btn btn-primary btn-sm"><i class="bi bi-truck me-1"></i>
                                        Giao hàng
                                    </button>
                                    <input type="hidden" name="expect_status" value="4">
                                </span>
                                        </form>
                                    </div>
                                @elseif($order->status > 3)
                                    <div class="change-status-wrapper">
                                        <i class="__icon bi bi-check-lg"></i>
                                        <span class="__text">Đã Giao hàng</span>
                                    </div>
                                @endif
                            @endif
                            {{--End default--}}

                            {{--COD--}}
                            @if($order->payment_method == 2)

                                @if($order->status >= 2)
                                    <hr>
                                @endif
                                @if($order->status == 2)
                                    <div class="text-right">
                                        <form method="POST"
                                              action="{!! route('changeOrderStatus',['id' => $order->id]) !!}"
                                              class="row g-3">
                                            @csrf
                                            <span>
                                    <button type="submit"
                                            class="btn btn-primary btn-sm"><i class="bi bi-truck me-1"></i>
                                        Giao hàng
                                    </button>
                                    <input type="hidden" name="expect_status" value="4">
                                </span>
                                        </form>
                                    </div>
                                @elseif($order->status > 2)
                                    <div class="change-status-wrapper">
                                        <i class="__icon bi bi-check-lg"></i>
                                        <span class="__text">Đã Giao hàng</span>
                                    </div>
                                @endif


                                @if($order->status == 4 || $order->status == 3)
                                    <hr>
                                @endif
                                @if($order->status == 4)
                                    <div class="text-right">
                                        <form method="POST"
                                              action="{!! route('changeOrderStatus',['id' => $order->id]) !!}"
                                              class="row g-3">
                                            @csrf
                                            <div class="container">
                                                <div class="row d-flex-align-end">
                                                    <div class="col-md-6 text-left">
                                                        <label class="form-label">Thực nhận:</label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                   value="{!! $order->sub_total_final !!}"
                                                                   name="received_price" class="form-control"
                                                                   aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">đ</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="submit"
                                                                class="btn btn-success btn-sm mt-15"><i
                                                                class="bi bi-coin me-1"></i>
                                                            Xác nhận thanh toán
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="expect_status" value="3">
                                        </form>
                                    </div>
                                @elseif($order->status == 3)
                                    <div class="change-status-wrapper">
                                        <i class="__icon bi bi-check-lg"></i>
                                        <span class="__text">Số tiền: <span
                                                class="text-lowercase">
                                                {!! number_format(($order->received_price), 0, '', ',') !!} đ
                                            </span>   đã được thanh toán</span>
                                    </div>
                                @endif
                            @endif
                            {{--End COD--}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body pt-25-i pb-10-i">
                            <h6 class="fw-bold">Khách hàng</h6>
                            <p class="mb-10-i">{!! $order->address->name !!}</p>
                            @if(isset($order->address->email))
                                <a href="mailto:{!!$order->address->email!!}">{!! $order->address->email !!}</a>
                            @endif
                            <hr>
                            <h6 class="fw-bold">Địa chỉ giao hàng</h6>
                            <p class="mb-10-i">{!! $order->address->name !!}</p>
                            <p class="mb-10-i">
                                <a href="tel:{!!$order->address->phone!!}">{!! $order->address->phone !!}</a>
                            </p>
                            <p class="mb-10-i">{!! $order->address->address !!}</p>
                            <p class="mb-10-i">{!! $order->address->ward_name !!}</p>
                            <p class="mb-10-i">{!! $order->address->district_name !!}</p>
                            <p class="mb-10-i">{!! $order->address->province_name !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
