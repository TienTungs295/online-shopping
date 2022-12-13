<template>
    <div class="dropdown-menu">
        <ul>
            <li :class="item.childs.length > 0 ? 'dropdown dropdown-mega-menu' :''" v-for="(item,index) in categories">
                <router-link
                    :to="{ name: 'productList', query: { category_id: item.id}}"
                    class="dropdown-item nav-link" :class="[(item.childs.length > 0 ? 'dropdown-toggler' :''),(index > 0 ? 'pdt-0-i' :'')]">
                   {{ item.name }}
                </router-link>
                <tree-menu-component v-if="item.childs.length > 0"
                                     v-bind:categories="item.childs"></tree-menu-component>
            </li>
        </ul>
    </div>
</template>

<script>


export default {
    name: "TreeMenu",
    props: ['categories'],
    data() {
        return {};
    },
    computed: {},
    methods: {},
    mounted() {
    }
}
</script>
