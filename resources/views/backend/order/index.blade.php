@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>Đơn đặt hàng</h4>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                            <form method="GET" action="{!! route('orderView') !!}" class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="text" name="q" class="form-control" placeholder="Tên"
                                               aria-label="Tên"
                                               aria-describedby="basic-addon2" value="{!! isset($q) ? $q : '' !!}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 text-end">
                                    <a href="{!! route('orderView') !!}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-arrow-repeat me-1"></i> Làm mới
                                    </a>
                                </div>
                            </form>

                            <table class="table table-hover table-bordered text-center mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên khác hàng</th>
                                    <th scope="col">Thành tiền</th>
                                    <th scope="col">Phương thức thanh toán</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày cập nhật</th>
                                    <th scope="col">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$orders->isEmpty())
                                    @foreach($orders as $data)
                                        <tr>
                                            <th scope="row">{!!$data->id!!}</th>
                                            <td>{!!$data->address->name!!}</td>
                                            <td>{!!$data->sub_total_with_shipping_format!!}</td>
                                            <td>
                                                @if($data->payment_method == 1)
                                                    Chuyển khoản
                                                @else
                                                    COD
                                                @endif
                                            </td>
                                            <td>
                                                @if($data->status == 1)
                                                    <div class="bg-warning">Đang chờ</div>
                                                @elseif($data->status == 2)
                                                    <div class="bg-info">Đã xác nhận</div>
                                                @elseif($data->status == 3)
                                                    <div class="bg-success text-light">Đã thanh toán</div>
                                                @elseif($data->status == 4)
                                                    <div class="bg-primary text-light">Đã giao hàng</div>
                                                @endif
                                            </td>
                                            <td>{!!$data->updated_at->format('H:i:s d-m-Y')!!}</td>
                                            <td>
                                                <a href="{!! route('updateOrderView',['id' => $data->id]) !!}"
                                                   class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{!! route('deleteOrder',['id' => $data->id]) !!}"
                                                      class="d-inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn cho hành động này không?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">Không có dữ liệu</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="d-flex justify-content-end">
                                {!! $orders->links() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    @include('backend.errors.alert')
@endsection
