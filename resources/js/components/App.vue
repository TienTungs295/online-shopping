<template>
    <div>
        <header-component></header-component>
        <router-view :key="$route.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
</template>
<script>
import AuthService from "../services/AuthService";

export default {
    name: "App",
    methods: {
        checkTokenExpire: function () {
            setInterval(function () {
                AuthService.userProfile().then(response => {
                }).catch(response => {

                });
            }, 60000);
        }
    },
    mounted() {
        AuthService.userProfile().then(response => {
            let data = response || {};
            this.$store.commit("setUserProfile", data);
        }).catch(response => {
        });
        this.checkTokenExpire();
    }
}
</script>
