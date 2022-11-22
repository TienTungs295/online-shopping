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
            <a class="nav-link collapsed" href="{!! route("orderView") !!}">
                <i class="bi bi-cart-check-fill"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("categoryView") !!}">
                <i class="bi bi-list-ul"></i>
                <span>Danh mục</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("collectionView") !!}">
                <i class="bi bi-collection"></i>
                <span>Bộ sưu tập</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("productView") !!}">
                <i class="bi bi-shop"></i>
                <span>Sản phẩm</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("blogView") !!}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Bài viết</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route("labelView") !!}">
                <i class="bi bi-tags"></i>
                <span>Nhãn</span>
            </a>
        </li>
        @if((auth()->user()->role & 2) > 0)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{!! route("userView") !!}">
                    <i class="bi bi-person-bounding-box"></i>
                    <span>Nhân viên</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
