<template>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "Logout",
    data() {
        return {
        };
    },
    computed: {
        ...mapGetters([
            'isLoggedIn'
        ])
    },
    methods: {
    },
    mounted() {
    }
}
</script>
