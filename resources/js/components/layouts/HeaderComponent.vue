<template>
    <div>
        <!-- Home Popup Section -->
        <!--       <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">-->
        <!--           <div class="modal-dialog modal-lg modal-dialog-centered" role="document">-->
        <!--               <div class="modal-content">-->
        <!--                   <div class="modal-body">-->
        <!--                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
        <!--                           <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>-->
        <!--                       </button>-->
        <!--                       <div class="row no-gutters">-->
        <!--                           <div class="col-sm-5">-->
        <!--                               <div class="background_bg h-100" data-img-src="assets/images/popup_img.jpg"></div>-->
        <!--                           </div>-->
        <!--                           <div class="col-sm-7">-->
        <!--                               <div class="popup_content">-->
        <!--                                   <div class="popup-text">-->
        <!--                                       <div class="heading_s4">-->
        <!--                                           <h4>Subscribe and Get 25% Discount!</h4>-->
        <!--                                       </div>-->
        <!--                                       <p>Subscribe to the newsletter to receive updates about new products.</p>-->
        <!--                                   </div>-->
        <!--                                   <form method="post">-->
        <!--                                       <div class="form-group">-->
        <!--                                           <input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email">-->
        <!--                                       </div>-->
        <!--                                       <div class="form-group">-->
        <!--                                           <button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Subscribe</button>-->
        <!--                                       </div>-->
        <!--                                   </form>-->
        <!--                                   <div class="chek-form">-->
        <!--                                       <div class="custome-checkbox">-->
        <!--                                           <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">-->
        <!--                                           <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>-->
        <!--                                       </div>-->
        <!--                                   </div>-->
        <!--                               </div>-->
        <!--                           </div>-->
        <!--                       </div>-->
        <!--                   </div>-->
        <!--               </div>-->
        <!--           </div>-->
        <!--       </div>-->
        <!-- End Screen Load Popup Section -->

        <!-- START HEADER -->
        <header class="header_wrap">
            <div class="top-header d-none d-md-block">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="header_topbar_info">
                                <div class="header_offer">
                                    <span>Free Ground Shipping Over $250</span>
                                </div>
                                <div class="download_wrap">
                                    <span class="mr-3">Download App</span>
                                    <ul class="icon_list text-center text-lg-left">
                                        <li><a href="#"><i class="fab fa-apple"></i></a></li>
                                        <li><a href="#"><i class="fab fa-android"></i></a></li>
                                        <li><a href="#"><i class="fab fa-windows"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                <div class="lng_dropdown">
                                    <select name="countries" class="custome_select">
                                        <option value='en' data-image="assets/images/eng.png" data-title="English">
                                            English
                                        </option>
                                        <option value='fn' data-image="assets/images/fn.png" data-title="France">
                                            France
                                        </option>
                                        <option value='us' data-image="assets/images/us.png" data-title="United States">
                                            United States
                                        </option>
                                    </select>
                                </div>
                                <div class="ml-3">
                                    <select name="countries" class="custome_select">
                                        <option value='USD' data-title="USD">USD</option>
                                        <option value='EUR' data-title="EUR">EUR</option>
                                        <option value='GBR' data-title="GBR">GBR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="middle-header dark_skin">
                <div class="container">
                    <div class="nav_block">
                        <a class="navbar-brand" href="index.html">
                            <img class="logo_light" src="assets/images/logo_light.png" alt="logo"/>
                            <img class="logo_dark" src="assets/images/logo_dark.png" alt="logo"/>
                        </a>
                        <div class="contact_phone order-md-last">
                            <i class="linearicons-phone-wave"></i>
                            <span>123-456-7689</span>
                        </div>
                        <div class="product_search_form">
                            <form>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="custom_select">
                                            <select class="first_null">
                                                <option value="">All Category</option>
                                                <option value="Dresses">Dresses</option>
                                                <option value="Shirt-Tops">Shirt & Tops</option>
                                                <option value="T-Shirt">T-Shirt</option>
                                                <option value="Pents">Pents</option>
                                                <option value="Jeans">Jeans</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input class="form-control" placeholder="Search Product..." required="" type="text">
                                    <button type="submit" class="search_btn"><i class="linearicons-magnifier"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom_header light_skin main_menu_uppercase bg_dark mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                            <div class="categories_wrap">
                                <button type="button" data-toggle="collapse" data-target="#navCatContent"
                                        aria-expanded="false" class="categories_btn">
                                    <i class="linearicons-menu"></i><span>All Categories </span>
                                </button>
                                <div id="navCatContent" class="nav_cat navbar collapse">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="#"
                                               v-for="item in categories">
                                            <i class="flaticon-jacket"></i> <span>{{ item.name }}</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                            <nav class="navbar navbar-expand-lg">
                                <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSidetoggle" aria-expanded="false">
                                    <span class="ion-android-menu"></span>
                                </button>
                                <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                                    <ul class="navbar-nav">
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Home</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="index.html">Fashion
                                                        1</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item active"
                                                           href="index-2.html">Fashion 2</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="index-3.html">Furniture
                                                        1</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="index-4.html">Furniture
                                                        2</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="index-5.html">Electronics
                                                        1</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="index-6.html">Electronics
                                                        2</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle nav-link" href="#"
                                               data-toggle="dropdown">Pages</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="about.html">About
                                                        Us</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="contact.html">Contact
                                                        Us</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                           href="faq.html">Faq</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="404.html">404
                                                        Error Page</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="login.html">Login</a>
                                                    </li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="signup.html">Register</a>
                                                    </li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                           href="term-condition.html">Terms and Conditions</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="dropdown dropdown-mega-menu">
                                            <a class="dropdown-toggle nav-link" href="#"
                                               data-toggle="dropdown">Products</a>
                                            <div class="dropdown-menu">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-3">
                                                        <ul>
                                                            <li class="dropdown-header">Woman's</li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-three-columns.html">Vestibulum sed</a>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-four-columns.html">Donec porttitor</a>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-grid-view.html">Donec vitae facilisis</a>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-list-view.html">Curabitur tempus</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-left-sidebar.html">Vivamus in tortor</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-3">
                                                        <ul>
                                                            <li class="dropdown-header">Men's</li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-cart.html">Donec vitae ante ante</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="checkout.html">Etiam ac rutrum</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="wishlist.html">Quisque condimentum</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="compare.html">Curabitur laoreet</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="order-completed.html">Vivamus in tortor</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-3">
                                                        <ul>
                                                            <li class="dropdown-header">Kid's</li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail.html">Donec vitae
                                                                facilisis</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-left-sidebar.html">Quisque
                                                                condimentum</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-right-sidebar.html">Etiam
                                                                ac rutrum</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-thumbnails-left.html">Donec
                                                                vitae ante ante</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-accordion-style.html">Donec
                                                                porttitor</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-3">
                                                        <ul>
                                                            <li class="dropdown-header">Accessories</li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail.html">Curabitur tempus</a>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-left-sidebar.html">Quisque
                                                                condimentum</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-right-sidebar.html">Vivamus
                                                                in tortor</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-thumbnails-left.html">Donec
                                                                vitae facilisis</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-product-detail-accordion-style.html">Donec
                                                                porttitor</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <div class="d-lg-flex menu_banners">
                                                    <div class="col-lg-6">
                                                        <div class="header-banner">
                                                            <img src="assets/images/menu_banner1.jpg"
                                                                 alt="menu_banner1">
                                                            <div class="banne_info">
                                                                <h6>10% Off</h6>
                                                                <h4>New Arrival</h4>
                                                                <a href="#">Shop now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="header-banner">
                                                            <img src="assets/images/menu_banner2.jpg"
                                                                 alt="menu_banner2">
                                                            <div class="banne_info">
                                                                <h6>15% Off</h6>
                                                                <h4>Men's Fashion</h4>
                                                                <a href="#">Shop now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Blog</a>
                                            <div class="dropdown-menu dropdown-reverse">
                                                <ul>
                                                    <li>
                                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">Grids</a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-three-columns.html">3 columns</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-four-columns.html">4 columns</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-left-sidebar.html">Left Sidebar</a>
                                                                </li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-right-sidebar.html">right Sidebar</a>
                                                                </li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-standard-left-sidebar.html">Standard
                                                                    Left Sidebar</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-standard-right-sidebar.html">Standard
                                                                    right Sidebar</a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-masonry-three-columns.html">3
                                                                    columns</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-masonry-four-columns.html">4
                                                                    columns</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-masonry-left-sidebar.html">Left
                                                                    Sidebar</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-masonry-right-sidebar.html">right
                                                                    Sidebar</a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">Single
                                                            Post</a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-single.html">Default</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-single-left-sidebar.html">left
                                                                    sidebar</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-single-slider.html">slider post</a>
                                                                </li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-single-video.html">video post</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-single-audio.html">audio post</a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-list-left-sidebar.html">left
                                                                    sidebar</a></li>
                                                                <li><a class="dropdown-item nav-link nav_item"
                                                                       href="blog-list-right-sidebar.html">right
                                                                    sidebar</a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="dropdown dropdown-mega-menu">
                                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Shop</a>
                                            <div class="dropdown-menu">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-9">
                                                        <ul class="d-lg-flex">
                                                            <li class="mega-menu-col col-lg-4">
                                                                <ul>
                                                                    <li class="dropdown-header">Shop Page Layout</li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-list.html">shop List view</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-list-left-sidebar.html">shop List
                                                                        Left Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-list-right-sidebar.html">shop List
                                                                        Right Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-left-sidebar.html">Left
                                                                        Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-right-sidebar.html">Right
                                                                        Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-load-more.html">Shop Load More</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="mega-menu-col col-lg-4">
                                                                <ul>
                                                                    <li class="dropdown-header">Other Pages</li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-cart.html">Cart</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="checkout.html">Checkout</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="my-account.html">My Account</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="wishlist.html">Wishlist</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="compare.html">compare</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="order-completed.html">Order
                                                                        Completed</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="mega-menu-col col-lg-4">
                                                                <ul>
                                                                    <li class="dropdown-header">Product Pages</li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-product-detail.html">Default</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-product-detail-left-sidebar.html">Left
                                                                        Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-product-detail-right-sidebar.html">Right
                                                                        Sidebar</a></li>
                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                           href="shop-product-detail-thumbnails-left.html">Thumbnails
                                                                        Left</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-3">
                                                        <div class="header_banner">
                                                            <div class="header_banner_content">
                                                                <div class="shop_banner">
                                                                    <div class="banner_img overlay_bg_40">
                                                                        <img src="assets/images/shop_banner2.jpg"
                                                                             alt="shop_banner2"/>
                                                                    </div>
                                                                    <div class="shop_bn_content">
                                                                        <h6 class="text-uppercase shop_subtitle">New
                                                                            Collection</h6>
                                                                        <h5 class="text-uppercase shop_title">Sale 30%
                                                                            Off</h5>
                                                                        <a href="#"
                                                                           class="btn btn-white rounded-0 btn-xs text-uppercase">Shop
                                                                            Now</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li><a class="nav-link nav_item" href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                                <ul class="navbar-nav attr-nav align-items-center">
                                    <li><a href="#" class="nav-link"><i class="linearicons-user"></i></a></li>
                                    <li><a href="#" class="nav-link"><i class="linearicons-heart"></i><span
                                        class="wishlist_count">0</span></a></li>
                                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#"
                                                                          data-toggle="dropdown"><i
                                        class="linearicons-cart"></i><span class="cart_count">2</span></a>
                                        <div class="cart_box dropdown-menu dropdown-menu-right">
                                            <ul class="cart_list">
                                                <li>
                                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                                    <a href="#"><img src="assets/images/cart_thamb1.jpg"
                                                                     alt="cart_thumb1">Variable product 001</a>
                                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span
                                                        class="price_symbole">$</span></span>78.00</span>
                                                </li>
                                                <li>
                                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                                    <a href="#"><img src="assets/images/cart_thamb2.jpg"
                                                                     alt="cart_thumb2">Ornare sed consequat</a>
                                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span
                                                        class="price_symbole">$</span></span>81.00</span>
                                                </li>
                                            </ul>
                                            <div class="cart_footer">
                                                <p class="cart_total"><strong>Subtotal:</strong> <span
                                                    class="cart_price"> <span class="price_symbole">$</span></span>159.00
                                                </p>
                                                <p class="cart_buttons"><a href="#" class="btn btn-fill-line view-cart">View
                                                    Cart</a><a href="#" class="btn btn-fill-out checkout">Checkout</a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="pr_search_icon">
                                    <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i
                                        class="linearicons-magnifier"></i></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER -->
    </div>
</template>

<script>
import CategoryService from "../../services/CategoryService";

export default {
    name: "Header",
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        CategoryService.findAll().then(response => {
            let data = response || [];
            this.categories = data;
        }).catch(e => {
        });
    }
}
</script>
