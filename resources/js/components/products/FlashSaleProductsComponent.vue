<template>
    <div class="container" v-if="products.length">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>Flash Sale</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div v-if="!isLoading" v-carousel
                     class="product_slider carousel_slider owl-carousel owl-theme nav_style3"
                     data-loop="false"
                     data-dots="false" data-nav="true" data-margin="30"
                     data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
                    <div class="item" v-for="item in products" :key="item.id" v-if="products.length" v-countDown>
                        <div class="deal_wrap">
                            <div class="img-wrapper">
                                <div class="product_img_inner">
                                    <div>
                                        <router-link
                                            :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                            <img class="img-src" :src="'/uploads/images/'+item.image" :alt="item.image">
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h5 class="product_title">
                                        <router-link
                                            :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                                            {{ item.name }}
                                        </router-link>
                                    </h5>
                                    <div class="product_price">
                                        <div v-if="item.is_contact">
                                            <span class="price">Liên hệ</span>
                                        </div>
                                        <div v-else>
                                            <div v-if="item.on_sale">
                                                <span class="price">{{ item.sale_price | commaFormat }}</span>
                                                <del>{{ item.price | commaFormat }}</del>
                                                <div class="on_sale"
                                                     v-if="item.sale_off != null">
                                                    <span>{{ item.sale_off }}% Off</span>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <span class="price">{{ item.price | commaFormat }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="deal_progress">
                                    <!--                                    <span class="stock-sold">Already Sold: <strong>4</strong></span>-->
                                    <!--                                    <span class="stock-available">Available: <strong>22</strong></span>-->
                                    count_down_value:{{item.count_down_value}}
                                        <b-progress :value="item.count_down_value" :max="100" show-progress animated></b-progress>
                                </div>
                                <div class="countdown_time countdown_style4 mb-4"
                                     data-days-text="Ngày" data-hours-text="Giờ" data-minutes-text="Phút"
                                     data-seconds-text="Giây"
                                     v-bind:data-time="item.end_date"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <loading-component v-bind:loading="isLoading"></loading-component>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import ProductService from "../../services/ProductService";

export default {
    name: "FlashSale",
    data() {
        return {
            isLoading: false,
            products: [],
            timer: null
        };
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            this.isLoading = true;
            ProductService.findFlashSale().then(response => {
                this.products = response || [];
                this.timer = setInterval(() => {
                    this.products.forEach(item => {
                        // item["current_time_stamp"] = new Date().getTime() / 100;
                        console.log(item);
                    });
                }, 2000);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
    },
    beforeDestroy() {
        clearInterval(this.timer)
        this.timer = null
    }
}
</script>
