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
                            <li class="breadcrumb-item active">{{ blog.name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content">

            <!-- START SECTION BLOG -->
            <div class="section" v-if="!isLoading">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="single_post">
                                <h2 class="blog_title">{{blog.name}}</h2>
                                <ul class="list_none blog_meta">
                                    <li><i
                                        class="ti-calendar mgr-5-i color_primary"></i>
                                        {{ blog.updated_at |dateFormat }}
                                    </li>
                                </ul>
                                <div class="blog_img mgb-20">
                                    <img :src="'/uploads/images/'+blog.image" :alt="blog.image">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_text">
                                        <div v-html="blog.content"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="post_navigation bg_gray mgb-50 mgt-40">
                                <div class="row align-items-center justify-content-between p-4">
                                    <div class="col-6">
                                        <router-link v-if="prevBlog"
                                            :to="{ name: 'blogDetail', params: { slug: prevBlog.slug,id:prevBlog.id }}">
                                            <div class="post_nav post_nav_prev">
                                                <i class="ti-arrow-left"></i>
                                                <span>{{prevBlog.name}}</span>
                                            </div>
                                        </router-link>
                                    </div>
                                    <div class="col-6">
                                        <router-link v-if="nextBlog"
                                                     :to="{ name: 'blogDetail', params: { slug: nextBlog.slug,id:nextBlog.id }}">
                                            <div class="post_nav post_nav_next">
                                                <i class="ti-arrow-right"></i>
                                                <span>{{nextBlog.name}}</span>
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="related_post">
                                <div class="content_title">
                                    <h5>Bài viết liên quan</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" v-for="item in relatedBlogs">
                                        <blog-item-component v-bind:item="item"></blog-item-component>                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 mt-4 pt-2 mt-xl-0 pt-xl-0">
                            <div class="sidebar">
                                <div class="widget">
                                    <h5 class="widget_title">Bài viết gần đây</h5>
                                    <ul class="widget_recent_post" >
                                        <li v-for="item in recentBlogs">
                                            <div class="post_footer">
                                                <div class="post_img">
                                                    <router-link
                                                        :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                                                        <img :src="'/uploads/images/'+item.image" :alt="item.image">
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
            blog: {},
            nextBlog: {},
            prevBlog: {},
            relatedBlogs: [],
            recentBlogs: [],
            isLoading: true,
            isRelatedLoading: true,
            isRecentLoading: true,
        };
    },
    methods: {},
    mounted() {
        BlogService.detail(this.$route.params.id).then(response => {
            let data = response || {};
            this.nextBlog = data.next_blog;
            this.blog = data.blog;
            this.prevBlog = data.prev_blog;
            this.isLoading = false;
        }).catch(e => {
            this.isLoading = false;
        });

        BlogService.related(this.$route.params.id).then(response => {
            let data = response || [];
            this.relatedBlogs = data;
            this.isRelatedLoading = false;
        }).catch(e => {
            this.isRelatedLoading = false;
        });

        BlogService.recent(this.$route.params.id).then(response => {
            let data = response || [];
            this.recentBlogs = data;
            this.isRecentLoading = false;
        }).catch(e => {
            this.isRecentLoading = false;
        });
    }
}
</script>
