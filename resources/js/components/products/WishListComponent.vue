<template>
    <div>

        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Sản phẩm yêu thích </h1>
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
                            <li class="breadcrumb-item active">Sản phẩm yêu thích</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content">

            <!-- START SECTION SHOP -->
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive wishlist_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">Ảnh</th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-subtotal">Thêm vào giỏ</th>
                                        <th class="product-remove">Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item,key) in withList">
                                        <td class="product-thumbnail">
                                            <router-link
                                                :to="{ name: 'productDetail', params: { slug: item.options.slug,id:item.id }}">
                                                <img :src="'/uploads/images/'+item.options.image"
                                                     :alt="item.options.image">
                                            </router-link>
                                        </td>
                                        <td class="product-name" data-title="Sản phẩm">
                                            <router-link
                                                :to="{ name: 'productDetail', params: { slug: item.options.slug,id:item.id }}">
                                                {{ item.name }}
                                            </router-link>
                                        </td>
                                        <td class="product-price" data-title="Giá">
                                            <span class="price">{{ item.price | commaFormat}}</span>
                                            <del v-if="item.options.on_sale">{{ item.options.price | commaFormat}}</del>
                                        </td>
                                        <td class="product-subtotal" data-title="Thêm vào giỏ"><a @click="addToCart(item.id)"
                                            class="btn btn-fill-out btn-sm add-to-cart-button rounded-0">Thêm vào
                                            giỏ</a></td>
                                        <td class="product-remove" data-title="Xóa"><a
                                            class="btn btn-fill-line view-cart rounded-0 btn-sm rounded-0"
                                            @click="remove(key)">Xóa</a></td>
                                    </tr>
                                    </tbody>
                                </table>
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
import WithListService from "../../services/WithListService";
import {serviceBus} from './../../serviceBus'
import CartService from "../../services/CartService";

export default {
    name: "Wishlist",
    data() {
        return {
            withList: {},
            isLoading: true,
        };
    },
    methods: {
        remove: function (id) {
            WithListService.delete({row_id: id}, true).then(response => {
                let item = response || [];
                this.findAll();
                this.countWithList();
            }).catch(e => {
            });
        },
        findAll() {
            WithListService.findAll().then(response => {
                let data = response || {};
                this.withList = data;
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        countWithList() {
            WithListService.count().then(response => {
                let data = response || 0;
                this.$store.commit("setWithListCount", data)
            }).catch(e => {
            });
        },

        addToCart: function (product_id) {
            CartService.add({product_id: product_id, qty: 1}, true).then(response => {
                this.countCart();
                this.findAllCart();
            }).catch(e => {
            });
        },

        countCart() {
            CartService.count().then(response => {
                let data = response || 0;
                this.$store.commit("setCartCount", data)
            }).catch(e => {
            });
        },
        findAllCart() {
            CartService.findAll().then(response => {
                let data = response || {};
                let cart = data.cart;
                let subTotal = data.subTotal;
                let subTotalWithShippingFee = data.subTotalWithShippingFee;
                this.shippingFee = data.shippingFee;
                this.$store.commit("setCart", cart);
                this.$store.commit("setSubTotal", subTotal);
                this.$store.commit("setSubTotalWithShippingFee", subTotalWithShippingFee);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
    },
    mounted() {
        this.findAll();
    }
}
</script>
