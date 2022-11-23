<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item {{ (request()->is('quan-tri')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("homeView") !!}">
                <i class="bi bi-house-door"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/don-hang*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("orderView") !!}">
                <i class="bi bi-cart"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/danh-muc*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("categoryView") !!}">
                <i class="bi bi-list-ul"></i>
                <span>Danh mục</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/bo-suu-tap*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("collectionView") !!}">
                <i class="bi bi-collection"></i>
                <span>Bộ sưu tập</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/san-pham*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("productView") !!}">
                <i class="bi bi-x-diamond-fill"></i>
                <span>Sản phẩm</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/bai-viet*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("blogView") !!}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Bài viết</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('quan-tri/nhan-san-pham*')) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{!! route("labelView") !!}">
                <i class="bi bi-tags"></i>
                <span>Nhãn</span>
            </a>
        </li>
        @if((auth()->user()->role & 2) > 0)
            <li class="nav-item {{ (request()->is('quan-tri/khach-hang*')) ? 'active' : '' }}">
                <a class="nav-link collapsed" href="{!! route("customerAccountView") !!}">
                    <i class="bi bi-people-fill"></i>
                    <span>Khách hàng</span>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('quan-tri/nhan-vien*')) ? 'active' : '' }}">
                <a class="nav-link collapsed" href="{!! route("userView") !!}">
                    <i class="bi bi-person-bounding-box"></i>
                    <span>Nhân viên</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
