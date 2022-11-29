<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Tin tức & sự kiện</h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="#">Tin tức & sự kiện</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content position-relative">

            <!-- START SECTION BLOG -->
            <div class="section">
                <div class="container position-relative">
                    <loading-component v-bind:loading="isLoading" v-bind:center="true"></loading-component>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row blog_thumbs">
                                <div class="col-12" v-for="item in paginate.data">
                                    <div class="blog_post blog_style2">
                                        <div class="blog_img border-ccc">
                                            <router-link class="link_wrapper"
                                                         :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                <img :src="'/uploads/images/'+item.image" :alt="item.image" @error="setDefaultImg">
                                            </router-link>
                                        </div>
                                        <div class="blog_content bg-white">
                                            <div class="blog_text">
                                                <h6 class="blog_title">
                                                    <router-link
                                                        :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                        {{ item.name }}
                                                    </router-link>
                                                </h6>
                                                <ul class="list_none blog_meta">
                                                    <li><i
                                                        class="ti-calendar mgr-5-i color_primary"></i>
                                                        {{ item.updated_at |dateFormat }}
                                                    </li>
                                                </ul>
                                                <p class="break-word" v-html="item.excerpt_content2"></p>
                                                <router-link
                                                    :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                    <button class="btn btn-fill-line border-2 btn-sm rounded-0">Xem thêm
                                                    </button>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2 mt-md-4"
                                     v-if="paginate.last_page > 1 &&paginate.data && paginate.data.length">
                                    <ul class="pagination pagination_style1 justify-content-center">
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
                        <div class="col-xl-3 mt-4 pt-2 mt-xl-0 pt-xl-0">
                            <div class="sidebar">
                                <div class="widget">
                                    <h5 class="widget_title">Bài viết gần đây</h5>
                                    <ul class="widget_recent_post">
                                        <li v-for="item in recentBlogs">
                                            <div class="post_footer">
                                                <div class="post_img border-ccc">
                                                    <router-link
                                                        :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                        <img :src="'/uploads/images/'+item.image" :alt="item.image" @error="setDefaultImg">
                                                    </router-link>
                                                </div>
                                                <div class="post_content">
                                                    <h6>
                                                        <router-link
                                                            :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                            {{ item.name }}
                                                        </router-link>
                                                    </h6>
                                                    <p class="small m-0"> {{ item.updated_at|dateFormat }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION BLOG -->
        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>
import BlogService from "../../services/BlogService";

export default {
    name: "BlogDetail",
    data() {
        return {
            paginate: {},
            recentBlogs: [],
            isLoading: true,
            isRecentLoading: true
        };
    },
    methods: {
        changePage: function (page) {
            this.$router.push({name: 'blogList', query: {page_size: page}})
        },
        setDefaultImg(event){
            event.target.src = window.location.protocol + "//" + window.location.host+'/assets/images/default/placeholder.png'
        }
    },
    mounted() {
        let page = this.$route.query.page || 1;
        let param = {
            page_size: 10,
            page: page
        };
        BlogService.findAll(param).then(response => {
            let data = response || [];
            this.paginate = data;
            this.isLoading = false;
        }).catch(e => {
            this.isLoading = false;
        });

        BlogService.recent().then(response => {
            let data = response || [];
            this.recentBlogs = data;
            this.isRecentLoading = false;
        }).catch(e => {
            this.isRecentLoading = false;
        });
    }
}
</script>
