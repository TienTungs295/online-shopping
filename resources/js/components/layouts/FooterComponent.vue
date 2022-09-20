<template>
    <div>
        <!-- START FOOTER -->
        <footer class="footer_dark">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="footer_logo">
                                    <a href="#"><img src="assets/images/logo/logo.png" alt="logo"/></a>
                                </div>
                                <p>Công ty TNHH thương mại và sản xuất NK</p>
                            </div>
                            <div class="widget">
                                <ul class="social_icons social_white">
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Danh mục sản phẩm</h6>
                                <ul class="widget_links">
                                    <li v-for="(item,index) in topCategories" v-if="index < 4">
                                        <router-link
                                            :to="{ name: 'productList', query: { category_id: item.id}}">
                                            {{ item.name }}
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Đặt hàng</h6>
                                <ul class="widget_links">
                                    <li>
                                        <router-link :to="{name:'withList'}">Yêu thích</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'cart'}">Giỏ hàng</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'order'}">Thanh toán</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'contact-us'}">Liên hệ</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Liên hệ</h6>
                                <ul class="contact_info contact_info_light">
                                    <li>
                                        <i class="ti-location-pin"></i>
                                        <p>Số 77, tổ 17 thị trấn Đông Anh, Huyện Đông Anh, TP. Hà Nội</p>
                                    </li>
                                    <li>
                                        <i class="ti-email"></i>
                                        <a href="mailto:info@sitename.com">info@sitename.com</a>
                                    </li>
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <p>0979945555</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom_footer border-top-tran">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-left light-color">Copyright 2022 © 3MNK All Rights Reserved</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right light-color">Phát triển và vận hành bởi <a
                                href="https://www.facebook.com/tientung2206" target="_blank"><span> Tien Luu</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->

        <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>
    </div>
</template>

<script>

import CategoryService from "../../services/CategoryService";

export default {
    name: "Footer",
    data() {
        return {
            topCategories: [],
            isLoadingTopCategories: true
        };
    },
    mounted() {
        CategoryService.findTop().then(response => {
            let data = response || [];
            this.topCategories = data;
            this.isLoadingTopCategories = false;
        }).catch(e => {
            this.isLoadingTopCategories = false;
        });
    }
}
</script>
