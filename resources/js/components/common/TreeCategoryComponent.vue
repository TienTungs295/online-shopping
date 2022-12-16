<template>
    <ul class="widget_categories">
        <li v-for="item in categories"
            :class="[(isChild ? 'dis-none pdl-5' :''),(item.is_show ? 'dis-list-item':'')]" class="pdb-0-i">
            <a>
                <i v-if="item.childs.length > 0" @click="toggle(item)" class="__icon"
                   :class="[(item.is_expand ? 'linearicons-chevron-down' : 'linearicons-chevron-right'),(category_id == item.id ? 'active' :'')]"></i>
            </a>
            <a class="d-flex justify-content-between align-baseline" :class="category_id == item.id ? 'active' :''" @click="changeCat(item)">
                <span class="categories_name pdr-10">
                    {{ item.name }}
                </span>
                <span class="categories_num">({{ item.total_products }})</span>
            </a>
            <tree-category-component v-if="item.childs.length > 0" v-bind:categories="item.childs" v-bind:category_id="category_id"
                                     v-bind:isChild="true"></tree-category-component>
        </li>
    </ul>
</template>

<script>


import {serviceBus} from "../../serviceBus";

export default {
    name: "TreeCategory",
    props: ['categories', 'category_id', 'isChild'],
    data() {
        return {};
    },
    computed: {},
    methods: {
        toggle(item) {
            item.is_expand = !item.is_expand;
            for (let child of item.childs) {
                child.is_show = item.is_expand;
            }
        },
        changeCat(item) {
            serviceBus.$emit('changeCategory', item.id);
        }
    },
    mounted() {
    },
}
</script>
