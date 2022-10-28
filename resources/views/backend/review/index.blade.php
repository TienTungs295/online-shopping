@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>Đánh giá</h4>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                            <form method="GET" action="{!! route('reviewView') !!}" class="row g-3">
                                <div class="col-md-4">
                                    {{--                                <div class="input-group mb-3">--}}
                                    {{--                                    <input type="text" name="q" class="form-control" placeholder="Tên" aria-label="Tên"--}}
                                    {{--                                           aria-describedby="basic-addon2" value="{!! isset($q) ? $q : '' !!}">--}}
                                    {{--                                    <div class="input-group-append">--}}
                                    {{--                                        <button class="btn btn-outline-primary" type="submit">Tìm kiếm</button>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </div>--}}
                                </div>
                                <div class="col-md-8 text-end">
                                    <a href="{!! route('reviewView') !!}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-arrow-repeat me-1"></i> Làm mới
                                    </a>
                                </div>
                            </form>

                            <table class="table table-hover table-bordered text-center mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày cập nhật</th>
                                    <th scope="col">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$reviews->isEmpty())
                                    @foreach($reviews as $data)
                                        <tr>
                                            <th scope="row">{!!$data->id!!}</th>
                                            <td>
                                                @if($data->product != null)
                                                    {!!$data->product->name!!}
                                                @else
                                                    <div class="bg-danger">Sản phẩm không tồn tại</div>
                                                @endif
                                            </td>
                                            <td>{!!$data->comment!!}</td>
                                            <td>
                                                @if($data->status == 1)
                                                    <div class="bg-warning">Đang chờ</div>
                                                @else
                                                    <div class="bg-info">Đã xác nhận</div>
                                                @endif
                                            </td>
                                            <td>{!!$data->updated_at->format('H:i:s d-m-Y')!!}</td>
                                            <td>
                                                <form action="{!! route('changeReviewStatus',['id' => $data->id]) !!}"
                                                      class="d-inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm text-white" title="Xác nhận"
                                                            onclick="return confirm('Bạn có chắc chắn cho hành động này không?')">
                                                        <i class="bi bi-check2-circle me-1"></i>
                                                    </button>
                                                </form>

                                                <form action="{!! route('deleteReview',['id' => $data->id]) !!}"
                                                      class="d-inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                                            onclick="return confirm('Bạn có chắc chắn cho hành động này không?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">Không có dữ liệu</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="d-flex justify-content-end">
                                {!! $reviews->links() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    @include('backend.errors.alert')
@endsection
