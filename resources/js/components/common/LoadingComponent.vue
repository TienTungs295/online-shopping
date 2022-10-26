<template>
    <div class="d-flex-center loading-wrapper" v-if="loading" :class="center ?'center-loading':''">
        <div class="loadingio-spinner-ripple-ikacqqmjs2n" >
            <div class="ldio-xwg8kc27gf">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</template>

<style lang="css" scoped>
@keyframes ldio-xwg8kc27gf {
    0% {
        top: 47px;
        left: 47px;
        width: 0;
        height: 0;
        opacity: 1;
    }
    100% {
        top: 8.5px;
        left: 8.5px;
        width: 77px;
        height: 77px;
        opacity: 0;
    }
}

.ldio-xwg8kc27gf div {
    position: absolute;
    border-width: 3px;
    border-style: solid;
    opacity: 1;
    border-radius: 50%;
    animation: ldio-xwg8kc27gf 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}

.ldio-xwg8kc27gf div:nth-child(1) {
    border-color: #e90c59;
    animation-delay: 0s;
}

.ldio-xwg8kc27gf div:nth-child(2) {
    border-color: #339059;
    animation-delay: -0.5s;
}

.loadingio-spinner-ripple-ikacqqmjs2n {
    width: 100px;
    height: 100px;
    display: inline-block;
    overflow: hidden;
    background: transparent;
}

.ldio-xwg8kc27gf {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(1);
    backface-visibility: hidden;
    transform-origin: 0 0;
}

.ldio-xwg8kc27gf div {
    box-sizing: content-box;
}

.center-loading {
    z-index: 200;
    position: absolute;
    width: 100%;
    height: 100%;
    background:rgba(255,255,255, 0.8);
}
</style>

<script>
export default {
    name: "Loading",
    props: ['loading', 'center'],
    data() {
        return {};
    },
    methods: {},
    mounted() {

    }
}
</script>
