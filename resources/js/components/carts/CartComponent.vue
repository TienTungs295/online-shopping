<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Giỏ hàng</h1>
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
                            <li class="breadcrumb-item active">Giỏ hàng</li>
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
                            <div class="table-responsive shop_cart_table">
                                <table class="table" v-if="cartCount > 0">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Thành tiền</th>
                                        <th class="product-remove">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, key) in cart">
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
                                            <span class="price">{{ item.price | commaFormat }}</span>
                                            <del v-if="item.options.on_sale">{{ item.options.price | commaFormat }}
                                            </del>
                                        </td>
                                        <td class="product-quantity" data-title="Số lượng">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus" @click="minus(item)">
                                                <input type="text" name="quantity" v-model="item.qty" title="Qty"
                                                       class="qty"
                                                       size="4">
                                                <input type="button" value="+" class="plus" @click="plus(item)">
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Thành tiền">
                                            {{ parseInt(item.subtotal) | commaFormat }}
                                        </td>
                                        <td class="product-remove" data-title="Thao tác"><a @click="remove(key)"><i
                                            class="ti-close"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6" class="px-0">
                                            <div class="row no-gutters align-items-center">

                                                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                                    <!--                                                    <div class="coupon field_form input-group">-->
                                                    <!--                                                        <input type="text" value="" class="form-control form-control-sm"-->
                                                    <!--                                                               placeholder="Enter Coupon Code..">-->
                                                    <!--                                                        <div class="input-group-append">-->
                                                    <!--                                                            <button class="btn btn-fill-out btn-sm" type="submit">Apply-->
                                                    <!--                                                                Coupon-->
                                                    <!--                                                            </button>-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->
                                                </div>
                                                <div class="col-lg-8 col-md-6 text-left text-md-right">
                                                    <button class="btn btn-line-fill btn-sm" type="button"
                                                            @click="update(cart)">Cập nhật
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="text-center" v-else>Không có sản phẩm nào trong giỏ hàng</div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="withListCount > 0">
                        <div class="col-12">
                            <div class="medium_divider"></div>
                            <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" v-if="cartCount > 0">
                            <div class="border p-3 p-md-4">
                                <div class="heading_s1 mb-3">
                                    <h6>Đơn hàng</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="cart_total_label">Tạm tính</td>
                                            <td class="cart_total_amount">{{ subTotal | commaFormat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Phí vận chuyển</td>
                                            <td class="cart_total_amount">{{ shippingFee | commaFormat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Thành tiền</td>
                                            <td class="cart_total_amount">
                                                <strong>
                                                    {{ subTotalWithShippingFee | commaFormat }}
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <router-link :to="{name:'order'}"
                                             class="btn btn-fill-out rounded-0">
                                    Tiến hành thanh toán
                                </router-link>
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
import CartService from "../../services/CartService";
import {mapGetters} from "vuex";

export default {
    name: "Cart",
    data() {
        return {
            isLoading: true,
            shippingFee: 0,
        };
    },
    computed: {
        ...mapGetters([
            'cart',
            'subTotal',
            'cartCount',
            'subTotalWithShippingFee',
        ])
    },
    methods: {
        remove: function (id) {
            CartService.remove({row_id: id}, true).then(response => {
                let item = response || [];
                this.findAll();
                this.countCart();
            }).catch(e => {
            });
        },

        findAll() {
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

        update: function (cart) {
            CartService.update({cart: cart}, true).then(response => {
                let item = response || [];
                this.findAll();
                this.countCart();
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

        plus: function (item) {
            item.qty++
        },

        minus: function (item) {
            if (item.qty == 0) return;
            item.qty--
        },

    },
    mounted() {
        this.findAll();
    }
}
</script>
