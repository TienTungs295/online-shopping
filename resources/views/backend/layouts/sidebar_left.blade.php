<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("homeView") !!}">
                <i class="bi bi-tags"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("labelView") !!}">
                <i class="bi bi-tags"></i>
                <span>Nhãn</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("collectionView") !!}">
                <i class="bi bi-tags"></i>
                <span>Bộ sưu tập</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("flashSaleView") !!}">
                <i class="bi bi-tags"></i>
                <span>Flash Sale</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("discountView") !!}">
                <i class="bi bi-tags"></i>
                <span>Mã giảm giá</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("categoryView") !!}">
                <i class="bi bi-tags"></i>
                <span>Danh mục</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("blogView") !!}">
                <i class="bi bi-tags"></i>
                <span>Bài viết</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("productView") !!}">
                <i class="bi bi-tags"></i>
                <span>Sản phẩm</span>
            </a>
        </li>
        @if((auth()->user()->role & 2) > 0)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{!! route("userView") !!}">
                    <i class="bi bi-tags"></i>
                    <span>Nhân viên</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
