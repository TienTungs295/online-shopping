<template>
    <div class="container">
        <div class="row justify-content-center">
            <nav class="navbar navbar-expand navbar-dark bg-dark">
                <router-link to="/test" class="navbar-brand">Home</router-link>
            </nav>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
