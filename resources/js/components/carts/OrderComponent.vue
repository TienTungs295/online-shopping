<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Thanh toán</h1>
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
                            <li class="breadcrumb-item active">Thanh toán</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content">

            <!-- START SECTION SHOP -->
            <div class="section pdt-30-i pdb-30-i">
                <div v-if="cartCount > 0 || isOrderSuccessful" class="container">
                    <!--                    <div class="row">-->
                    <!--                        <div class="col-lg-6">-->
                    <!--                            <div class="toggle_info">-->
                    <!--                                <span><i class="fas fa-user"></i>Returning customer? <a href="#loginform" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to login</a></span>-->
                    <!--                            </div>-->
                    <!--                            <div class="panel-collapse collapse login_form" id="loginform">-->
                    <!--                                <div class="panel-body">-->
                    <!--                                    <p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>-->
                    <!--                                    <form method="post">-->
                    <!--                                        <div class="form-group">-->
                    <!--                                            <input type="text" required="" class="form-control" name="email" placeholder="Username Or Email">-->
                    <!--                                        </div>-->
                    <!--                                        <div class="form-group">-->
                    <!--                                            <input class="form-control" required="" type="password" name="password" placeholder="Password">-->
                    <!--                                        </div>-->
                    <!--                                        <div class="login_footer form-group">-->
                    <!--                                            <div class="chek-form">-->
                    <!--                                                <div class="custome-checkbox">-->
                    <!--                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">-->
                    <!--                                                    <label class="form-check-label" for="remember"><span>Remember me</span></label>-->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                            <a href="#">Forgot password?</a>-->
                    <!--                                        </div>-->
                    <!--                                        <div class="form-group">-->
                    <!--                                            <button type="submit" class="btn btn-fill-out btn-block" name="login">Log in</button>-->
                    <!--                                        </div>-->
                    <!--                                    </form>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-lg-6">-->
                    <!--                            <div class="toggle_info">-->
                    <!--                                <span><i class="fas fa-tag"></i>Have a coupon? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>-->
                    <!--                            </div>-->
                    <!--                            <div class="panel-collapse collapse coupon_form" id="coupon">-->
                    <!--                                <div class="panel-body">-->
                    <!--                                    <p>If you have a coupon code, please apply it below.</p>-->
                    <!--                                    <div class="coupon field_form input-group">-->
                    <!--                                        <input type="text" value="" class="form-control" placeholder="Enter Coupon Code..">-->
                    <!--                                        <div class="input-group-append">-->
                    <!--                                            <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>-->
                    <!--                                        </div>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="row">-->
                    <!--                        <div class="col-12">-->
                    <!--                            <div class="medium_divider"></div>-->
                    <!--                            <div class="divider center_icon"><i class="linearicons-credit-card"></i></div>-->
                    <!--                            <div class="medium_divider"></div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="row">
                        <div class="col-lg-6 mgb-50 pdt-30">
                            <div v-if="isOrderSuccessful">
                                <div class="thank-you mgb-20">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <div class="d-inline-block">
                                        <h4 class="thank-you-sentence">
                                            Đơn đặt hàng đã thành công
                                        </h4>
                                        <p>Cảm ơn quý khách đã mua hàng!</p>
                                    </div>
                                </div>

                                <div class="order-customer-info mgb-40">
                                    <h4 class="mgb-20">Thông tin khách hàng</h4>
                                    <p>
                                        <span class="d-inline-block">Họ & tên:</span>
                                        <span class="order-customer-info-meta">{{ order_infomation.name }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Số điện thoại:</span>
                                        <span class="order-customer-info-meta">{{ order_infomation.phone }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Email:</span>
                                        <span class="order-customer-info-meta">{{ order_infomation.email }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Địa chỉ:</span>
                                        <span
                                            class="order-customer-info-meta">{{
                                                order_infomation.address
                                            }}, {{ order_infomation.wardName }}, {{
                                                order_infomation.districtName
                                            }}, {{ order_infomation.provinceName }}</span>
                                    </p>

                                    <p>
                                        <span class="d-inline-block">Phương thức thanh toán:</span>
                                        <span class="order-customer-info-meta">
                                            <span v-if="order_infomation.payment_method == 1">Chuyển khoản</span>
                                            <span v-if="order_infomation.payment_method == 2">Thanh toán khi nhận hàng (COD)</span>
                                        </span>
                                    </p>

                                </div>
                                <router-link class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                                             :to="{ name: 'home'}">
                                    Tiếp tục mua hàng
                                </router-link>
                            </div>
                            <div v-else>
                                <div class="heading_s1">
                                    <h4>Thông tin nhận hàng</h4>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Họ và tên <span
                                            class="text-danger">*</span></label>
                                        <input type="text" v-model="order.name" required class="form-control style-1"
                                               name="name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                        <input type="tel" v-model="order.phone" required class="form-control style-1"
                                               name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Email</label>
                                        <input type="email" v-model="order.email" required class="form-control style-1"
                                               name="email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Tỉnh thành<span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.province"
                                                    @change="changeProvince($event)"
                                                    name="province">
                                                <option value="">Chọn tỉnh thành</option>
                                                <option v-for="code in provinceCodes" v-bind:value="code">
                                                    {{ provinces[code].name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Quận huyện <span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.district"
                                                    @change="changeDistrict($event)"
                                                    name="district">
                                                <option value="">Chọn quận huyện</option>
                                                <option v-for="code in districtCodes" v-bind:value="code">
                                                    {{ districts[code].name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Phường xã <span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.ward" name="ward"
                                                    @change="changeWard($event)">
                                                <option value="">Chọn phường xã</option>
                                                <option v-for="code in wardCodes" v-bind:value="code">
                                                    {{ wards[code].name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Địa chỉ chi tiết <span
                                            class="text-danger">*</span></label>
                                        <input type="text" required v-model="order.address" class="form-control style-1"
                                               name="detailAddress">
                                    </div>
                                    <div class="heading_s1">
                                        <h4>Ghi chú</h4>
                                    </div>
                                    <div class="form-group mb-0">
                                    <textarea rows="4" class="form-control" required
                                              v-model="order.description"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="order_review" style="min-height: 910px">
                                <div class="heading_s1">
                                    <h4>Thông tin đơn hàng</h4>
                                </div>
                                <div id="cart-item" class="position-relative">
                                    <div class="row cart-item" v-for="(item, key) in cart">
                                        <div class="col-3">
                                            <div class="checkout-product-img-wrapper">
                                                <img :src="'/uploads/images/'+item.options.image"
                                                     :alt="item.options.image">
                                                <span class="checkout-quantity">{{ item.qty }}</span>
                                            </div>
                                        </div>
                                        <div class="col-5 ">
                                            <p class="mb-0 gray-color">{{ item.name }}</p>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="gray-color">{{ item.price | commaFormat }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-2 p-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="gray-color">Tạm tính:</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price-text sub-total-text text-right gray-color">
                                                    {{ subTotal | commaFormat }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="gray-color">Phí vận chuyển:</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price-text shipping-price-text text-right gray-color">
                                                    {{ order.shipping_fee | commaFormat }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="gray-color"><strong>Thành tiền</strong>:</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="total-text raw-total-text gray-color text-right"
                                                   :data-price="subTotalWithShippingFee"><strong>
                                                    {{ subTotalWithShippingFee | commaFormat }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="payment_method mgt-15">
                                    <div class="heading_s1">
                                        <h4>Phương thức thanh toán</h4>
                                    </div>
                                    <div class="payment_option">
                                        <div class="custome-radio">
                                            <input class="form-check-input" required="" type="radio"
                                                   name="payment_option" id="exampleRadios3"
                                                   v-model="order.payment_method" value="1" checked>
                                            <label class="form-check-label" for="exampleRadios3">Chuyển khoản</label>
                                            <p data-method="option3" class="payment-text">
                                                Quý khách vui lòng chờ xác nhận đơn hàng từ nhân viên Inbox/Order sau
                                                khi kiểm tra tình trạng còn hàng tại kho. Vui lòng KHÔNG chuyển khoản
                                                trước khi nhận được xác nhận từ nhân viên chốt đơn. 3M xin cảm ơn!
                                            </p>
                                        </div>
                                        <div class="custome-radio">
                                            <input class="form-check-input" type="radio" v-model="order.payment_method"
                                                   name="payment_option"
                                                   id="exampleRadios5" value="2">
                                            <label class="form-check-label" for="exampleRadios5">Thanh toán khi nhận
                                                hàng (COD)</label>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-fill-out btn-block rounded-0" @click="checkOut()">Đặt
                                    hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center container" v-else>Không có sản phẩm nào trong giỏ hàng</div>
            </div>
            <!-- END SECTION SHOP -->

        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>
import CartService from "../../services/CartService";
import OrderService from "../../services/OrderService";
import AddressService from "../../services/AddressService";
import {mapGetters} from "vuex";

export default {
    name: "Order",
    data() {
        return {
            order: {
                province: "",
                district: "",
                ward: "",
                payment_method: 1,
                shipping_fee: 0
            },
            order_infomation: {},
            isOrderSuccessful: false,
            provinces: {},
            districts: {},
            wards: {}
        };
    },
    computed: {
        ...mapGetters([
            'cart',
            'subTotal',
            'cartCount',
            'subTotalWithShippingFee',
        ]),
        provinceCodes: function () {
            return Object.keys(this.provinces).sort();
        },
        districtCodes: function () {
            return Object.keys(this.districts).sort();
        },
        wardCodes: function () {
            return Object.keys(this.wards).sort();
        }
    },
    methods: {
        checkOut() {
            this.order.subTotal = this.subTotal;
            OrderService.checkOut(this.order, true).then(response => {
                this.isOrderSuccessful = true;
                let data = response || {};
                this.order_infomation = data;
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
                let subTotalWithShippingFee = data.subTotalWithShippingFee;
                let total = data.total;
                this.order.shipping_fee = data.shippingFee;
                this.$store.commit("setCart", cart);
                this.$store.commit("setSubTotal", subTotal);
                this.$store.commit("setSubTotalWithShippingFee", subTotalWithShippingFee);
                this.$store.commit("setCartCount", total)
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },
        findProvinces() {
            AddressService.findProvinces().then(response => {
                this.provinces = response.data || {};
            }).catch(e => {
            });
        },
        findDistricts(parent_code) {
            AddressService.findDistricts(parent_code).then(response => {
                this.districts = response.data || {};
            }).catch(e => {
            });
        },
        findWards(parent_code) {
            AddressService.findWards(parent_code).then(response => {
                this.wards = response.data || {};
            }).catch(e => {
            });
        },
        changeProvince(event) {
            let code = event.target.value;
            this.order.provinceName = this.provinces[code].name;
            this.districts = {};
            this.order.district = "";
            this.order.districtName = "";
            this.wards = {};
            this.order.ward = "";
            this.order.wardName = "";
            if (code == "") return;
            this.findDistricts(code)
        },
        changeDistrict(event) {
            let code = event.target.value;
            this.order.districtName = this.districts[code].name;
            this.wards = {};
            this.order.ward = "";
            this.order.wardName = "";
            if (code == "") return;
            this.findWards(code)
        },
        changeWard(event) {
            let code = event.target.value
            this.order.wardName = this.wards[code].name;
        },
    },
    mounted() {
        this.findAllCart();
        this.findProvinces();
    }
}
</script>
