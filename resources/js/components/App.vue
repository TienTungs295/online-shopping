<template>
    <div>
        <header-component></header-component>
        <router-view :key="$route.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
</template>
<script>
export default {
    name: "App",
    mounted() {
    }
}
</script>
