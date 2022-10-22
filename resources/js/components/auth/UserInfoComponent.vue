<template>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "Register",
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
