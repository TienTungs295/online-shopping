<template>
    <div class="product">
        <div class="product_img style-1">
            <router-link
                :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                <img :src="'/uploads/images/'+item.image" :alt="item.image">
            </router-link>
            <div class="product_action_box">
                <ul class="list_none pr_action_btn">
                    <li v-if="item.is_contact">
                        <a href="tel:0979945555"><i class="linearicons-phone-wave"></i>Liên hệ</a>
                    </li>
                    <li v-else class="add-to-cart"><a @click="addToCart(item.id)"><i
                        class="icon-basket-loaded"></i>Thêm vào giỏ </a>
                    </li>
                    <li><a @click="showModal()"
                           class="popup-ajax"><i
                        class="icon-magnifier-add"></i></a></li>
                    <li><a @click="addToWithList(item.id)"><i class="icon-heart"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="product_info">
            <span class="pr_flash" :style="{'background-color': label.color}" v-if="item.product_labels.length" v-for="label in item.product_labels">
                {{label.name}}
            </span>
            <h6 class="product_title">
                <router-link
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
                        <span class="price">{{ item.sale_price | commaFormat}}</span>
                        <del>{{ item.price | commaFormat}}</del>
                        <div class="on_sale" v-if="item.sale_off != null">
                            <span>{{ item.sale_off }}% Off</span>
                        </div>
                    </div>
                    <div v-else>
                        <span class="price">{{ item.price | commaFormat}}</span>
                    </div>
                </div>
            </div>
            <div class="rating_wrap" v-if="item.max_rating">
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
                    <span class="rating_num">({{item.max_rating.total}})</span>
            </div>
            <div class="list_product_action_box dis-none">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart"><a class="rounded-0" @click="addToCart(item.id)"><i
                        class="icon-basket-loaded"></i>Thêm vào giỏ</a></li>
                    <li><a @click="showModal()" class="popup-ajax"><i
                        class="icon-magnifier-add"></i></a></li>
                    <li><a @click="addToWithList(item.id)"><i class="icon-heart"></i></a></li>
                </ul>
            </div>
        </div>
        <b-modal :ref="'quick-view-modal'+item.id" content-class="rounded-0" size="xl" hide-footer>
            <div class="d-block">
                <product-quick-view-modal-component v-bind:id="item.id"></product-quick-view-modal-component>
            </div>
        </b-modal>
    </div>
</template>
<script>


import WithListService from "../../services/WithListService";
import CartService from "../../services/CartService";

export default {
    name: "ProductItem",
    props: ['item'],
    methods: {
        showModal() {
            let ref = 'quick-view-modal' + this.item.id;
            this.$refs[ref].show()
        },
        addToWithList: function (product_id) {
            WithListService.save({product_id: product_id}, true).then(response => {
                this.findAllWithList();
            }).catch(e => {
            });
        },
        addToCart: function (product_id) {
            CartService.add({product_id: product_id, qty: 1}, true).then(response => {
                this.findAllCart();
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
    },
    mounted() {

    }
}
</script>
