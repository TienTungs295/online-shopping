<template>
    <div>
        <!-- START HEADER -->
        <header class="header_wrap">
            <div class="header-inner">
                <div class="top-header light_skin bg_primary d-none d-md-block">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-8">
                                <div class="header_topbar_info">
                                    <div class="header_offer border-0">
                                        <span>Free ship đơn hàng trên 1,000,000 đ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <div class="download_wrap">
                                        <ul class="icon_list text-center text-lg-left">
                                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                            <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="light-color mgl-5">
                                        <!--                                    <router-link :to="{ name: 'contact-us'}" class="light-color-i">-->
                                        <!--                                        <i class="ion-map mgr-5"></i>-->
                                        <!--                                        <span>Liên hệ</span>-->
                                        <!--                                    </router-link>-->


                                        <b-dropdown v-if="userProfile != null" variant="link" no-caret
                                                    class="custom-dropdown" toggle-class="text-decoration-none">
                                            <template #button-content>
                                                <div
                                                    class="light-color-i">
                                                    <i class="ti-user mgr-5" style="font-size: 14px"></i>
                                                    <span class="mgr-5">{{ userProfile.name }}</span> <i
                                                    class="ti-angle-down" style="font-size: 14px"></i>
                                                </div>
                                            </template>
                                            <b-dropdown-item>
                                                <router-link :to="{ name: 'userProfile'}">
                                                    Thông tin tài khoản
                                                </router-link>
                                            </b-dropdown-item>
                                            <b-dropdown-item>
                                                <router-link :to="{ name: 'changePass'}">
                                                    Thay đổi mật khẩu
                                                </router-link>
                                            </b-dropdown-item>
                                            <b-dropdown-item @click="logout()">Đăng xuất</b-dropdown-item>
                                        </b-dropdown>
                                        <div v-else
                                             style="position: relative; display: inline-flex;vertical-align: middle;">
                                            <router-link :to="{ name: 'login'}" class="light-color-i">
                                                <span class="position-relative" style="bottom: 2px">Đăng nhập/Đăng ký</span>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="middle-header dark_skin">
                    <div class="container">
                        <div class="nav_block">
                            <router-link class="navbar-brand"
                                         :to="{ name: 'home'}">
                                <img class="logo_light" src="/assets/images/logo/logo.png" alt="logo">
                                <img class="logo_dark" src="/assets/images/logo/logo.png" alt="logo">
                            </router-link>
                            <div class="product_search_form search_form_btn">
                                <form>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="custom_select">
                                                <select class="first_null not_chosen" v-model="query.category_id">
                                                    <option value="">Danh mục</option>
                                                    <option v-for="item in categories" v-bind:value="item.id">
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="query.name" placeholder="Tên sản phẩm..."
                                               required="" type="text">
                                        <button type="button" class="search_btn3" @click="findProduct()">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                            <div class="contact_phone contact_support">
                                <i class="linearicons-phone-wave"></i>
                                <span>0123456789</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom_header dark_skin main_menu_uppercase border-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                            <div class="categories_wrap">
                                <button type="button" data-toggle="collapse" data-target="#navCatContent"
                                        aria-expanded="false" class="categories_btn categories_menu">
                                    <span>Danh mục <span class="hidden-lg">sản phẩm</span></span><i class="linearicons-menu"></i>
                                </button>
                                <div id="navCatContent" class="navbar collapse">
                                    <ul>
                                        <li class="dropdown" v-for="(item,index) in categories" v-if="index < 10">
                                            <router-link
                                                :to="{ name: 'productList', query: { category_id: item.id}}"
                                                class="dropdown-item nav-link">
                                                <span>{{ item.name }}</span>
                                            </router-link>
                                        </li>
                                        <li>
                                            <ul class="more_slide_open">
                                                <li v-for="(item,index) in categories" v-if="index>=10">
                                                    <router-link
                                                        :to="{ name: 'productList', query: { category_id: item.id}}"
                                                        class="dropdown-item nav-link nav_item">
                                                        <span>{{ item.name }}</span>
                                                    </router-link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="more_categories">Xêm Thêm</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                            <nav class="navbar navbar-expand-lg">
                                <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSidetoggle" aria-expanded="false">
                                    <span class="ion-android-menu"></span>
                                </button>
                                <div class="pr_search_icon">
                                    <a href="javascript:void(0);" class="nav-link pr_search_trigger pdl-5"><i
                                        class="linearicons-magnifier"></i></a>
                                </div>
                                <div class="pr_user_icon">
                                    <b-dropdown v-if="userProfile != null" variant="link" no-caret split-class="test"
                                                class="custom-dropdown no-border-link" toggle-class="text-decoration-none">
                                        <template #button-content>
                                            <a href="javascript:void(0);" class="nav-link position-relative" style="padding: 17px 5px; top:2px"><i
                                                class="linearicons-user" style="font-size: 20px"></i></a>
                                        </template>
                                        <b-dropdown-item>
                                            <router-link :to="{ name: 'userProfile'}">
                                                Thông tin tài khoản
                                            </router-link>
                                        </b-dropdown-item>
                                        <b-dropdown-item>
                                            <router-link :to="{ name: 'changePass'}">
                                                Thay đổi mật khẩu
                                            </router-link>
                                        </b-dropdown-item>
                                        <b-dropdown-item @click="logout()">Đăng xuất</b-dropdown-item>
                                    </b-dropdown>
                                    <div v-else>
                                        <router-link :to="{ name: 'login'}" class="nav-link pr_user_trigger pdl-5-i pdr-5-i">
                                            <i class="linearicons-key"></i>
                                        </router-link>
                                    </div>
                                </div>
                                <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                                    <ul class="navbar-nav">
                                        <li class="dropdown">
                                            <router-link class="nav-link nav-link" :to="{ name: 'home'}">Trang chủ
                                            </router-link>
                                        </li>
                                        <li class="dropdown">
                                            <router-link class="nav-link nav-link" :to="{ name: 'productList'}">Sản
                                                phẩm
                                            </router-link>
                                        </li>
                                        <li class="dropdown">
                                            <router-link class="nav-link nav-link" :to="{ name: 'blogList'}">Tin tức &
                                                sự kiện
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link class="nav-link nav_item" :to="{ name: 'contact-us'}">Liên hệ
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="navbar-nav attr-nav align-items-center">
                                        <!--                                        <li><a href="#" class="nav-link"><i class="linearicons-user"></i></a></li>-->
                                        <li>
                                            <router-link class="nav-link"
                                                         :to="{ name: 'withList'}">
                                                <i class="linearicons-heart"></i><span
                                                class="wishlist_count">{{ withListCount }}</span>
                                            </router-link>
                                        </li>
                                        <li class="dropdown cart_dropdown">
                                            <a class="nav-link cart_trigger" data-toggle="dropdown">
                                                <i class="linearicons-bag2"></i>
                                                <span class="cart_count" style="left: -4px">
                                                    {{ cartCount }}
                                                </span>
                                            </a>
                                            <div class="cart_box cart_right dropdown-menu dropdown-menu-right">
                                                <div v-if="cartCount > 0">
                                                    <ul class="cart_list">
                                                        <li v-for="(item, key) in cart">
                                                            <a class="item_remove" @click="removeFromCart(key)"><i
                                                                class="ion-close"></i></a>
                                                            <router-link
                                                                :to="{ name: 'productDetail', params: { slug: item.options.slug,id:item.id }}">
                                                                <img class="style-1"
                                                                     :src="'/uploads/images/'+item.options.image"
                                                                     :alt="item.options.image">
                                                                {{ item.name }}
                                                            </router-link>
                                                            <span class="cart_quantity"> {{ item.qty }} x {{
                                                                    item.price |commaFormat
                                                                }}
                                                                <!--                                                            <span class="cart_amount">-->
                                                                <!--                                                                <span class="price_symbole">đ-->
                                                                <!--                                                                </span>-->
                                                                <!--                                                            </span>-->
                                                        </span>
                                                        </li>
                                                    </ul>
                                                    <div class="cart_footer">
                                                        <p class="cart_total"><strong>Thành
                                                            tiền:</strong>{{ subTotal |commaFormat }}
                                                            <!--                                                            <span-->
                                                            <!--                                                                class="cart_price"> <span-->
                                                            <!--                                                                class="price_symbole">đ</span></span>-->
                                                        </p>
                                                        <p class="cart_buttons">
                                                            <router-link :to="{name:'cart'}"
                                                                         class="btn btn-fill-line rounded-0 view-cart">
                                                                Giỏ hàng
                                                            </router-link>
                                                            <router-link :to="{name:'order'}"
                                                                         class="btn btn-fill-out rounded-0 checkout">
                                                                Thanh toán
                                                            </router-link>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-center pd-15" v-else>
                                                    Không có sản phẩm nào trong giỏ hàng
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER -->
    </div>

