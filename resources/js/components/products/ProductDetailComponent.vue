<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chi tiết sản phẩm</h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item">
                                <router-link
                                    :to="{ name: 'home'}">
                                    Trang chủ
                                </router-link>
                            </li>
                            <li v-if="product.category" class="breadcrumb-item"><a href="#">{{product.category.name}}</a></li>
                            <li class="breadcrumb-item active">{{ product.name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content" v-if="!isLoading">
            <!-- START SECTION SHOP -->
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                            <div class="product-image">
                                <div class="product_img_box">
                                    <img id="product_img" :src="'/uploads/images/'+product.image" :alt="product.image"
                                         :data-zoom-image="'/uploads/images/'+product.image"/>
                                    <a href="#" class="product_img_zoom" title="Zoom">
                                        <span class="linearicons-zoom-in"></span>
                                    </a>
                                </div>
                                <div id="pr_item_gallery" class="product_gallery_item slick_slider"
                                     data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                                    <div class="item" v-for="item in product.images">
                                        <a href="#" class="product_gallery_item"
                                           :data-image="'/uploads/images/'+product.image"
                                           :data-zoom-image="'/uploads/images/'+product.image">
                                            <img :src="'/uploads/images/'+item.image" :alt="item.image"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="pr_detail">
                                <div class="product_description">
                                    <h4 class="product_title"><a href="#">{{ product.name }}</a></h4>
                                    <div class="product_price">
                                        <div v-if="product.on_sale">
                                            <span class="price">{{ product.sale_price }}</span>
                                            <del>{{ product.price }}</del>
                                            <div class="on_sale" v-if="product.sale_off != null">
                                                <span>{{ product.sale_off }}% Off</span>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <span class="price">{{ product.price }}</span>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width:80%"></div>
                                        </div>
                                        <span class="rating_num">(21)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>{{ product.description }}</p>
                                    </div>
                                </div>
                                <hr/>
                                <div class="cart_extra">
                                    <div>
                                        <div class="cart-product-quantity">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus">
                                                <input type="text" name="quantity" value="1" title="Qty" class="qty"
                                                       size="4">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="cart_btn mgb-10">
                                            <button class="btn btn-fill-out btn-addtocart" type="button"><i
                                                class="icon-basket-loaded"></i> Thêm vào giỏ
                                            </button>
                                            <button class="btn btn-fill-line view-cart" type="button"><i
                                                class="icon-basket-loaded"></i> Mua ngay
                                            </button>
                                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <ul class="product-meta">
                                    <li>Mã sản phẩm: <span>{{ product.sku }}</span></li>
                                    <li v-if="product.category">Danh mục: <a href="#">{{product.category.name}}</a></li>
                                </ul>

                                <div class="product_share">
                                    <span>Chia sẻ:</span>
                                    <ul class="social_icons">
                                        <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                        <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="large_divider clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-style3">
                                <b-tabs content-class="mt-3">
                                    <b-tab title="Description" active> <p v-html="product.description"></p></b-tab>
                                    <b-tab title="Reviews (2)">
                                        <div class="comments">
                                        <h5 class="product_tab_title">2 Review For <span>Blue Dress For Woman</span>
                                        </h5>
                                        <ul class="list_none comment_list mt-4">
                                            <li>
                                                <div class="comment_img">
                                                    <img src="assets/images/user1.jpg" alt="user1"/>
                                                </div>
                                                <div class="comment_block">
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:80%"></div>
                                                        </div>
                                                    </div>
                                                    <p class="customer_meta">
                                                        <span class="review_author">Alea Brooks</span>
                                                        <span class="comment-date">March 5, 2018</span>
                                                    </p>
                                                    <div class="description">
                                                        <p>Lorem Ipsumin gravida nibh vel velit auctor aliquet.
                                                            Aenean sollicitudin, lorem quis bibendum auctor, nisi
                                                            elit consequat ipsum, nec sagittis sem nibh id elit.
                                                            Duis sed odio sit amet nibh vulputate</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="comment_img">
                                                    <img src="assets/images/user2.jpg" alt="user2"/>
                                                </div>
                                                <div class="comment_block">
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:60%"></div>
                                                        </div>
                                                    </div>
                                                    <p class="customer_meta">
                                                        <span class="review_author">Grace Wong</span>
                                                        <span class="comment-date">June 17, 2018</span>
                                                    </p>
                                                    <div class="description">
                                                        <p>It is a long established fact that a reader will be
                                                            distracted by the readable content of a page when
                                                            looking at its layout. The point of using Lorem Ipsum is
                                                            that it has a more-or-less normal distribution of
                                                            letters</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                        <div class="review_form field_form">
                                            <h5>Add a review</h5>
                                            <form class="row mt-3">
                                                <div class="form-group col-12">
                                                    <div class="star_rating">
                                                        <span data-value="1"><i class="far fa-star"></i></span>
                                                        <span data-value="2"><i class="far fa-star"></i></span>
                                                        <span data-value="3"><i class="far fa-star"></i></span>
                                                        <span data-value="4"><i class="far fa-star"></i></span>
                                                        <span data-value="5"><i class="far fa-star"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <textarea required="required" placeholder="Your review *"
                                                              class="form-control" name="message" rows="4"></textarea>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input required="required" placeholder="Enter Name *"
                                                           class="form-control" name="name" type="text">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input required="required" placeholder="Enter Email *"
                                                           class="form-control" name="email" type="email">
                                                </div>

                                                <div class="form-group col-12">
                                                    <button type="submit" class="btn btn-fill-out" name="submit"
                                                            value="Submit">Submit Review
                                                    </button>
                                                </div>
                                            </form>
                                        </div></b-tab>
                                </b-tabs>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="small_divider"></div>
                            <div class="divider"></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_s1">
                                <h3>Sản phẩm liên quan</h3>
                            </div>
                            <div v-if="!isLoading"
                                 class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20"
                                 v-carousel
                                 data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                <div class="item" v-for="item in product.related_products" v-if="product.related_products != undefined && product.related_products.length">
                                    <div class="product">
                                        <div class="product_img style-1">
                                            <a href="#">
                                                <img :src="'/uploads/images/'+item.image" :alt="item.image">
                                            </a>
                                            <div class="product_action_box">
                                                <ul class="list_none pr_action_btn">
                                                    <li class="add-to-cart"><a href="#"><i
                                                        class="icon-basket-loaded"></i>Thêm vào giỏ </a>
                                                    </li>
                                                    <li><a href="shop-compare.html"
                                                           class="popup-ajax"><i
                                                        class="icon-shuffle"></i></a></li>
                                                    <li><a href="shop-quick-view.html"
                                                           class="popup-ajax"><i
                                                        class="icon-magnifier-add"></i></a></li>
                                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title">
                                                <router-link
                                                    :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                    {{ item.name }}
                                                </router-link>
                                            </h6>
                                            <div class="product_price">
                                                <div v-if="item.on_sale">
                                                    <span class="price">{{ item.sale_price }}</span>
                                                    <del>{{ item.price }}</del>
                                                    <div class="on_sale" v-if="item.sale_off != null">
                                                        <span>{{ item.sale_off }}% Off</span>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <span class="price">{{ item.price }}</span>
                                                </div>

                                            </div>
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:80%"></div>
                                                </div>
                                                <span class="rating_num">(21)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION SHOP -->
        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>
import ProductService from "../../services/ProductService";

export default {
    name: "ProductDetail",
    data() {
        return {
            product: {},
            isLoading: true,
        };
    },
    methods: {
        initZoomImage:function (){
            /*===================================
  Author       : Bestwebcreator.
  Template Name: Shopwise - eCommerce Bootstrap 4 HTML Template
  Version      : 1.3
  ===================================*/

            /*===================================*
            PAGE JS
            *===================================*/

                /*===================================*
                01. LOADING JS
                /*===================================*/
                $(window).on('load', function() {
                    setTimeout(function () {
                        $(".preloader").delay(700).fadeOut(700).addClass('loaded');
                    }, 800);
                });

                /*===================================*
                02. BACKGROUND IMAGE JS
                *===================================*/
                /*data image src*/
                $(".background_bg").each(function() {
                    var attr = $(this).attr('data-img-src');
                    if (typeof attr !== typeof undefined && attr !== false) {
                        $(this).css('background-image', 'url(' + attr + ')');
                    }
                });

                /*===================================*
                03. ANIMATION JS
                *===================================*/
                $(function() {

                    function ckScrollInit(items, trigger) {
                        items.each(function() {
                            var ckElement = $(this),
                                AnimationClass = ckElement.attr('data-animation'),
                                AnimationDelay = ckElement.attr('data-animation-delay');

                            ckElement.css({
                                '-webkit-animation-delay': AnimationDelay,
                                '-moz-animation-delay': AnimationDelay,
                                'animation-delay': AnimationDelay,
                                opacity: 0
                            });

                            var ckTrigger = (trigger) ? trigger : ckElement;

                            ckTrigger.waypoint(function() {
                                ckElement.addClass("animated").css("opacity", "1");
                                ckElement.addClass('animated').addClass(AnimationClass);
                            }, {
                                triggerOnce: true,
                                offset: '90%',
                            });
                        });
                    }

                    ckScrollInit($('.animation'));
                    ckScrollInit($('.staggered-animation'), $('.staggered-animation-wrap'));

                });

                /*===================================*
                04. MENU JS
                *===================================*/
                //Main navigation scroll spy for shadow
                $(window).on('scroll', function() {
                    var scroll = $(window).scrollTop();

                    if (scroll >= 150) {
                        $('header.fixed-top').addClass('nav-fixed');
                    } else {
                        $('header.fixed-top').removeClass('nav-fixed');
                    }

                });

                //Show Hide dropdown-menu Main navigation
                $(document).ready(function () {
                    $( '.dropdown-menu a.dropdown-toggler' ).on( 'click', function () {
                        //var $el = $( this );
                        //var $parent = $( this ).offsetParent( ".dropdown-menu" );
                        if ( !$( this ).next().hasClass( 'show' ) ) {
                            $( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
                        }
                        var $subMenu = $( this ).next( ".dropdown-menu" );
                        $subMenu.toggleClass( 'show' );

                        $( this ).parent( "li" ).toggleClass( 'show' );

                        $( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function () {
                            $( '.dropdown-menu .show' ).removeClass( "show" );
                        } );

                        return false;
                    });
                });

                //Hide Navbar Dropdown After Click On Links
                var navBar = $(".header_wrap");
                var navbarLinks = navBar.find(".navbar-collapse ul li a.page-scroll");

                $.each( navbarLinks, function() {

                    var navbarLink = $(this);

                    navbarLink.on('click', function () {
                        navBar.find(".navbar-collapse").collapse('hide');
                        $("header").removeClass("active");
                    });

                });

                //Main navigation Active Class Add Remove
                $('.navbar-toggler').on('click', function() {
                    $("header").toggleClass("active");
                    if($('.search-overlay').hasClass('open'))
                    {
                        $(".search-overlay").removeClass('open');
                        $(".search_trigger").removeClass('open');
                    }
                });

                $(document).ready(function () {
                    if ($('.header_wrap').hasClass("fixed-top") && !$('.header_wrap').hasClass("transparent_header") && !$('.header_wrap').hasClass("no-sticky")) {
                        $(".header_wrap").before('<div class="header_sticky_bar d-none"></div>');
                    }
                });

                $(window).on('scroll', function() {
                    var scroll = $(window).scrollTop();

                    if (scroll >= 150) {
                        $('.header_sticky_bar').removeClass('d-none');
                        $('header.no-sticky').removeClass('nav-fixed');

                    } else {
                        $('.header_sticky_bar').addClass('d-none');
                    }

                });

                var setHeight = function() {
                    var height_header = $(".header_wrap").height();
                    $('.header_sticky_bar').css({'height':height_header});
                };

                $(window).on('load', function() {
                    setHeight();
                });

                $(window).on('resize', function() {
                    setHeight();
                });

                $('.sidetoggle').on('click', function () {
                    $(this).addClass('open');
                    $('body').addClass('sidetoggle_active');
                    $('.sidebar_menu').addClass('active');
                    $("body").append('<div id="header-overlay" class="header-overlay"></div>');
                });

                $(document).on('click', '#header-overlay, .sidemenu_close',function() {
                    $('.sidetoggle').removeClass('open');
                    $('body').removeClass('sidetoggle_active');
                    $('.sidebar_menu').removeClass('active');
                    $('#header-overlay').fadeOut('3000',function(){
                        $('#header-overlay').remove();
                    });
                    return false;
                });

                $(".categories_btn").on('click', function() {
                    $('.side_navbar_toggler').attr('aria-expanded', 'false');
                    $('#navbarSidetoggle').removeClass('show');
                });

                $(".side_navbar_toggler").on('click', function() {
                    $('.categories_btn').attr('aria-expanded', 'false');
                    $('#navCatContent').removeClass('show');
                });

                $(".pr_search_trigger").on('click', function() {
                    $(this).toggleClass('show');
                    $('.product_search_form').toggleClass('show');
                });

                var rclass = true;

                $("html").on('click', function () {
                    if (rclass) {
                        $('.categories_btn').addClass('collapsed');
                        $('.categories_btn,.side_navbar_toggler').attr('aria-expanded', 'false');
                        $('#navCatContent,#navbarSidetoggle').removeClass('show');
                    }
                    rclass = true;
                });

                $(".categories_btn,#navCatContent,#navbarSidetoggle .navbar-nav,.side_navbar_toggler").on('click', function() {
                    rclass = false;
                });

                /*===================================*
                05. SMOOTH SCROLLING JS
                *===================================*/
                // Select all links with hashes

                var topheaderHeight = $(".top-header").innerHeight();
                var mainheaderHeight = $(".header_wrap").innerHeight();
                var headerHeight = mainheaderHeight - topheaderHeight - 20;
                $('a.page-scroll[href*="#"]:not([href="#"])').on('click', function() {
                    $('a.page-scroll.active').removeClass('active');
                    $(this).closest('.page-scroll').addClass('active');
                    // On-page links
                    if ( location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname ) {
                        // Figure out element to scroll to
                        var target = $(this.hash),
                            speed= $(this).data("speed") || 800;
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                        // Does a scroll target exist?
                        if (target.length) {
                            // Only prevent default if animation is actually gonna happen
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: target.offset().top - headerHeight
                            }, speed);
                        }
                    }
                });
                $(window).on('scroll', function(){
                    var lastId,
                        // All list items
                        menuItems = $(".header_wrap").find("a.page-scroll"),
                        topMenuHeight = $(".header_wrap").innerHeight() + 20,
                        // Anchors corresponding to menu items
                        scrollItems = menuItems.map(function(){
                            var items = $($(this).attr("href"));
                            if (items.length) { return items; }
                        });
                    var fromTop = $(this).scrollTop()+topMenuHeight;

                    // Get id of current scroll item
                    var cur = scrollItems.map(function(){
                        if ($(this).offset().top < fromTop)
                            return this;
                    });
                    // Get the id of the current element
                    cur = cur[cur.length-1];
                    var id = cur && cur.length ? cur[0].id : "";

                    if (lastId !== id) {
                        lastId = id;
                        // Set/remove active class
                        menuItems.closest('.page-scroll').removeClass("active").end().filter("[href='#"+id+"']").closest('.page-scroll').addClass("active");
                    }

                });

                $('.more_slide_open').slideUp();
                $('.more_categories').on('click', function (){
                    $(this).toggleClass('show');
                    $('.more_slide_open').slideToggle();
                });

                /*===================================*
                06. SEARCH JS
                *===================================*/

                $(".close-search").on("click", function() {
                    $(".search_wrap,.search_overlay").removeClass('open');
                    $("body").removeClass('search_open');
                });

                var removeClass = true;
                $(".search_wrap").after('<div class="search_overlay"></div>');
                $(".search_trigger").on('click', function () {
                    $(".search_wrap,.search_overlay").toggleClass('open');
                    $("body").toggleClass('search_open');
                    removeClass = false;
                    if($('.navbar-collapse').hasClass('show'))
                    {
                        $(".navbar-collapse").removeClass('show');
                        $(".navbar-toggler").addClass('collapsed');
                        $(".navbar-toggler").attr("aria-expanded", false);
                    }
                });
                $(".search_wrap form").on('click', function() {
                    removeClass = false;
                });
                $("html").on('click', function () {
                    if (removeClass) {
                        $("body").removeClass('open');
                        $(".search_wrap,.search_overlay").removeClass('open');
                        $("body").removeClass('search_open');
                    }
                    removeClass = true;
                });

                /*===================================*
                07. SCROLLUP JS
                *===================================*/
                $(window).on('scroll', function() {
                    if ($(this).scrollTop() > 150) {
                        $('.scrollup').fadeIn();
                    } else {
                        $('.scrollup').fadeOut();
                    }
                });

                $(".scrollup").on('click', function (e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 600);
                    return false;
                });

                /*===================================*
                08. PARALLAX JS
                *===================================*/
                $(window).on('load', function() {
                    $('.parallax_bg').parallaxBackground();
                });

                /*===================================*
                09. MASONRY JS
                *===================================*/
                $( window ).on( "load", function() {
                    var $grid_selectors  = $(".grid_container");
                    var filter_selectors = ".grid_filter > li > a";
                    if( $grid_selectors.length > 0 ) {
                        $grid_selectors.imagesLoaded(function(){
                            if ($grid_selectors.hasClass("masonry")){
                                $grid_selectors.isotope({
                                    itemSelector: '.grid_item',
                                    percentPosition: true,
                                    layoutMode: "masonry",
                                    masonry: {
                                        columnWidth: '.grid-sizer'
                                    },
                                });
                            }
                            else {
                                $grid_selectors.isotope({
                                    itemSelector: '.grid_item',
                                    percentPosition: true,
                                    layoutMode: "fitRows",
                                });
                            }
                        });
                    }

                    //isotope filter
                    $(document).on( "click", filter_selectors, function() {
                        $(filter_selectors).removeClass("current");
                        $(this).addClass("current");
                        var dfselector = $(this).data('filter');
                        if ($grid_selectors.hasClass("masonry")){
                            $grid_selectors.isotope({
                                itemSelector: '.grid_item',
                                layoutMode: "masonry",
                                masonry: {
                                    columnWidth: '.grid_item'
                                },
                                filter: dfselector
                            });
                        }
                        else {
                            $grid_selectors.isotope({
                                itemSelector: '.grid_item',
                                layoutMode: "fitRows",
                                filter: dfselector
                            });
                        }
                        return false;
                    });

                    $('.portfolio_filter').on('change', function() {
                        $grid_selectors.isotope({
                            filter: this.value
                        });
                    });

                    $(window).on("resize", function () {
                        setTimeout(function () {
                            $grid_selectors.find('.grid_item').removeClass('animation').removeClass('animated'); // avoid problem to filter after window resize
                            $grid_selectors.isotope('layout');
                        }, 300);
                    });
                });

                $('.link_container').each(function () {
                    $(this).magnificPopup({
                        delegate: '.image_popup',
                        type: 'image',
                        mainClass: 'mfp-zoom-in',
                        removalDelay: 500,
                        gallery: {
                            enabled: true
                        }
                    });
                });

                /*===================================*
                10. SLIDER JS
                *===================================*/
                function carousel_slider() {
                    $('.carousel_slider').each( function() {
                        var $carousel = $(this);
                        $carousel.owlCarousel({
                            dots : $carousel.data("dots"),
                            loop : $carousel.data("loop"),
                            items: $carousel.data("items"),
                            margin: $carousel.data("margin"),
                            mouseDrag: $carousel.data("mouse-drag"),
                            touchDrag: $carousel.data("touch-drag"),
                            autoHeight: $carousel.data("autoheight"),
                            center: $carousel.data("center"),
                            nav: $carousel.data("nav"),
                            rewind: $carousel.data("rewind"),
                            navText: ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
                            autoplay : $carousel.data("autoplay"),
                            animateIn : $carousel.data("animate-in"),
                            animateOut: $carousel.data("animate-out"),
                            autoplayTimeout : $carousel.data("autoplay-timeout"),
                            smartSpeed: $carousel.data("smart-speed"),
                            responsive: $carousel.data("responsive")
                        });
                    });
                }

                function slick_slider() {
                    $('.slick_slider').each( function() {
                        var $slick_carousel = $(this);
                        $slick_carousel.slick({
                            arrows: $slick_carousel.data("arrows"),
                            dots: $slick_carousel.data("dots"),
                            infinite: $slick_carousel.data("infinite"),
                            centerMode: $slick_carousel.data("center-mode"),
                            vertical: $slick_carousel.data("vertical"),
                            fade: $slick_carousel.data("fade"),
                            cssEase: $slick_carousel.data("css-ease"),
                            autoplay: $slick_carousel.data("autoplay"),
                            verticalSwiping: $slick_carousel.data("vertical-swiping"),
                            autoplaySpeed: $slick_carousel.data("autoplay-speed"),
                            speed: $slick_carousel.data("speed"),
                            pauseOnHover: $slick_carousel.data("pause-on-hover"),
                            draggable: $slick_carousel.data("draggable"),
                            slidesToShow: $slick_carousel.data("slides-to-show"),
                            slidesToScroll: $slick_carousel.data("slides-to-scroll"),
                            asNavFor: $slick_carousel.data("as-nav-for"),
                            focusOnSelect: $slick_carousel.data("focus-on-select"),
                            responsive: $slick_carousel.data("responsive")
                        });
                    });
                }


                $(document).ready(function () {
                    carousel_slider();
                    slick_slider();
                });
                /*===================================*
                11. CONTACT FORM JS
                *===================================*/
                $("#submitButton").on("click", function(event) {
                    event.preventDefault();
                    var mydata = $("form").serialize();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "contact.php",
                        data: mydata,
                        success: function(data) {
                            if (data.type === "error") {
                                $("#alert-msg").removeClass("alert, alert-success");
                                $("#alert-msg").addClass("alert, alert-danger");
                            } else {
                                $("#alert-msg").addClass("alert, alert-success");
                                $("#alert-msg").removeClass("alert, alert-danger");
                                $("#first-name").val("Enter Name");
                                $("#email").val("Enter Email");
                                $("#phone").val("Enter Phone Number");
                                $("#subject").val("Enter Subject");
                                $("#description").val("Enter Message");

                            }
                            $("#alert-msg").html(data.msg);
                            $("#alert-msg").show();
                        },
                        error: function(xhr, textStatus) {
                            alert(textStatus);
                        }
                    });
                });

                /*===================================*
                12. POPUP JS
                *===================================*/
                $('.content-popup').magnificPopup({
                    type: 'inline',
                    preloader: true,
                    mainClass: 'mfp-zoom-in',
                });

                $('.image_gallery').each(function() { // the containers for all your galleries
                    $(this).magnificPopup({
                        delegate: 'a', // the selector for gallery item
                        type: 'image',
                        gallery: {
                            enabled: true,
                        },
                    });
                });

                $('.popup-ajax').magnificPopup({
                    type: 'ajax',
                    callbacks: {
                        ajaxContentAdded: function() {
                            carousel_slider();
                            slick_slider();
                        }
                    }
                });

                $('.video_popup, .iframe_popup').magnificPopup({
                    type: 'iframe',
                    removalDelay: 160,
                    mainClass: 'mfp-zoom-in',
                    preloader: false,
                    fixedContentPos: false
                });

                /*===================================*
                13. Select dropdowns
                *===================================*/

                if ($('select').length) {
                    // Traverse through all dropdowns
                    $.each($('select'), function (i, val) {
                        var $el = $(val);

                        if ($el.val()===""){
                            $el.addClass('first_null');
                        }

                        if (!$el.val()) {
                            $el.addClass('not_chosen');
                        }

                        $el.on('change', function () {
                            if (!$el.val())
                                $el.addClass('not_chosen');
                            else
                                $el.removeClass('not_chosen');
                        });

                    });
                }

                /*==============================================================
                14. FIT VIDEO JS
                ==============================================================*/
                if ($(".fit-videos").length > 0){
                    $(".fit-videos").fitVids({
                        customSelector: "iframe[src^='https://w.soundcloud.com']"
                    });
                }

                /*==============================================================
                15. DROPDOWN JS
                ==============================================================*/
                if ($(".custome_select").length > 0){
                    $(document).ready(function () {
                        $(".custome_select").msDropdown();
                    });
                }

                /*===================================*
                16.MAP JS
                *===================================*/
                if ($("#map").length > 0){
                    google.maps.event.addDomListener(window, 'load', init);
                }

                var map_selector = $('#map');
                function init() {

                    var mapOptions = {
                        zoom: map_selector.data("zoom"),
                        mapTypeControl: false,
                        center: new google.maps.LatLng(map_selector.data("latitude"), map_selector.data("longitude")), // New York
                    };
                    var mapElement = document.getElementById('map');
                    var map = new google.maps.Map(mapElement, mapOptions);
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(map_selector.data("latitude"), map_selector.data("longitude")),
                        map: map,
                        icon: map_selector.data("icon"),

                        title: map_selector.data("title"),
                    });
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }


                /*===================================*
                17. COUNTDOWN JS
                *===================================*/
                $('.countdown_time').each(function() {
                    var endTime = $(this).data('time');
                    $(this).countdown(endTime, function(tm) {
                        $(this).html(tm.strftime('<div class="countdown_box"><div class="countdown-wrap"><span class="countdown days">%D </span><span class="cd_text">Days</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown hours">%H</span><span class="cd_text">Hours</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown minutes">%M</span><span class="cd_text">Minutes</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown seconds">%S</span><span class="cd_text">Seconds</span></div></div>'));
                    });
                });

                /*===================================*
                18. List Grid JS
                *===================================*/
                $('.shorting_icon').on('click',function() {
                    if ($(this).hasClass('grid')) {
                        $('.shop_container').removeClass('list').addClass('grid');
                        $(this).addClass('active').siblings().removeClass('active');
                    }
                    else if($(this).hasClass('list')) {
                        $('.shop_container').removeClass('grid').addClass('list');
                        $(this).addClass('active').siblings().removeClass('active');
                    }
                    $(".shop_container").append('<div class="loading_pr"><div class="mfp-preloader"></div></div>');
                    setTimeout(function(){
                        $('.loading_pr').remove();
                        $container.isotope('layout');
                    }, 800);
                });

                /*===================================*
                19. TOOLTIP JS
                *===================================*/
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip({
                        trigger: 'hover',
                    });
                });
                $(function () {
                    $('[data-toggle="popover"]').popover();
                });

                /*===================================*
                20. PRODUCT COLOR JS
                *===================================*/
                $('.product_color_switch span').each(function() {
                    var get_color = $(this).attr('data-color');
                    $(this).css("background-color", get_color);
                });

                $('.product_color_switch span,.product_size_switch span').on("click", function() {
                    $(this).siblings(this).removeClass('active').end().addClass('active');
                });

                /*===================================*
                21. QUICKVIEW POPUP + ZOOM IMAGE + PRODUCT SLIDER JS
                *===================================*/
                var image = $('#product_img');
                //var zoomConfig = {};
                var zoomActive = false;

                zoomActive = !zoomActive;
                if(zoomActive) {
                    if ($(image).length > 0){
                        $(image).elevateZoom({
                            cursor: "crosshair",
                            easing : true,
                            gallery:'pr_item_gallery',
                            zoomType: "inner",
                            galleryActiveClass: "active"
                        });
                    }
                }
                else {
                    $.removeData(image, 'elevateZoom');//remove zoom instance from image
                    $('.zoomContainer:last-child').remove();// remove zoom container from DOM
                }

                $.magnificPopup.defaults.callbacks = {
                    open: function() {
                        $('body').addClass('zoom_image');
                    },
                    close: function() {
                        // Wait until overflow:hidden has been removed from the html tag
                        setTimeout(function() {
                            $('body').removeClass('zoom_image');
                            $('body').removeClass('zoom_gallery_image');
                            //$('.zoomContainer:last-child').remove();// remove zoom container from DOM
                            $('.zoomContainer').slice(1).remove();
                        }, 100);
                    }
                };

                // Set up gallery on click
                var galleryZoom = $('#pr_item_gallery');
                galleryZoom.magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery:{
                        enabled: true
                    },
                    callbacks: {
                        elementParse: function(item) {
                            item.src = item.el.attr('data-zoom-image');
                        }
                    }
                });

                // Zoom image when click on icon
                $('.product_img_zoom').on('click', function(){
                    var atual = $('#pr_item_gallery a').attr('data-zoom-image');
                    $('body').addClass('zoom_gallery_image');
                    $('#pr_item_gallery .item').each(function(){
                        if( atual == $(this).find('.product_gallery_item').attr('data-zoom-image') ) {
                            return galleryZoom.magnificPopup('open', $(this).index());
                        }
                    });
                });

                $('.plus').on('click', function() {
                    if ($(this).prev().val()) {
                        $(this).prev().val(+$(this).prev().val() + 1);
                    }
                });
                $('.minus').on('click', function() {
                    if ($(this).next().val() > 1) {
                        if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
                    }
                });

                /*===================================*
               22. PRICE FILTER JS
               *===================================*/
                $('#price_filter').each( function() {
                    var $filter_selector = $(this);
                    var a = $filter_selector.data("min-value");
                    var b = $filter_selector.data("max-value");
                    var c = $filter_selector.data("price-sign");
                    $filter_selector.slider({
                        range: true,
                        min: $filter_selector.data("min"),
                        max: $filter_selector.data("max"),
                        values: [ a, b ],
                        slide: function( event, ui ) {
                            $( "#flt_price" ).html( c + ui.values[ 0 ] + " - " + c + ui.values[ 1 ] );
                            $( "#price_first" ).val(ui.values[ 0 ]);
                            $( "#price_second" ).val(ui.values[ 1 ]);
                        }
                    });
                    $( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
                });

                /*===================================*
                23. RATING STAR JS
                *===================================*/
                $(document).ready(function () {
                    $('.star_rating span').on('click', function(){
                        var onStar = parseFloat($(this).data('value'), 10); // The star currently selected
                        var stars = $(this).parent().children('.star_rating span');
                        for (var i = 0; i < stars.length; i++) {
                            $(stars[i]).removeClass('selected');
                        }
                        for (i = 0; i < onStar; i++) {
                            $(stars[i]).addClass('selected');
                        }
                    });
                });

                /*===================================*
                24. CHECKBOX CHECK THEN ADD CLASS JS
                *===================================*/
                $('.create-account,.different_address').hide();
                $('#createaccount:checkbox').on('change', function(){
                    if($(this).is(":checked")) {
                        $('.create-account').slideDown();
                    } else {
                        $('.create-account').slideUp();
                    }
                });
                $('#differentaddress:checkbox').on('change', function(){
                    if($(this).is(":checked")) {
                        $('.different_address').slideDown();
                    } else {
                        $('.different_address').slideUp();
                    }
                });

                /*===================================*
                25. Cart Page Payment option
                *===================================*/
                $(document).ready(function () {
                    $('[name="payment_option"]').on('change', function() {
                        var $value = $(this).attr('value');
                        $('.payment-text').slideUp();
                        $('[data-method="'+$value+'"]').slideDown();
                    });
                });

                /*===================================*
                26. ONLOAD POPUP JS
                *===================================*/

                $(window).on('load',function(){
                    setTimeout(function() {
                        $("#onload-popup").modal('show', {}, 500);
                    }, 3000);

                });
        }
    },
    mounted() {
       let $this=this;
        ProductService.detail(this.$route.params.id).then(response => {
            let data = response || {};
            this.product = data;
            this.isLoading = false;
            Vue.nextTick(function(){
               this.initZoomImage();
            }.bind($this));
        }).catch(e => {
            this.isLoading = false;
        });
    }
}
</script>
