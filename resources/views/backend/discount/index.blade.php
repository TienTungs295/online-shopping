@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>Mã giảm giá</h4>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                            <form method="GET" action="{!! route('discountView') !!}" class="row g-3">
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
                                    <a href="{!! route('createDiscountView') !!}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-plus-lg me-1"></i> Thêm
                                        mới
                                    </a>
                                    <a href="{!! route('discountView') !!}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-arrow-repeat me-1"></i> Làm mới
                                    </a>
                                </div>
                            </form>

                            <table class="table table-hover table-bordered text-center mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Đã sử dụng</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>
                                    <th scope="col">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$discounts->isEmpty())
                                    @foreach($discounts as $data)
                                        <tr>
                                            <th scope="row">{!!$data->id!!}</th>
                                            <td>{!!$data->code!!}</td>
                                            <td class="text-left">
                                                Giảm giá {!!$data->value!!}
                                                @if($data->type_option == "amount") VNĐ
                                                @else %
                                                @endif
                                                cho
                                                @if($data->target == 'all-orders') toàn bộ đơn hàng
                                                @else các sản phẩm:
                                                abc, xzy
                                                @endif
                                                @if($data->discount_on == 'per-order')
                                                    (Một lần cho mỗi đơn đặt hàng)
                                                @elseif($data->discount_on == 'per-every-item')
                                                    (Một lần cho mỗi sản phẩm trong giỏ)
                                                @endif
                                            </td>
                                            <td>{!!$data->total_used!!}</td>
                                            <td>{!!  date('d-m-Y', strtotime($data->start_date))!!}</td>
                                            <td>{!!  isset($data->end_date) ? date('d-m-Y', strtotime($data->end_date)) : "-"!!}</td>
                                            <td>
                                                <form action="{!! route('deleteDiscount',['id' => $data->id]) !!}"
                                                      class="d-inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa nhãn này không?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Không có dữ liệu</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="d-flex justify-content-end">
                                {!! $discounts->links() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    @include('backend.errors.alert')
@endsection
