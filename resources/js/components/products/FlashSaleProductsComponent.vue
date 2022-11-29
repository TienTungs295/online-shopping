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
                                            <img class="img-src" :src="'/uploads/images/'+item.image" :alt="item.image" @error="setDefaultImg">
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h5 class="product_title">
                                        <router-link :title="item.name"
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
                                <div class="deal_progress">
                                    <b-progress :value="item.in_progress_range" :max="item.max_range" show-progress
                                                animated></b-progress>
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
                        item["in_progress_range"] = Math.floor(Date.now() / 1000) - item["start_date_time_stamp"];
                    });
                }, 30000);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        setDefaultImg(event){
            event.target.src = window.location.protocol + "//" + window.location.host+'/assets/images/default/placeholder.png'
        }
    },
    beforeDestroy() {
        clearInterval(this.timer)
        this.timer = null
    }
}
</script>
