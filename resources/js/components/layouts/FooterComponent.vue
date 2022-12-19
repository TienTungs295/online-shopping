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
                                    <a href="#"><img src="/assets/images/logo/logo.png?version=11" alt="logo"/></a>
                                </div>
                                <p>Công ty TNHH thương mại và sản xuất NK</p>
                            </div>
                            <div class="widget">
                                <div class="fb-page" data-href="https://www.facebook.com/DauCapVaHopNoiTrungHaThe3M/" data-tabs="timeline" data-width="250" data-height="90" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/DauCapVaHopNoiTrungHaThe3M/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/DauCapVaHopNoiTrungHaThe3M/">Công Ty TNHH Thương Mại và Sản Xuất Nk</a></blockquote></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Địa chỉ</h6>
                            </div>
                            <ul class="contact_info contact_info_light">
                                <li>
                                    <i class="ti-location-pin"></i>
                                    <p>Địa chỉ: Số 77, tổ 17 thị trấn Đông Anh, Huyện Đông Anh, TP. Hà Nội</p>
                                </li>
                                <li>
                                    <i class="ti-location-pin"></i>
                                    <p>VPGD: Số 78, Ngõ 166, Đường Trần Duy Hưng, Phường Trung Hoà, Quận Cầu Giấy, TP Hà Nội</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Liên hệ</h6>
                                <ul class="contact_info contact_info_light">
                                    <li>
                                        <i class="ti-email"></i>
                                        <a href="mailto:kinhdoanh.nk3m@gmail.com">kinhdoanh.nk3m@gmail.com</a>
                                    </li>
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <a href="tel:0979945555">0979945555</a>
                                    </li>
                                    <li>
                                        <label class="light-color-i">Phòng kinh doanh</label>
                                    </li>
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <label class="light-color-i">Mrs.Ngọc: </label>
                                        <a href="tel:0918155579">0918155579</a>
                                    </li>
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <label class="light-color-i">Ms.Loan: </label>
                                        <a href="tel:0916155579">0916155579</a>
                                    </li>
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <label class="light-color-i">Ms.Linh: </label>
                                        <a href="tel:0886155579">0886155579</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="widget">
                                <h6 class="widget_title">Chính sách</h6>
                                <ul class="widget_links">
                                    <li>
                                        <router-link :to="{name:'returnPolicy'}">Chính sách đổi trả</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'privacyPolicy'}">Chính sách bảo mật</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'termsOfService'}">Điều khoản dịch vụ</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'shippingPolicy'}">Chính sách vận chuyển</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'paymentPolicy'}">Chính sách thanh toán</router-link>
                                    </li>
                                    <li>
                                        <router-link :to="{name:'warrantyPolicy'}">Chính sách bảo hành</router-link>
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
