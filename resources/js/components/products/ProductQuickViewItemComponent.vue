<template>
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
            <div class="detail-slider">

                <swiper class="swiper gallery-top" :options="swiperOptionTop" ref="swiperTop">
                    <swiper-slide v-for="item in product.images" v-bind:key="item.id">
                        <img :src="'/uploads/images/'+item.image" :alt="item.image"/>
                    </swiper-slide>
                </swiper>
                <swiper class="swiper gallery-thumbs" :options="swiperOptionThumbs" ref="swiperThumbs">
                    <swiper-slide v-for="item in product.images" v-bind:key="item.id">
                        <img :src="'/uploads/images/'+item.image" :alt="item.image"/>
                    </swiper-slide>
                </swiper>
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
                            <button class="btn btn-fill-out btn-addtocart rounded-0" type="button"><i
                                class="icon-basket-loaded"></i> Thêm vào giỏ
                            </button>
                            <button class="btn btn-fill-line view-cart rounded-0" type="button"><i
                                class="icon-basket-loaded"></i> Mua ngay
                            </button>
                            <a class="add_wishlist" @click="addToWithList(product.id)"><i class="icon-heart"></i></a>
                        </div>
                    </div>
                </div>
                <hr/>
                <ul class="product-meta">
                    <li>Mã sản phẩm: <span>{{ product.sku }}</span></li>
                    <li v-if="product.category">Danh mục: <a href="#">{{ product.category.name }}</a></li>
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

</template>

<script>

import WithListService from "../../services/WithListService";
import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
    name: "ProductQuickViewItem",
    props: ['product'],
    components: {
        Swiper,
        SwiperSlide
    },
    data() {
        return {
            swiperOptionTop: {
                loop: true,
                loopedSlides: this.product.images.length, // looped slides should be the same
                spaceBetween: 8,
                effect: 'fade',
            },
            swiperOptionThumbs: {
                loop: true,
                loopedSlides: this.product.images.length, // looped slides should be the same
                spaceBetween: 8,
                slidesPerView: this.product.images.length,
                touchRatio: 0.2,
                slideToClickedSlide: true
            }
        }
    },
    computed: {
        swiperTop() {
            return this.$refs.swiperTop.$swiper
        },
        swiperThumbs() {
            return this.$refs.swiperThumbs.$swiper
        }
    },
    methods: {
        addToWithList: function (product_id) {
            WithListService.save({product_id: product_id}, true).then(response => {
                this.countWithList();
            }).catch(e => {
            });
        },
        countWithList() {
            WithListService.count().then(response => {
                let data = response || 0;
                this.$store.commit("setWithListCount", data)
            }).catch(e => {
            });
        },
    },
    mounted() {
        if (this.product.images.length <= 1) {
            swiperOptionThumbs.centeredSlides = true;
        }
        this.swiperTop.controller.control = this.swiperThumbs
        this.swiperThumbs.controller.control = this.swiperTop
    }
}
</script>
