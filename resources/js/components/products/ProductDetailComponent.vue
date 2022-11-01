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
                                    <b-tab v-bind:title="'Đánh giá ('+totalReviews+')'">
                                        <div class="review_form field_form mgb-20">
                                            <h5>Thêm mới đánh giá</h5>
                                            <p v-if="userProfile == null" class="text-danger">Vui lòng
                                                <router-link :to="{ name: 'login'}">
                                                    Đăng nhập
                                                </router-link>
                                                để đánh giá!
                                            </p>
                                            <form class="row mt-3">
                                                <div class="form-group col-12">
                                                    <star-rating v-model="star"
                                                                 v-bind:show-rating="false"
                                                                 v-bind:star-size="18"
                                                                 v-bind:border-color="'#F6BC3E'"
                                                                 v-bind:inactive-color="'#FFFFFF'"
                                                                 v-bind:active-color="'#F6BC3E'"
                                                                 v-bind:border-width="3"
                                                                 v-bind:padding="1">
                                                    </star-rating>
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
                                        <div class="comments">
                                            <h5 class="product_tab_title">{{ totalReviews }} Đánh giá cho -
                                                <span>{{ product.name }}</span>
                                            </h5>
                                            <ul class="list_none comment_list mt-4">
                                                <li v-for="review in reviews"
                                                    :class="review.status ==1 ? 'o-05':''">
                                                    <div class="comment_img">
                                                        <img src="assets/images/user1.jpg" alt="user1"/>
                                                    </div>
                                                    <div class="comment_block">
                                                        <div class="rating_wrap">
                                                            <star-rating v-model="review.star"
                                                                         v-bind:show-rating="false"
                                                                         v-bind:star-size="10"
                                                                         v-bind:border-color="'#F6BC3E'"
                                                                         v-bind:inactive-color="'#FFFFFF'"
                                                                         v-bind:active-color="'#F6BC3E'"
                                                                         v-bind:border-width="1"
                                                                         v-bind:padding="1"
                                                                         v-bind:read-only="true">
                                                            </star-rating>
                                                            <div class="text-right" v-if="review.owner">
                                                                <a class="link-hover gray-8-color" title="Xóa"
                                                                   @click="remove(review.id)"><i
                                                                    class="fa fa-times" aria-hidden="true"></i></a>
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
                                                        <div v-if="review.status == 1" class="text-danger">Đang chờ phê
                                                            duyệt
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group col-12 text-center">
                                            <button type="button" v-if="hasMorePage && !isLoadingReview"
                                                    style="padding: 10px 28px"
                                                    class="btn btn-line-fill btn-sm rounded-0"
                                                    @click="paginate()"> Xem thêm
                                            </button>
                                        </div>
                                        <loading-component v-bind:loading="isLoadingReview"></loading-component>
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
import {serviceBus} from './../../serviceBus'

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
            star: 0,
            totalReviews: 0,
            reviewData: {},
            reviews: [],
            hasMorePage: false
        };
    },
    computed: {
        ...mapGetters([
            'userProfile'
        ])
    },
    methods: {
        review() {
            ReviewService.save({
                comment: this.comment,
                star: this.star,
                product_id: this.product.id
            }).then(response => {
                let review = response || {};
                this.reviews.unshift(review);
                this.totalReviews++;
                this.star = 0;
                this.comment = "";
            }).catch(e => {
            });
        },
        paginate() {
            this.isLoadingReview = true;
            let last_id = null;
            if (this.reviews.length > 0) last_id = this.reviews[this.reviews.length - 1].id;
            ReviewService.findByProduct(this.product.id, last_id).then(response => {
                let data = response || {};
                let reviews = data.data || [];
                this.hasMorePage = data.hasMorePage;
                this.reviews = this.reviews.concat(reviews);
                this.isLoadingReview = false;
            }).catch(e => {
                this.isLoadingReview = false;
            });
        },
        remove(id) {
            ReviewService.delete({
                id: id
            }).then(response => {
                let review = response || {};
                let removeIndex = null;
                for (let i = 0; i < this.reviews.length; i++) {
                    let item = this.reviews[i];
                    if (item.id === review.id) {
                        removeIndex = i;
                        break;
                    }
                }
                if (removeIndex != null) {
                    this.reviews.splice(removeIndex, 1);
                    this.totalReviews--;
                }
            }).catch(e => {

            });
        },
        findByProduct() {
            this.isLoadingReview = true;
            ReviewService.findByProduct(this.product.id).then(response => {
                let data = response || {};
                this.reviews = data.data || [];
                this.hasMorePage = data.hasMorePage;
                this.totalReviews = data.totalReviews;
                this.isLoadingReview = false;
            }).catch(e => {
                this.isLoadingReview = false;
            });
        }
    },
    mounted() {
        ProductService.detail(this.$route.params.id).then(response => {
            this.product = response || {};
            this.isLoading = false;
            this.findByProduct();
        }).catch(e => {
            this.isLoading = false;
        });

        serviceBus.$on('refreshReviews', () => {
            this.findByProduct();
        })
    }
}
</script>
