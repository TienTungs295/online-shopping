<template>
    <div class="blog_post blog_style2 box_shadow1">
        <div class="blog_img">
            <router-link class="link_wrapper"
                         :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                <img :src="'/uploads/images/'+item.image" :alt="item.image" @error="setDefaultImg">
            </router-link>
        </div>
        <div class="blog_content bg-white">
            <div class="blog_text">
                <h5 class="blog_title">
                    <router-link
                        :to="{ name: 'blogDetail', params: { slug: item.slug,id:item.id }}">
                        {{ item.name }}
                    </router-link>
                </h5>
                <ul class="list_none blog_meta">
                    <li><i
                        class="ti-calendar mgr-5-i color_primary"></i>
                        {{
                            item.updated_at |dateFormat
                        }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>


export default {
    name: "BlogItem",
    props: ['item'],
    methods: {
        setDefaultImg(event){
            event.target.src = window.location.protocol + "//" + window.location.host+'/assets/images/default/placeholder.png'
        }
    },
    mounted() {
    }
}
</script>
