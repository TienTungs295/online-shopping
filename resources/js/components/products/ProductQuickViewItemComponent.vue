<template>
    <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0" v-if="product">
            <div>
                <VueSlickCarousel ref="c1" :asNavFor="c2" :focusOnSelect="true" :touchMove="false" :fade="true">
                    <div class="main-slide" v-for="(item, index) in product.images" :key="index">
                        <img :src="'/uploads/images/'+item.image"/>
                    </div>
                </VueSlickCarousel>
            </div>
            <div>
                <VueSlickCarousel v-show="product.images.length >1" ref="c2" :asNavFor="c1" :slidesToShow="4" :focusOnSelect="true" :touchMove="false">
                    <div class="nav-slide" v-for="(item, index) in product.images" :key="index">
                        <div class="nav-slide-item">
                            <img :src="'/uploads/images/'+item.image"/>
                        </div>
                    </div>
                </VueSlickCarousel>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="pr_detail">
                <div class="product_description">
                    <h4 class="product_title"><a href="#">{{ product.name }}</a></h4>
                    <div class="product_price">
                        <div v-if="product.is_contact">
                            <span class="price">Liên hệ</span>
                        </div>
                        <div v-else>
                            <div v-if="product.on_sale">
                                <span class="price">{{ product.sale_price | commaFormat }}</span>
                                <del>{{ product.price | commaFormat }}</del>
                                <div class="on_sale" v-if="product.sale_off != null">
                                    <span>{{ product.sale_off }}% Off</span>
                                </div>
                            </div>
                            <div v-else>
                                <span class="price">{{ product.price | commaFormat }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="rating_wrap d-flex align-items-center mgb-15" v-if="product.max_rating">
                        <star-rating v-model="product.max_rating.star"
                                     v-bind:show-rating="false"
                                     v-bind:star-size="15"
                                     v-bind:border-color="'#F6BC3E'"
                                     v-bind:inactive-color="'#FFFFFF'"
                                     v-bind:active-color="'#F6BC3E'"
                                     v-bind:border-width="1"
                                     v-bind:padding="1"
                                     v-bind:read-only="true">
                        </star-rating>
                        <span class="rating_num">({{ product.max_rating.total }})</span>
                    </div>
                    <div class="pr_desc" v-if="product.description">
                        <p>{{ product.description }}</p>
                    </div>
                    <div class="text-danger fw-bold" v-if="product.is_out_of_stock">Hết hàng</div>
                </div>
                <hr/>
                <div class="cart_extra">
                    <div v-if="product.is_contact">
                        <div class="cart_btn">
                            <a href="tel:0979945555" class="btn btn-fill-out btn-addtocart rounded-0 mgr-10">
                                <i class="linearicons-phone-wave"></i> Liên hệ ngay
                            </a>
                            <a class="add_wishlist" @click="addToWithList(product.id)"><i
                                class="icon-heart"></i></a>
                        </div>
                    </div>
                    <div v-else>
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus" @click="minus(cart)">
                                <input type="text" name="quantity" v-model="cart.qty" title="Qty" class="qty"
                                       size="4">
                                <input type="button" value="+" class="plus" @click="plus(cart)">
                            </div>
                        </div>
                        <br>
                        <div class="cart_btn mgb-10">
                            <button class="btn btn-fill-out btn-addtocart rounded-0 mgr-10 mgb-10" type="button"
                                    :disabled="product.is_out_of_stock"
                                    @click="addToCart(product.id,cart.qty)">
                                <i class="icon-basket-loaded"></i> Thêm vào giỏ
                            </button>
                            <button class="btn btn-fill-line view-cart rounded-0 mgl-0-i mgb-10" type="button"
                                    :disabled="product.is_out_of_stock"
                                    @click="buyNow(product.id,cart.qty)"><i
                                class="icon-basket-loaded"></i> Mua ngay
                            </button>
                            <a class="add_wishlist mgb-10" @click="addToWithList(product.id)"><i
                                class="icon-heart"></i></a>
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
// import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
// import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
// import 'swiper/css/swiper.css'
import CartService from "../../services/CartService";

export default {
    name: "ProductQuickViewItem",
    props: ['product'],
    components: {
        VueSlickCarousel
    },
    data() {
        return {
            // swiperOptionTop: {
            //     loop: this.product.images.length > 1,
            //     loopedSlides: (this.product.images.length > 3 ? 3 : this.product.images.length), // looped slides should be the same
            //     spaceBetween: 8,
            //     effect: 'fade',
            // },
            // swiperOptionThumbs: {
            //     loop: this.product.images.length > 1,
            //     loopedSlides: (this.product.images.length > 3 ? 3 : this.product.images.length), // looped slides should be the same
            //     spaceBetween: 8,
            //     slidesPerView: (this.product.images.length > 3 ? 3 : this.product.images.length),
            //     touchRatio: 0.2,
            //     slideToClickedSlide: true,
            //     centeredSlides: this.product.images.length <= 1
            // },
            settings:{
                "dots": true,
                "fade": true,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 1,
                "slidesToScroll": 1
            },
            items: [1, 2, 3, 4, 5],
            c1: undefined,
            c2: undefined,
            cart: {
                qty: 1
            }
        }
    },
    computed: {
        // swiperTop() {
        //     return this.$refs.swiperTop.$swiper
        // },
        // swiperThumbs() {
        //     return this.$refs.swiperThumbs.$swiper
        // }
    },
    methods: {
        addToWithList: function (product_id) {
            WithListService.save({product_id: product_id}, true).then(response => {
                this.findAllWithList();
            }).catch(e => {
            });
        },
        findAllWithList() {
            WithListService.findAll().then(response => {
                let data = response || {};
                this.$store.commit("setWithList", data.with_list);
                this.$store.commit("setWithListCount", data.total);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        findAllCart() {
            CartService.findAll().then(response => {
                let data = response || {};
                let cart = data.cart;
                let subTotal = data.subTotal;
                let subTotalFinal = data.subTotalFinal;
                let total = data.total;
                this.shippingFee = data.shippingFee;
                this.$store.commit("setCart", cart);
                this.$store.commit("setSubTotal", subTotal);
                this.$store.commit("setSubTotalFinal", subTotalFinal);
                this.$store.commit("setCartCount", total)
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        addToCart(product_id, qty) {
            CartService.add({product_id: product_id, qty: qty}, true).then(response => {
                this.findAllCart();
            }).catch(e => {
            });
        },

        buyNow(product_id, qty) {
            CartService.add({product_id: product_id, qty: qty}).then(response => {
                this.findAllCart();
                this.$router.push({name: 'order'});
            }).catch(e => {
            });
        },
        plus(item) {
            item.qty++;
        },

        minus(item) {
            if (item.qty == 0) return;
            item.qty--
        },
        setDefaultImg(event){
            event.target.src = window.location.protocol + "//" + window.location.host+'/assets/images/default/placeholder.png'
        }
    },
    mounted() {
        // this.swiperTop.controller.control = this.swiperThumbs;
        // this.swiperThumbs.controller.control = this.swiperTop;
        this.c1 = this.$refs.c1;
        this.c2 = this.$refs.c2;
    }
}
</script>
