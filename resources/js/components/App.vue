<template>
    <div>
        <header-component></header-component>
        <router-view></router-view>
        <footer-component></footer-component>
    </div>
</template>
<style lang="scss">
@import '../../sass/front/style';
</style>
<script>
export default {
    name: "App",
    mounted() {
    }
}
</script>
