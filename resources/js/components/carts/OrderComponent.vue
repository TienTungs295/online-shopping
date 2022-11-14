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
        <div class="main_content position-relative">
            <loading-component v-bind:loading="isLoading"
                               v-bind:center="true"></loading-component>
            <!-- START SECTION SHOP -->
            <div class="section pdt-50-i pdb-50-i">
                <div v-if="cartCount > 0 && !isOrderSuccessful" class="container">
                    <div class="row">
                        <div class="col-lg-6 mgb-50 pdt-30">
                            <div>
                                <div class="heading_s1">
                                    <h4>Thông tin nhận hàng</h4>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Họ và tên <span
                                            class="text-danger">*</span></label>
                                        <input type="text" v-model="order.name" :class="{'is-invalid': errors.name}"
                                               required class="form-control style-1"
                                               name="name">
                                        <div class="invalid-feedback">
                                            <span v-for="error in errors.name" class="d-block">{{ error }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                        <input type="tel" v-model="order.phone" required
                                               :class="{'is-invalid': errors.phone}" class="form-control style-1"
                                               name="phone">
                                        <div class="invalid-feedback">
                                            <span v-for="error in errors.phone" class="d-block">{{ error }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Email</label>
                                        <input type="email" v-model="order.email" :class="{'is-invalid': errors.email}"
                                               required class="form-control style-1"
                                               name="email">
                                        <div class="invalid-feedback">
                                            <span v-for="error in errors.email" class="d-block">{{ error }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Tỉnh thành<span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.province"
                                                    :class="{'is-invalid': errors.province}"
                                                    @change="changeProvince($event)"
                                                    name="province">
                                                <option value="">Chọn tỉnh thành</option>
                                                <option v-for="code in provinceCodes" v-bind:value="code">
                                                    {{ provinces[code].name }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.province" class="d-block">{{
                                                        error
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Quận huyện <span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.district"
                                                    :class="{'is-invalid': errors.district}"
                                                    @change="changeDistrict($event)"
                                                    name="district">
                                                <option value="">Chọn quận huyện</option>
                                                <option v-for="code in districtCodes" v-bind:value="code">
                                                    {{ districts[code].name }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.district" class="d-block">{{
                                                        error
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Phường xã <span
                                            class="text-danger">*</span></label>
                                        <div class="custom_select style-1">
                                            <select class="form-control" v-model="order.ward" name="ward"
                                                    :class="{'is-invalid': errors.ward}"
                                                    @change="changeWard($event)">
                                                <option value="">Chọn phường xã</option>
                                                <option v-for="code in wardCodes" v-bind:value="code">
                                                    {{ wards[code].name }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.ward" class="d-block">{{ error }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label gray-color">Địa chỉ chi tiết <span
                                            class="text-danger">*</span></label>
                                        <input type="text" required v-model="order.address"
                                               :class="{'is-invalid': errors.address}" class="form-control style-1"
                                               name="detailAddress">
                                        <div class="invalid-feedback">
                                            <span v-for="error in errors.address" class="d-block">{{ error }}</span>
                                        </div>
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
                                                <img class="border-ccc" :src="'/uploads/images/'+item.options.image"
                                                     :alt="item.options.image">
                                                <span class="checkout-quantity">{{ item.qty }}</span>
                                            </div>
                                        </div>
                                        <div class="col-5 ">
                                            <p class="mb-0 gray-color">{{ item.name }}
                                                <span v-if="item.options.is_out_of_stock"
                                                      class="text-danger">(Hết hàng)</span>
                                            </p>
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
                                        <div class="row" v-if="order.activeDiscountCode != null && errors.code == null">
                                            <div class="col-6">
                                                <p class="gray-color">Mã giảm giá</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price-text shipping-price-text text-right gray-color">
                                                    -{{ order.discountValue | commaFormat }}</p>
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
                                                   :data-price="subTotalFinal"><strong>
                                                    {{ subTotalFinal | commaFormat }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mgt-25 mgb-25">
                                    <div class="coupon field_form input-group"
                                         v-if="order.activeDiscountCode == null">
                                        <input type="text" v-model="order.code"
                                               class="form-control form-control-sm"
                                               placeholder="Nhập mã giảm giá">
                                        <div class="input-group-append">
                                            <button class="btn btn-fill-out btn-sm rounded-0"
                                                    @click="applyCoupon()"
                                                    type="button">Áp dụng
                                            </button>
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.code">
                                                            <span v-for="error in errors.code"
                                                                  class="d-block text-left">{{ error }}</span>
                                        </div>
                                    </div>
                                    <div class="coupon field_form input-group" v-else>
                                        <div class="alert alert-success coupon-text mgb-0 form-control">
                                            <div style="margin-top: 3px">
                                                Mã giảm giá: {{ order.activeDiscountCode }}
                                            </div>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-fill-line rounded-0 view-cart"
                                                    @click="removeCoupon()"
                                                    type="button">Xóa
                                            </button>
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.code">
                                                            <span v-for="error in errors.code"
                                                                  class="d-block text-left">{{ error }}</span>
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
                <div class="container" v-if="isOrderSuccessful">
                    <div class="row">
                        <div class="col-12 mgb-50 pdt-30 text-center">
                            <div class="d-inline-block">
                                <div class="thank-you mgb-20 text-left">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <div class="d-inline-block">
                                        <h4 class="thank-you-sentence">
                                            Đơn đặt hàng đã thành công
                                        </h4>
                                        <p>Cảm ơn quý khách đã mua hàng!</p>
                                    </div>
                                </div>
                                <div class="order-customer-info mgb-40 text-left">
                                    <h4 class="mgb-20">Thông tin khách hàng</h4>
                                    <p>
                                        <span class="d-inline-block">Họ & tên:</span>
                                        <span class="order-customer-info-meta">{{ order_information.name }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Số điện thoại:</span>
                                        <span class="order-customer-info-meta">{{ order_information.phone }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Email:</span>
                                        <span class="order-customer-info-meta">{{ order_information.email }}</span>
                                    </p>
                                    <p>
                                        <span class="d-inline-block">Địa chỉ:</span>
                                        <span
                                            class="order-customer-info-meta">{{
                                                order_information.address
                                            }}, {{ order_information.ward_name }}, {{
                                                order_information.district_name
                                            }}, {{ order_information.province_name }}</span>
                                    </p>

                                    <p>
                                        <span class="d-inline-block">Phương thức thanh toán:</span>
                                        <span class="order-customer-info-meta">
                                            <span v-if="order_information.payment_method == 1">Chuyển khoản</span>
                                            <span v-if="order_information.payment_method == 2">Thanh toán khi nhận hàng (COD)</span>
                                        </span>
                                    </p>

                                </div>
                                <div class="text-left">
                                    <router-link class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                                                 :to="{ name: 'home'}">
                                        Tiếp tục mua hàng
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center container" v-if="cartCount == 0 && !isLoading && !isOrderSuccessful">Không có
                    sản phẩm nào trong giỏ hàng
                </div>
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
import {serviceBus} from "../../serviceBus";

export default {
    name: "Order",
    data() {
        return {
            order: {
                province: "",
                district: "",
                ward: "",
                payment_method: 1,
                shipping_fee: 0,
                activeDiscountCode: null,
                code: "",
                discountValue: 0,
                errors: {}
            },
            errors: {},
            order_information: {},
            isOrderSuccessful: false,
            provinces: {},
            districts: {},
            wards: {},
            isLoading: true
        };
    },
    computed: {
        ...mapGetters([
            'cart',
            'subTotal',
            'cartCount',
            'subTotalFinal',
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
            this.isLoading = true;
            this.order.subTotal = this.subTotal;
            OrderService.checkOut(this.order, true).then(response => {
                this.isOrderSuccessful = true;
                this.order_information = response || {};
                this.isLoading = false;
                serviceBus.$emit('refreshCart');
            }).catch(response => {
                this.errors = response.errors || {};
                this.isLoading = false;
            });
        },
        findAllCart() {
            this.isLoading = true;
            CartService.findAll().then(response => {
                let data = response || {};
                this.buildData(data);
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
            this.order.province_name = "";
            if (code != "")
                this.order.province_name = this.provinces[code].name;
            this.districts = {};
            this.order.district = "";
            this.order.district_name = "";
            this.wards = {};
            this.order.ward = "";
            this.order.ward_name = "";
            if (code == "") return;
            this.findDistricts(code)
        },
        changeDistrict(event) {
            let code = event.target.value;
            this.order.district_name = "";
            if (code != "")
                this.order.district_name = this.districts[code].name;
            this.wards = {};
            this.order.ward = "";
            this.order.ward_name = "";
            if (code == "") return;
            this.findWards(code)
        },
        changeWard(event) {
            let code = event.target.value;
            this.order.ward_name = "";
            if (code != "")
                this.order.ward_name = this.wards[code].name;
        },
        applyCoupon: function () {
            CartService.applyCoupon({code: this.order.code}, true).then(response => {
                let data = response || {};
                this.buildData(data);
            }).catch(e => {
            });
        },

        removeCoupon: function () {
            CartService.removeCoupon(true).then(response => {
                let data = response || {};
                this.buildData(data);
                this.order.code = "";
            }).catch(e => {
            });
        },
        buildData(data) {
            this.order.shipping_fee = data.shippingFee;
            this.order.activeDiscountCode = data.activeDiscountCode;
            this.order.discountValue = data.discountValue;
            this.errors = data.errors || {};
            this.$store.commit("setCart", data.cart);
            this.$store.commit("setSubTotal", data.subTotal);
            this.$store.commit("setSubTotalFinal", data.subTotalFinal);
            this.$store.commit("setCartCount", data.total);
        }
    },
    mounted() {
        this.findAllCart();
        this.findProvinces();
    }
}
</script>
