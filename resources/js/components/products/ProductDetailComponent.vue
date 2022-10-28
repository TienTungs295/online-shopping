<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chi tiết sản phẩm</h1>
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
                            <li v-if="product.category" class="breadcrumb-item"><a
                                href="#">{{ product.category.name }}</a></li>
                            <li class="breadcrumb-item active">{{ product.name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content" v-if="!isLoading">
            <!-- START SECTION SHOP -->
            <div class="section">
                <div class="container">
                    <product-quick-view-item-component v-bind:product="product"></product-quick-view-item-component>
                    <div class="row">
                        <div class="col-12">
                            <div class="large_divider clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-style3">
                                <b-tabs content-class="mt-3">
                                    <b-tab title="Mô tả" active><p v-html="product.description"></p></b-tab>
                                    <b-tab v-bind:title="'Đánh giá('+totalReviews+')'">
                                        <div class="comments">
                                            <h5 class="product_tab_title">{{ totalReviews }} Đánh giá cho -
                                                <span>{{ product.name }}</span>
                                            </h5>
                                            <ul class="list_none comment_list mt-4">
                                                <li v-for="review in reviews">
                                                    <div class="comment_img">
                                                        <img src="assets/images/user1.jpg" alt="user1"/>
                                                    </div>
                                                    <div class="comment_block">
                                                        <div class="rating_wrap">
                                                            <div class="rating">
                                                                <div class="product_rate" style="width:80%"></div>
                                                            </div>
                                                        </div>
                                                        <p class="customer_meta">
                                                            <span
                                                                class="review_author">{{ review.customer_name }}</span>
                                                            <span
                                                                class="comment-date">{{
                                                                    review.created_at | dateTimeFormat
                                                                }}</span>
                                                        </p>
                                                        <div class="description">
                                                            <p>{{ review.comment }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="review_form field_form">
                                            <h5>Thêm mới đánh giá</h5>
                                            <p v-if="userProfile == null" class="text-danger">Vui lòng
                                                <router-link :to="{ name: 'login'}">
                                                    Đăng nhập
                                                </router-link>
                                                để đánh giá!
                                            </p>
                                            <form class="row mt-3">
                                                <div class="form-group col-12">
                                                    <div class="star_rating">
                                                        <span data-value="1"><i class="far fa-star"></i></span>
                                                        <span data-value="2"><i class="far fa-star"></i></span>
                                                        <span data-value="3"><i class="far fa-star"></i></span>
                                                        <span data-value="4"><i class="far fa-star"></i></span>
                                                        <span data-value="5"><i class="far fa-star"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <textarea placeholder="Đánh giá của bạn"
                                                              :disabled="userProfile == null"
                                                              v-model="comment"
                                                              class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="form-group col-12">
                                                    <button type="button" class="btn btn-fill-out rounded-0"
                                                            @click="review()">
                                                        Đánh giá
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="small_divider"></div>
                            <div class="divider"></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_s1">
                                <h3>Sản phẩm liên quan</h3>
                            </div>
                            <div v-if="!isLoading"
                                 class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20"
                                 v-carousel
                                 data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                <div class="item" v-for="item in product.related_products"
                                     v-if="product.related_products != undefined && product.related_products.length">
                                    <product-item-component v-bind:item="item"></product-item-component>
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
import ProductService from "../../services/ProductService";
import ReviewService from "../../services/ReviewService";
import {mapGetters} from 'vuex';

export default {
    name: "ProductDetail",
    data() {
        return {
            product: {
                images: []
            },
            isLoading: true,
            isLoadingReview: true,
            comment: "",
            star: 5,
            reviews: [],
            totalReviews: 0,
        };
    },
    computed: {
        ...mapGetters([
            'userProfile'
        ])
    },
    methods: {
        review() {
            if ((this.comment != null && this.comment.trim() === "") || this.comment == null) return;
            ReviewService.save({
                comment: this.comment,
                star: this.star,
                product_id: this.product.id
            }).then(response => {
                let review = response.data || {};
            }).catch(e => {
            });
        }
    },
    mounted() {
        ProductService.detail(this.$route.params.id).then(response => {
            this.product = response || {};
            this.isLoading = false;

            ReviewService.findByProduct(this.product.id).then(response => {
                this.reviews = response.data || {};
                this.isLoadingReview = false;
            }).catch(e => {
                this.isLoadingReview = false;
            });

            ReviewService.countByProduct(this.product.id).then(response => {
                this.totalReviews = response;
            }).catch(e => {
            });

        }).catch(e => {
            this.isLoading = false;
        });

    }
}
</script>
