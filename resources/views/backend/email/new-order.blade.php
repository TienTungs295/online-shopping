<div id="wrap-inner" class="col-md-9">
    <div class="row list-product">
        <div class="col-md-12">
            <div>Xin chào {{$order_information->name}}, bạn có 1 hóa đơn mua hàng từ website <a href="3mnk.vn">3mnk.vn</a>
            </div>
            <div class="clearfix"></div>
            <h3>Thông tin khách hàng</h3>
            <p>
                <span class="info">Khách hàng: {{$order_information->name}}</span>
            </p>
            <p>
                <span class="info">Email: {{$order_information->email}} </span>
            </p>
            <p>
                <span class="info">Điện thoại: {{$order_information->phone}} </span>
            </p>
            <p>
                <span class="info">Địa chỉ:
                    {{$order_information->address}},
                    {{$order_information->ward_name}},
                    {{$order_information->district_name}},
                    {{$order_information->province_name}},
                </span>
            </p>
        </div>
        <div class="col-md-12">
            <div class="clearfix"></div>
            <h3>Hóa đơn mua hàng</h3>
            <table border="1" cellpadding="10" cellspacing="0" style="margin-bottom: 20px">
                <tr>
                    <td>Tên sản phẩm</td>
                    <td>Giá</td>
                    <td>Số lượng</td>
                </tr>
                @foreach($cart as $item)
                    <tr>
                        <td>{{$item->product_name}}</td>
                        <td>
                            {!! number_format($item->price,0,",",".") !!} đ
                        </td>
                        <td>{{$item->qty}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" style="border-right: 0">Tạm tính: </td>
                    <td style="border-left: 0">{!! number_format($order->sub_total,0,",",".") !!} đ</td>
                </tr>
                @if($order->discount_value != null)
                    <tr>
                        <td colspan="2" style="border-right: 0" >Mã giảm giá:</td>
                        <td style="border-left: 0">{!! $order->coupon_code !!} </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-right: 0">Khấu trừ:</td>
                        <td style="border-left: 0">-{!! number_format($order->discount_value,0,",",".") !!} đ</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2" style="border-right: 0">Phí vận chuyển:</td>
                    <td style="border-left: 0">{!! number_format($order->shipping_fee,0,",",".") !!} đ</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-right: 0">Thành tiền:</td>
                    <td style="border-left: 0" style="font-size: 18px;font-weight: bold">{!! number_format($order->sub_total_final,0,",",".") !!}
                        đ
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-bottom: 10px">Mọi thắc mắc xin liên hệ bộ phận hỗ trợ công ty 3M Nhập khẩu với số điện thoại: <a
                href="tel:0979945555">0979945555</a></div>
        <div>Xin chân thành cảm ơn!</div>
    </div>
</div>
