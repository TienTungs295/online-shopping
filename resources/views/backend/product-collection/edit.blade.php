@extends('backend.layouts.master')
@section('content')
    <div class="main-inner">
        <div class="pagetitle">
            <h4>
                @if(isset($product_collection))
                    Cập nhật bộ sưu tập
                @else
                    Thêm mới bộ sưu tập
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
                                  action="{!! isset($product_collection)? route('updateCollection',['id' => $product_collection->id]) : route('createCollection') !!}">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tên bộ sưu tập<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               value="{!! old('name', isset($product_collection->name) ? $product_collection->name : '')!!}"
                                               class="form-control" name="name" maxlength="255" required
                                               placeholder="Tên bộ sưu tập">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Độ ưu tiên</label>
                                    <div class="col-sm-10">
                                        <input type="number"
                                               value="{!! old('priority', isset($product_collection->priority) ? $product_collection->priority : '')!!}"
                                               class="form-control" name="priority" min="0"
                                               placeholder="Độ ưu tiên">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save2 me-1"></i>
                                        @if(isset($product_collection))
                                            Cập nhật
                                        @else
                                            Thêm mới
                                        @endif
                                    </button>
                                    <a class="btn btn-danger" href="{!! route('collectionView') !!}">
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
