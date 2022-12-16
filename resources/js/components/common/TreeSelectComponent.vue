<template>
    <div>
        <div v-for="item in categories" v-bind:key="item.id">
            <b-dropdown-item @click="chooseCategory(item)">
                <a :class="level == 0 ? 'fw-bold' :''" :style="{ 'padding-left': level * 5 + 'px' }">
                    {{ item.name }}
                </a>
            </b-dropdown-item>
            <tree-select-component v-if="item.childs.length > 0" v-bind:categories="item.childs"
                                   v-bind:query="query" v-bind:level="level+1"></tree-select-component>
        </div>
    </div>
</template>

<script>


export default {
    name: "TreeSelect",
    props: ['categories', 'query', 'level'],
    data() {
        return {};
    },
    computed: {},
    methods: {
        chooseCategory(item) {
            this.query.category_id = item.id;
            this.query.cate_name = item.name;
        }
    },
    mounted() {
    }
}
</script>
