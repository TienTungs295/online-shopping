<template>
    <div class="container">
        <product-quick-view-item-component v-bind:product="product"></product-quick-view-item-component>
    </div>
</template>

<script>
import ProductService from "../../services/ProductService";

export default {
    name: "ProductQuickViewModalComponent",
    props: ['id'],
    data() {
        return {
            product: {},
            isLoading: true,
        };
    },
    methods: {},
    mounted() {
        ProductService.detail(this.id).then(response => {
            let data = response || {};
            this.product = data;
            this.isLoading = false;
        }).catch(e => {
            this.isLoading = false;
        });
    }
}
</script>
