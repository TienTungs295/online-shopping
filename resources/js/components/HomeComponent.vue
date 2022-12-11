<template>
    <div>
        <!-- START SECTION BANNER -->
        <div class="banner_section slide_wrap shop_banner_slider staggered-animation-wrap">
            <b-carousel
                id="carousel-fade"
                :interval="2000"
                controls
                fade>
                <b-carousel-slide
                    img-src="/assets/images/banner/construction.jpg">
                </b-carousel-slide>
                <b-carousel-slide
                    img-src="/assets/images/banner/solar_power.jpg">
                </b-carousel-slide>
            </b-carousel>
        </div>
        <!-- END SECTION BANNER -->

        <!-- END MAIN CONTENT -->
        <div class="main_content">

            <!-- START SECTION CATEGORIES -->
            <div class="section pt-0 small_pb">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="cat_overlap radius_all_5">
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="text-center text-md-left">
                                            <h5>Top Danh mục</h5>
                                            <p class="mb-2">Các danh mục với xu hướng lựa chọn hàng đầu.</p>
                                            <router-link class="btn btn-line-fill btn-sm"
                                                         :to="{ name: 'productList'}">
                                                Xem tất cả
                                            </router-link>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-8">
                                        <div v-if="!isLoadingTopCategories"
                                             class="cat_slider mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5"
                                             v-carousel
                                             data-loop="true" data-dots="false" data-nav="true" data-margin="30"
                                             data-responsive='{"0":{"items": "1"}, "380":{"items": "2"}, "991":{"items": "3"}, "1199":{"items": "4"}}'>
                                            <div class="item" v-for="item in topCategories">
                                                <div class="categories_box">
                                                    <router-link
                                                        :to="{ name: 'productList', query: { category_id: item.id}}">
                                                        <div class="category-image">
                                                            <img :src="'/uploads/images/'+item.image"
                                                                 @error="setDefaultImg"
                                                                 :alt="item.image">
                                                        </div>
                                                        <span>{{ item.name }}</span>
                                                    </router-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <loading-component
                                                v-bind:loading="isLoadingTopCategories"></loading-component>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION CATEGORIES -->

            <!-- START FLASH SALE -->
            <div>
                <flash-sale-component></flash-sale-component>
            </div>
            <!-- END FLASH SALE -->

            <!-- START SECTION SHOP -->
            <div class="section pdt-30-i pdb-30-i">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h5>Bộ sưu tập</h5>
                                </div>
                                <div class="tab-style2">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#tabmenubar" aria-expanded="false">
                                        <span class="ion-android-menu"></span>
                                    </button>
                                    <ul class="nav nav-tabs justify-content-center justify-content-md-end"
                                        id="tabmenubar">
                                        <li class="nav-item"
                                            v-for="(item, index) in collections"
                                            :key="index"
                                            @click="changeCollection(item.id, index)">
                                            <a class="nav-link cursor-pointer"
                                               :class="{ active: index == currentIndex }">{{ item.name }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-pane fade show active" v-if="!isLoading">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-sm-6" v-for="item in productCollections">
                                        <product-item-component v-bind:item="item"></product-item-component>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <loading-component v-bind:loading="isLoading"></loading-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION SHOP -->

            <!-- START SECTION SHOP INFO -->
            <div class="bg_gray">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="shopping_info border-0">
                                <div class="row justify-content-center pdt-55 pdb-50">
                                    <div class="col-md-4 icon-box-inner">
                                        <div class="icon_box icon_box_style2">
                                            <div class="icon">
                                                <i class="flaticon-shipped"></i>
                                            </div>
                                            <div class="icon_box_content">
                                                <h5>Giao hàng miễn phí</h5>
                                                <p>Giao hàng miễn phí với những đơn hàng đủ điều kiện.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 icon-box-inner">
                                        <div class="icon_box icon_box_style2 pdl-5-i">
                                            <div class="icon">
                                                <i class="flaticon-money-back"></i>
                                            </div>
                                            <div class="icon_box_content">
                                                <h5>Đổi trả trong vòng 7 ngày</h5>
                                                <p>Quý khách cần giữ các sản phẩm còn nguyên vẹn.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 icon-box-inner">
                                        <div class="icon_box icon_box_style2 pdl-5-i">
                                            <div class="icon">
                                                <i class="flaticon-support"></i>
                                            </div>
                                            <div class="icon_box_content">
                                                <h5>Hỗ trợ 24/7</h5>
                                                <p>Đội ngũ nhân viên nhiệt tình, sẵn hàng tư vấn và hỗ trợ.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION SHOP INFO -->

            <!-- START TRENDING -->
            <div class="section pdt-30-i pdb-30-i">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h5>Đang thịnh hành</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-pane fade show active" v-if="!isLoadingTrending">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" v-carousel
                                     data-loop="false" data-margin="20"
                                     data-responsive='{"0":{"items": "1"}, "576":{"items": "2"}, "992":{"items": "3"}, "1200":{"items": "4"}}'>
                                    <div class="item" v-for="item in trendingProducts">
                                        <product-item-component v-bind:item="item"></product-item-component>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <loading-component v-bind:loading="isLoadingTrending"></loading-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TRENDING -->

            <!-- START SECTION TESTIMONIAL -->
            <div class="what-client-say position-relative">
                <div class="__overlay">
                </div>
                <div class="pdt-80 pdb-80">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="heading_s1 text-center">
                                    <h5 class="light-color">Ý kiến khách hàng!</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div
                                    class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2 light-color"
                                    v-carousel
                                    data-nav="true" data-dots="false" data-center="true" data-loop="true"
                                    data-autoplay="true" data-items='1'>
                                    <div class="testimonial_box">
                                        <div class="testimonial_desc">
                                            <p>"Giá cả rất hợp lý đầy đủ. Tôi nhập hàng thường xuyên qua đây và rất tin
                                                tưởng
                                                chất lượng sản phẩm."</p>
                                        </div>
                                        <div class="author_wrap">
                                            <div class="author_name text-center">
                                                <h6 class="__name">Anh Vũ</h6>
                                                <span>Bác sĩ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial_box">
                                        <div class="testimonial_desc">
                                            <p>"Các sản phẩm của công ty có chất lượng rất tốt, giá cả cạnh tranh. Tôi
                                                sẽ
                                                tiếp tục ủng hộ các bạn."</p>
                                        </div>
                                        <div class="author_wrap">
                                            <div class="author_name text-center">
                                                <h6 class="__name">Chị Hà</h6>
                                                <span>Nhân viên kinh doanh</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial_box">
                                        <div class="testimonial_desc">
                                            <p>"Tôi rất hài lòng với phong cách làm việc chuyên nghiệp, thời gian giao
                                                hàng
                                                nhanh, nhân viên hỗ trợ nhiệt tình."</p>
                                        </div>
                                        <div class="author_wrap">
                                            <div class="author_name text-center">
                                                <h6 class="__name">Anh Minh</h6>
                                                <span>Kỹ sư xây dựng</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION TESTIMONIAL -->

            <!-- START SECTION SHOP -->
            <div class="section pdt-30-i pdb-50-i">
                <div class="container">
                    <div class="row">
                        <div :class="onSaleProducts.length == 0 ? 'col-lg-6' : 'col-lg-4'">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading_tab_header">
                                        <div class="heading_s2">
                                            <h5>Sản phẩm đặc trưng</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-if="!isLoadingFeatured" v-carousel
                                         class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5"
                                         data-nav="true"
                                         data-dots="false" data-loop="false" data-margin="20"
                                         data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                                        <div class="item" v-for="entry in featuredProductMap">
                                            <div v-for="item in entry">
                                                <div class="product_wrap">
                                                        <span class="pr_flash"
                                                              :style="{'background-color': label.color}"
                                                              v-if="item.product_labels.length && !item.is_out_of_stock"
                                                              v-for="label in item.product_labels">
                                                            {{ label.name }}
                                                        </span>
                                                    <span class="pr_flash" v-if="item.is_out_of_stock"
                                                          style="background-color: #000">Hết hàng</span>
                                                    <div class="product_img style-2">
                                                        <router-link
                                                            :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                            <img class="border-ccc" :src="'/uploads/images/'+item.image"
                                                                 @error="setDefaultImg"
                                                                 :alt="item.image">
                                                        </router-link>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title">
                                                            <router-link :title="item.name"
                                                                         :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                                {{ item.name }}
                                                            </router-link>
                                                        </h6>
                                                        <div class="product_price">
                                                            <div v-if="item.is_contact">
                                                                <span class="price">Liên hệ</span>
                                                            </div>
                                                            <div v-else>
                                                                <div v-if="item.on_sale">
                                                                    <span
                                                                        class="price">{{
                                                                            item.sale_price | commaFormat
                                                                        }}</span>
                                                                    <del>{{ item.price | commaFormat }}</del>
                                                                    <div class="on_sale d-block"
                                                                         v-if="item.sale_off != null">
                                                                        <span>{{ item.sale_off }}% Off</span>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <span
                                                                        class="price">{{
                                                                            item.price | commaFormat
                                                                        }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="rating_wrap d-flex align-items-center"
                                                             v-if="item.max_rating">
                                                            <star-rating v-model="item.max_rating.star"
                                                                         v-bind:show-rating="false"
                                                                         v-bind:star-size="10"
                                                                         v-bind:border-color="'#F6BC3E'"
                                                                         v-bind:inactive-color="'#FFFFFF'"
                                                                         v-bind:active-color="'#F6BC3E'"
                                                                         v-bind:border-width="1"
                                                                         v-bind:padding="1"
                                                                         v-bind:read-only="true">
                                                            </star-rating>
                                                            <span
                                                                class="rating_num">({{ item.max_rating.total }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <loading-component v-bind:loading="isLoadingFeatured"></loading-component>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div :class="onSaleProducts.length == 0 ? 'col-lg-6' : 'col-lg-4'">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading_tab_header">
                                        <div class="heading_s2">
                                            <h5>Xếp hạng cao nhất</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-if="!isLoadingTopRate" v-carousel
                                         class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5"
                                         data-nav="true"
                                         data-dots="false" data-loop="false" data-margin="20"
                                         data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                                        <div class="item" v-for="entry in topRateProductMap">
                                            <div v-for="item in entry">
                                                <div class="product_wrap">
                                                     <span class="pr_flash"
                                                           :style="{'background-color': label.color}"
                                                           v-if="item.product_labels.length && !item.is_out_of_stock"
                                                           v-for="label in item.product_labels">
                                                            {{ label.name }}
                                                        </span>
                                                    <span class="pr_flash" v-if="item.is_out_of_stock"
                                                          style="background-color: #000">Hết hàng</span>
                                                    <div class="product_img style-2">
                                                        <router-link
                                                            :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                            <img class="border-ccc" :src="'/uploads/images/'+item.image"
                                                                 @error="setDefaultImg"
                                                                 :alt="item.image">
                                                        </router-link>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title">
                                                            <router-link :title="item.name"
                                                                         :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                                {{ item.name }}
                                                            </router-link>
                                                        </h6>
                                                        <div class="product_price">
                                                            <div v-if="item.is_contact">
                                                                <span class="price">Liên hệ</span>
                                                            </div>
                                                            <div v-else>
                                                                <div v-if="item.on_sale">
                                                                    <span
                                                                        class="price">{{
                                                                            item.sale_price | commaFormat
                                                                        }}</span>
                                                                    <del>{{ item.price | commaFormat }}</del>
                                                                    <div class="on_sale d-block"
                                                                         v-if="item.sale_off != null">
                                                                        <span>{{ item.sale_off }}% Off</span>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <span
                                                                        class="price">{{
                                                                            item.price | commaFormat
                                                                        }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="rating_wrap d-flex align-items-center"
                                                             v-if="item.max_rating">
                                                            <star-rating v-model="item.max_rating.star"
                                                                         v-bind:show-rating="false"
                                                                         v-bind:star-size="10"
                                                                         v-bind:border-color="'#F6BC3E'"
                                                                         v-bind:inactive-color="'#FFFFFF'"
                                                                         v-bind:active-color="'#F6BC3E'"
                                                                         v-bind:border-width="1"
                                                                         v-bind:padding="1"
                                                                         v-bind:read-only="true">
                                                            </star-rating>
                                                            <span
                                                                class="rating_num">({{ item.max_rating.total }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <loading-component v-bind:loading="isLoadingTopRate"></loading-component>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" v-if="onSaleProducts.length > 0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading_tab_header">
                                        <div class="heading_s2">
                                            <h5>Đang giảm giá</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-if="!isLoadingOnSale" v-carousel
                                         class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5"
                                         data-nav="true"
                                         data-dots="false" data-loop="false" data-margin="20"
                                         data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                                        <div class="item" v-for="entry in onSaleProductMap">
                                            <div v-for="item in entry">
                                                <div class="product_wrap">
                                                        <span class="pr_flash"
                                                              :style="{'background-color': label.color}"
                                                              v-if="item.product_labels.length && !item.is_out_of_stock"
                                                              v-for="label in item.product_labels">
                                                            {{ label.name }}
                                                        </span>
                                                    <span class="pr_flash" v-if="item.is_out_of_stock"
                                                          style="background-color: #000">Hết hàng</span>
                                                    <div class="product_img style-2">
                                                        <router-link
                                                            :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                            <img class="border-ccc" :src="'/uploads/images/'+item.image"
                                                                 @error="setDefaultImg"
                                                                 :alt="item.image">
                                                        </router-link>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title">
                                                            <router-link :title="item.name"
                                                                         :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                                                {{ item.name }}
                                                            </router-link>
                                                        </h6>
                                                        <div class="product_price">
                                                            <div v-if="item.is_contact">
                                                                <span class="price">Liên hệ</span>
                                                            </div>
                                                            <div v-else>
                                                                <div v-if="item.on_sale">
                                                                    <span
                                                                        class="price">{{
                                                                            item.sale_price | commaFormat
                                                                        }}</span>
                                                                    <del>{{ item.price | commaFormat }}</del>
                                                                    <div class="on_sale d-block"
                                                                         v-if="item.sale_off != null">
                                                                        <span>{{ item.sale_off }}% Off</span>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <span
                                                                        class="price">{{
                                                                            item.price | commaFormat
                                                                        }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="rating_wrap d-flex align-items-center"
                                                             v-if="item.max_rating">
                                                            <star-rating v-model="item.max_rating.star"
                                                                         v-bind:show-rating="false"
                                                                         v-bind:star-size="10"
                                                                         v-bind:border-color="'#F6BC3E'"
                                                                         v-bind:inactive-color="'#FFFFFF'"
                                                                         v-bind:active-color="'#F6BC3E'"
                                                                         v-bind:border-width="1"
                                                                         v-bind:padding="1"
                                                                         v-bind:read-only="true">
                                                            </star-rating>
                                                            <span
                                                                class="rating_num">({{ item.max_rating.total }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <loading-component v-bind:loading="isLoadingOnSale"></loading-component>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END SECTION SHOP -->

            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div style="border-bottom: 1px solid #ddd;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- START SECTION BLOG -->
            <div class="section pdb-50-i pdt-50-i">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="heading_s1 text-center">
                                <h4>Tin tức & Sự kiện</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" v-if="!isLoadingBlog">
                        <div class="col-lg-4 col-md-6" v-for="item in blogs">
                            <blog-item-component v-bind:item="item"></blog-item-component>
                        </div>
                    </div>
                    <div class="row justify-content-center" v-else>
                        <loading-component v-bind:loading="isLoadingBlog"></loading-component>
                    </div>
                </div>
            </div>
            <!-- END SECTION BLOG -->

            <!-- START SECTION SUBSCRIBE NEWSLETTER -->
            <div class="section bg_default pdt-50-i pdb-50-i">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="newsletter_text text_white">
                                <h3>Tham gia bản tin</h3>
                                <p> Đăng ký ngay để nhận được các thông tin khuyến mãi. </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="newsletter_form2">
                                <form>
                                    <input type="text" v-model="contact.email" class="form-control rounded-0"
                                           placeholder="Nhập email đăng ký">
                                    <button type="button" class="btn btn-dark rounded-0 bg-dark" name="submit"
                                            @click="saveContact()">Gửi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- START SECTION SUBSCRIBE NEWSLETTER -->

        </div>
        <!--END MAIN CONTENT-->
    </div>
</template>

<script>
import ProductService from "../services/ProductService";
import CategoryService from "../services/CategoryService";
import CollectionService from "../services/CollectionService";
import BlogService from "../services/BlogService";
import CartService from "../services/CartService";
import ContactService from "../services/ContactService";


export default {
    name: "Home",
    data() {
        return {
            topCategories: [],
            collections: [],
            productCollections: [],
            trendingProducts: [],
            trendingProductMap: {},
            onSaleProducts: [],
            onSaleProductMap: {},
            featuredProducts: [],
            featuredProductMap: {},
            topRateProducts: [],
            topRateProductMap: {},
            blogs: [],
            currentIndex: 0,
            isLoading: true,
            isLoadingTrending: true,
            isLoadingFeatured: true,
            isLoadingOnSale: true,
            isLoadingTopRate: true,
            isLoadingBlog: true,
            isLoadingTopCategories: true,
            contact: {}
        };
    },
    methods: {
        changeCollection(collection_id, index) {
            this.currentIndex = index;
            this.isLoading = true;
            ProductService.findByCollection(collection_id).then(response => {
                let res = response || {};
                let productPage = res.products || {};
                this.productCollections = productPage.data || [];
                this.collections = res.collections || [];
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        saveContact() {
            if (this.contact.email == null || this.contact.email == undefined || this.contact.email.trim() == "") return;
            this.contact.showMessage = true;
            ContactService.save(this.contact, true).then(response => {
                this.contact = {};
                this.$cookies.set("do_not_show_popup_again", true);
            }).catch(response => {
            });
        },
        setDefaultImg(event) {
            event.target.src = window.location.protocol + "//" + window.location.host + '/assets/images/default/placeholder.png'
        }
    },
    mounted() {
        CategoryService.findTop().then(response => {
            let data = response || [];
            this.topCategories = data;
            this.isLoadingTopCategories = false;
        }).catch(e => {
            this.isLoadingTopCategories = false;
        });

        this.changeCollection(null, 0);

        ProductService.findTrending().then(response => {
            this.trendingProducts = response || [];
            let groupProducts = [];
            let key = 0;
            for (let i = 0; i < this.trendingProducts.length; i++) {
                let number = i + 1;
                let item = this.trendingProducts[i];
                groupProducts.push(item);
                if ((number != 1 && number % 3 == 0) || (number == this.trendingProducts.length)) {
                    this.trendingProductMap[key] = groupProducts;
                    key++;
                    groupProducts = [];
                }
            }
            this.isLoadingTrending = false;
        }).catch(e => {
            this.isLoadingTrending = false;
        });

        ProductService.findOnSale().then(response => {
            let data = response.data || [];
            this.onSaleProducts = data;
            let groupProducts = [];
            let key = 0;
            for (let i = 0; i < this.onSaleProducts.length; i++) {
                let number = i + 1;
                let item = this.onSaleProducts[i];
                groupProducts.push(item);
                if ((number != 1 && number % 3 == 0) || (number == this.onSaleProducts.length)) {
                    this.onSaleProductMap[key] = groupProducts;
                    key++;
                    groupProducts = [];
                }
            }
            this.isLoadingOnSale = false;
        }).catch(e => {
            this.isLoadingOnSale = false;
        });

        ProductService.findFeatured().then(response => {
            let data = response.data || [];
            this.featuredProducts = data;
            let groupProducts = [];
            let key = 0;
            for (let i = 0; i < this.featuredProducts.length; i++) {
                let number = i + 1;
                let item = this.featuredProducts[i];
                groupProducts.push(item);
                if ((number != 1 && number % 3 == 0) || (number == this.featuredProducts.length)) {
                    this.featuredProductMap[key] = groupProducts;
                    key++;
                    groupProducts = [];
                }
            }
            this.isLoadingFeatured = false;
        }).catch(e => {
            this.isLoadingFeatured = false;
        });

        ProductService.findTopRate().then(response => {
            let data = response.data || [];
            this.topRateProducts = data;
            let groupProducts = [];
            let key = 0;
            for (let i = 0; i < this.topRateProducts.length; i++) {
                let number = i + 1;
                let item = this.topRateProducts[i];
                groupProducts.push(item);
                if ((number != 1 && number % 3 == 0) || (number == this.topRateProducts.length)) {
                    this.topRateProductMap[key] = groupProducts;
                    key++;
                    groupProducts = [];
                }
            }
            this.isLoadingTopRate = false;
        }).catch(e => {
            this.isLoadingTopRate = false;
        });


        BlogService.findAll().then(response => {
            let data = response.data || [];
            this.blogs = data;
            this.isLoadingBlog = false;
        }).catch(e => {
            this.isLoadingBlog = false;
        });
    }
}
</script>
