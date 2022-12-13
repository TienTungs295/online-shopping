<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h4 v-if="param.name" class="mgb-0-i">Kết quả tìm kiếm cho từ khóa "{{ param.name }}"</h4>
                            <h1 v-else>Danh sách sản phẩm</h1>
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
                            <li class="breadcrumb-item active">
                                <router-link
                                    :to="{ name: 'productList'}">
                                    Sản phẩm
                                </router-link>
                            </li>
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
                        <div class="col-lg-9">
                            <div class="row align-items-center mb-4 pb-1">
                                <div class="col-12">
                                    <div class="product_header">
                                        <div class="product_header_left">
                                            <div class="custom_select">
                                                <select v-model="param.sort" class="form-control form-control-sm"
                                                        @change="changeSortType()">
                                                    <option v-for="item in sortOptions" v-bind:value="item.key">
                                                        {{ item.value }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="product_header_right">
                                            <div class="products_view">
                                                <a class="shorting_icon"
                                                   :class="isGridView ? 'active' :''"
                                                   @click="changeView('grid-view')"><i
                                                    class="ti-view-grid"></i></a>
                                                <a class="shorting_icon list"
                                                   :class="!isGridView ? 'active' :''"
                                                   @click="changeView('list-view')"><i
                                                    class="ti-layout-list-thumb"></i></a>
                                            </div>
                                            <div class="custom_select">
                                                <select v-model="param.page_size" class="form-control form-control-sm"
                                                        @change="changePageSize()">
                                                    <option v-for="item in pageSizeOptions" v-bind:value="item.key">
                                                        {{ item.value }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row shop_container"
                                 :class="isGridView ? 'grid-view' :'list-view'">
                                <div class="col-md-4 col-6" v-for="item in paginate.data">
                                    <product-item-component v-bind:item="item"></product-item-component>
                                </div>
                                <div class="col text-center"
                                     v-if="!isLoadingProduct && (paginate.data == null || paginate.data.length == 0)">
                                    Không tìm thấy kết quả phù hợp.
                                </div>
                                <loading-component v-bind:loading="isLoadingProduct"
                                                   v-bind:center="true"></loading-component>
                            </div>
                            <div class="row">
                                <div class="col-12"
                                     v-if="paginate.last_page > 1 && paginate.data && paginate.data.length">
                                    <ul class="pagination mt-3 justify-content-center pagination_style1">
                                        <li class="page-item" :class="paginate.prev_page_url == null ? 'disabled' : ''">
                                            <a v-if="paginate.prev_page_url != null" class="page-link"
                                               @click="changePage(paginate.current_page - 1)">
                                                <i class="linearicons-arrow-left"></i>
                                            </a>
                                            <a class="page-link" v-else>
                                                <i class="linearicons-arrow-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item" :class="paginate.current_page == i ? 'active' :''"
                                            v-for="i in paginate.last_page">
                                            <a class="page-link" v-if="paginate.current_page != i"
                                               @click="changePage(i)">{{ i }}</a>
                                            <a class="page-link cursor-default" v-else>{{ i }}</a>
                                        </li>
                                        <li class="page-item" :class="paginate.next_page_url == null ? 'disabled' : ''">
                                            <a v-if="paginate.next_page_url != null" class="page-link"
                                               @click="changePage(paginate.current_page + 1)">
                                                <i class="linearicons-arrow-right"></i>
                                            </a>
                                            <a class="page-link" v-else>
                                                <i class="linearicons-arrow-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                            <div class="sidebar">
                                <div class="widget">
                                    <h5 class="widget_title">Danh mục</h5>
                                    <ul class="widget_categories">
                                        <li :class="param.category_id == null ? 'active' :''">
                                            <a><span class="categories_name"
                                                     @click="changeCategory(null)">Tất cả</span></a>
                                        </li>
                                    </ul>
                                    <tree-category-component v-if="categories.length > 0" v-bind:categories="categories"
                                                             v-bind:category_id="category_id"></tree-category-component>
                                </div>
                                <div class="widget">
                                    <h5 class="widget_title">Giá</h5>
                                    <div class="filter_price">
                                        <div class="custome-radio" v-for="item in priceOptions" @change="changePrice()">
                                            <input class="form-check-input" v-model="param.price" type="radio"
                                                   name="price" :id="item.id"
                                                   v-bind:value="item.key">
                                            <label class="form-check-label" :for="item.id">{{ item.value }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h5 class="widget_title">Bộ sưu tập</h5>
                                    <ul class="list_brand">
                                        <li v-for="item in collections">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input"
                                                       :checked="collection_ids.indexOf(item.id+'') != -1"
                                                       @click="chooseCollection($event)"
                                                       type="checkbox" name="checkbox"
                                                       :id="item.id" :value="item.id">
                                                <label class="form-check-label"
                                                       :for="item.id"><span>{{ item.name }}</span></label>
                                            </div>
                                        </li>
                                    </ul>
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
import CollectionService from "../../services/CollectionService";
import CategoryService from "../../services/CategoryService";
import {mapGetters} from "vuex";
import {serviceBus} from "../../serviceBus";

export default {
    name: "ProductList",
    data() {
        return {
            paginate: {},
            param: {},
            collection_ids: [],
            price: "",
            isLoadingProduct: true,
            isLoadingCategory: true,
            isLoadingCollection: true,
            isGridView: true,
            checkedNames: [],
            category_parent_ids: [],
            category_id: null
        };
    },
    computed: {
        ...mapGetters([
            'categories',
            'collections',
            'refreshCategory',
            'pageSizeOptions',
            'sortOptions',
            'priceOptions',
        ])
    },
    methods: {
        changeRouter: function () {
            let param = {};
            if (this.collection_ids.length > 0) param.collection_ids = JSON.stringify(this.collection_ids);
            if (this.param.category_id != null && this.param.category_id != "") param.category_id = this.param.category_id;
            if (this.param.price != null && this.param.price != "") param.price = this.param.price;
            if (this.param.sort != null && this.param.sort != "") param.sort = this.param.sort;
            if (this.param.page != null && this.param.page != "") param.page = this.param.page;
            if (this.param.page_size != null && this.param.page_size != "") param.page_size = this.param.page_size;
            this.$router.push({name: 'productList', query: param}).catch(() => {
            });

        },
        changePrice: function (value) {
            this.changeRouter();
        },
        chooseCollection: function (event) {
            let value = event.target.value;
            let index = this.collection_ids.indexOf(value);
            if (index == -1) this.collection_ids.push(value);
            else this.collection_ids.splice(index, 1);
            this.changeRouter();
        },
        changeCategory: function (value) {
            if (this.param.category_id == value) return;
            this.param.category_id = value;
            this.category_id = value;
            this.changeRouter();
        },
        changePageSize: function () {
            this.param.page = 1;
            this.changeRouter();
        },
        changeSortType: function () {
            this.changeRouter();
        },
        changePage: function (value) {
            if (this.param.page == value) return;
            this.param.page = value;
            this.changeRouter();
        },
        changeView: function (value) {
            this.isGridView = value == 'grid-view';
        },
        initCategories(categories) {
            if (categories.length > 0) {
                for (const category of categories) {
                    if (this.category_parent_ids.indexOf(category.id) == -1) {
                        category.is_expand = false;
                        category.is_show = false;
                    } else {
                        category.is_expand = true;
                        category.is_show = true;
                    }
                    if (this.param.category_id == category.id) category.is_show = true;
                    if (category.childs.length > 0) {
                        this.initCategories(category.childs);
                    }
                }
            }
        }
    },
    mounted() {
        if (this.$route.query.collection_ids != null
            && this.$route.query.collection_ids != ""
            && this.$route.query.collection_ids != undefined) {
            this.collection_ids = JSON.parse(this.$route.query.collection_ids);
            this.param.collection_ids = this.collection_ids;
        }
        this.param.name = this.$route.query.name || "";
        this.param.category_id = this.$route.query.category_id || null;
        this.category_id = this.$route.query.category_id || null;
        this.param.price = this.$route.query.price || "";
        this.param.sort = this.$route.query.sort || "";
        this.param.page_size = this.$route.query.page_size || "";
        if (this.$route.query.page != null && this.$route.query.page != "" && this.$route.query.page != undefined) {
            this.param.page = this.$route.query.page;
        }

        let pageSizeOptions = [
            {
                key: "",
                value: "Đang hiển thị"
            },
            {
                key: 9,
                value: 9
            },
            {
                key: 12,
                value: 12
            },
            {
                key: 15,
                value: 15
            },
        ];
        let sortOptions = [
            {
                key: "",
                value: "Mặc định"
            },
            {
                key: "date_asc",
                value: "Cũ nhất"
            },
            {
                key: "date_desc",
                value: "Mới nhất"
            },
            {
                key: "price_asc",
                value: "Giá: Thấp đến cao"
            },
            {
                key: "price_desc",
                value: "Giá: Cao đến thấp"
            },
            {
                key: "name_asc",
                value: "Tên: A - Z"
            },
            {
                key: "name_desc",
                value: "Tên: Z - A"
            },
        ];
        let priceOptions = [
            {
                key: "",
                id: "radio0",
                value: "Tất cả"
            },
            {
                key: "option1",
                id: "radio1",
                value: "Nhỏ hơn 50,000₫"
            },
            {
                key: "option2",
                id: "radio2",
                value: "Từ 50,000₫ - 100,000₫"
            },
            {
                key: "option3",
                id: "radio3",
                value: "Từ 100,000₫ - 200,000₫"
            },
            {
                key: "option4",
                id: "radio4",
                value: "Từ 200,000₫ - 500,000₫"
            },
            {
                key: "option5",
                id: "radio5",
                value: "Từ 500,000₫ - 1000,000₫"
            },
            {
                key: "option6",
                id: "radio6",
                value: "Lớn hơn 1000,000₫"
            },
            {
                key: "option7",
                id: "radio7",
                value: "Liên hệ"
            }
        ];
        this.$store.commit("setPageSizeOptions", pageSizeOptions);
        this.$store.commit("setSortOptions", sortOptions);
        this.$store.commit("setPriceOptions", priceOptions);

        CollectionService.findAll().then(response => {
            let collections = response || [];
            this.$store.commit("setCollections", collections);
            this.isLoadingCollection = false;
        }).catch(e => {
            this.isLoadingCollection = false;
        });

        ProductService.findAll(this.param, this.param.page).then(response => {
            let restData = response || {};
            this.paginate = restData.products || {};
            this.category_parent_ids = restData.category_parent_ids || [];
            this.isLoadingProduct = false;
            CategoryService.findAll().then(response => {
                let categories = response || [];
                if (this.refreshCategory) {
                    this.$store.commit("setCategories", categories);
                    this.initCategories(this.categories);
                }
                this.isLoadingCategory = false;
            }).catch(e => {
                this.isLoadingCategory = false;
            });
        }).catch(e => {
            this.isLoadingProduct = false;
        });
        serviceBus.$on('changeCategory', (category_id) => {
            this.changeCategory(category_id);
        })
    }
}
</script>
