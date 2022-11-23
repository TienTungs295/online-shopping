<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{!! route('homeView') !!}" class="logo d-flex align-items-center">
            {{--            <img src="assets/img/logo.png" alt="">--}}
            <span class="d-none d-lg-block">Quản trị 3MNK</span>
        </a>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="{!! route("orderView") !!}">
                    <i class="bi bi-cart"></i>
                    <span class="badge bg-primary badge-number" id="total-order">0</span>
                </a><!-- End Notification Icon -->
            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="{!! route("reviewView") !!}">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number" id="total-review">0</span>
                </a><!-- End Messages Icon -->

            </li><!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{--                    <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">--}}
                    <span class="d-none d-md-block dropdown-toggle ps-2">{!! auth()->user()->name !!}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{!! auth()->user()->name !!}</h6>
                        <span>
                              @if(auth()->user()->role == 7)
                                Quản trị viên cấp cao
                            @elseif(auth()->user()->role == 3)
                                Quản trị viên
                            @elseif(auth()->user()->role == 1)
                                Nhân viên
                            @endif
                        </span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                            <i class="bi bi-person"></i>
                            <span>Thông tin cá nhân</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li style="cursor: pointer;">
                        <form method="POST" action="{{ route('logout') }}" id="user-logout">
                            @csrf
                        </form>
                        <p class="dropdown-item d-flex align-items-center" href="#"
                           onclick="document.getElementById('user-logout').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Đăng xuất</span>
                        </p>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
