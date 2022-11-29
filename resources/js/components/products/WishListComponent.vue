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
            <div class="section pdt-50-i pdb-50-i">
                <div class="container">
                    <div class="row">
                        <div class="col-12 position-relative">
                            <loading-component v-bind:loading="isLoading"
                                               v-bind:center="true"></loading-component>
                            <div>
                                <div class="table-responsive wishlist_table" v-if="withListCount > 0">
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
                                                    <img class="border-ccc"
                                                         :src="'/uploads/images/'+item.options.image" @error="setDefaultImg"
                                                         :alt="item.options.image">
                                                </router-link>
                                            </td>
                                            <td class="product-name" data-title="Sản phẩm">
                                                <router-link
                                                    :to="{ name: 'productDetail', params: { slug: item.options.slug,id:item.id }}">
                                                    {{ item.name }}
                                                </router-link>
                                                <span v-if="item.options.is_out_of_stock"
                                                      class="text-danger">(Hết hàng)</span>
                                            </td>
                                            <td class="product-price" data-title="Giá">
                                                <div v-if="item.options.is_contact">
                                                    <span class="price">Liên hệ</span>
                                                </div>
                                                <div v-else>
                                                    <span class="price">{{ item.price | commaFormat }}</span>
                                                    <del v-if="item.options.on_sale">{{
                                                            item.options.price | commaFormat
                                                        }}
                                                    </del>
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Thêm vào giỏ">
                                                <a href="tel:0979945555" v-if="item.options.is_contact"
                                                   class="btn btn-fill-out btn-sm add-to-cart-button rounded-0">Liên
                                                    hệ ngay
                                                </a>
                                                <button v-else @click="addToCart(item.id)"
                                                        :disabled="item.options.is_out_of_stock"
                                                        class="btn btn-fill-out btn-sm add-to-cart-button rounded-0">
                                                    Thêm
                                                    vào giỏ
                                                </button>
                                            </td>
                                            <td class="product-remove" data-title="Xóa"><a
                                                class="btn btn-fill-line view-cart rounded-0 btn-sm rounded-0"
                                                @click="remove(key)">Xóa</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" v-if="withListCount == 0 && !isLoading">Không có sản phẩm
                                    nào trong danh sách
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
import WithListService from "../../services/WithListService";
import CartService from "../../services/CartService";
import {mapGetters} from "vuex";
import AuthService from "../../services/AuthService";

export default {
    name: "Wishlist",
    data() {
        return {
            isLoading: true,
        };
    },
    computed: {
        ...mapGetters([
            'withListCount',
            'withList',
        ])
    },
    methods: {
        remove: function (id) {
            WithListService.delete({row_id: id}, true).then(response => {
                let item = response || [];
                this.findAll();
            }).catch(e => {
            });
        },
        findAll() {
            this.isLoading = true;
            WithListService.findAll().then(response => {
                let data = response || {};
                this.$store.commit("setWithList", data.with_list);
                this.$store.commit("setWithListCount", data.total);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        addToCart: function (product_id) {
            CartService.add({product_id: product_id, qty: 1}, true).then(response => {
                this.findAllCart();
            }).catch(e => {
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
        setDefaultImg(event){
            event.target.src = window.location.protocol + "//" + window.location.host+'/assets/images/default/placeholder.png'
        }
    },
    created() {
        AuthService.isAuthenticated(true).then(response => {
        }).catch(response => {
        });
    },
    mounted() {
        this.findAll();
    }
}
</script>