</template>

<script>
import CategoryService from "../../services/CategoryService";
import WithListService from "../../services/WithListService";
import CartService from "../../services/CartService";
import {mapGetters} from 'vuex'
import AuthService from "../../services/AuthService";
import {serviceBus} from './../../serviceBus'


export default {
    name: "Header",
    data() {
        return {
            categories: [],
            query: {
                category_id: "",
                name: ""
            }
        };
    },
    computed: {
        ...mapGetters([
            'withListCount',
            'cartCount',
            'cart',
            'subTotal',
            'isLoggedIn',
            'userProfile'
        ])
    },
    methods: {
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
                this.buildData(data);
                this.isLoading = false;
            }).catch(e => {
                this.isLoading = false;
            });
        },

        removeFromCart: function (id) {
            CartService.remove({row_id: id}, true).then(response => {
                let data = response || {};
                this.buildData(data);
            }).catch(e => {
            });
        },
        findProduct() {
            let param = {};
            if (this.query.category_id != "") param.category_id = this.query.category_id;
            if (this.query.name.trim() != "") param.name = this.query.name;
            let emptyObject = jQuery.isEmptyObject(param);
            if (!emptyObject)
                this.$router.push({name: 'productList', query: param});
            this.query = {
                category_id: "",
                name: ""
            };
        },
        logout() {
            AuthService.logout().then(response => {
                localStorage.removeItem('access_token');
                this.$store.commit("setUserProfile", null);
                let routerName = this.$router.history.current.name;
                this.$store.commit("setWithListCount", 0);
                if (routerName == "userProfile" || routerName == "changePass" || routerName == "withList") {
                    this.$router.push({name: "login"});
                } else if (routerName == "productDetail") {
                    serviceBus.$emit('refreshReviews');
                }
            }).catch(response => {
            });
        },
        buildData(data) {
            this.$store.commit("setCart", data.cart);
            this.$store.commit("setSubTotal", data.subTotal);
            this.$store.commit("setSubTotalFinal", data.subTotalFinal);
            this.$store.commit("setSubTotalFinal", data.subTotalFinal);
            this.$store.commit("setCartCount", data.total)
        }
    },
    mounted() {
        CategoryService.findAll().then(response => {
            let data = response || [];
            this.categories = data;
        }).catch(e => {
        });
        this.findAllWithList();
        this.findAllCart();
        serviceBus.$on('refreshWithList', () => {
            this.findAllWithList();
        });

        serviceBus.$on('refreshCart', () => {
            this.findAllCart();
        });
    }
}
</script>
