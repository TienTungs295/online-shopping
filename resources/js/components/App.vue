<template>
    <div>
        <header-component></header-component>
        <router-view :key="$route.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
</template>
<!--<style lang="scss">-->
<!--</style>-->
<script>
export default {
    name: "App",
    mounted() {
        // console.log($) ; console.log(JQuery)
    }
}
</script>
