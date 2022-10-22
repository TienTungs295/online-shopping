import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        object: {
            withListCount: 0,
            cartCount: 0,
            cart: [],
            subTotal: 0,
            subTotalWithShippingFee: 0,
            isLoggedIn: false,
            user_profile: {},
        }
    },
    getters: {
        withListCount: state => state.object.withListCount,
        cartCount: state => state.object.cartCount,
        cart: state => state.object.cart,
        subTotal: state => state.object.subTotal,
        subTotalWithShippingFee: state => state.object.subTotalWithShippingFee,
        isLoggedIn: state => state.object.isLoggedIn,
        user_profile: state => state.object.user_profile,
    },
    mutations: {
        setWithListCount(state, newNumber) {
            state.object.withListCount = newNumber;
        },
        setCartCount(state, newNumber) {
            state.object.cartCount = newNumber;
        },
        setCart(state, payload) {
            state.object.cart = payload;
        },
        setSubTotal(state, newNumber) {
            state.object.subTotal = newNumber;
        },
        setSubTotalWithShippingFee(state, newNumber) {
            state.object.subTotalWithShippingFee = newNumber;
        },
        setLoggedIn(state, isLogin) {
            state.object.isLoggedIn = isLogin;
        },
        setUserProfile(state, user_profile) {
            state.object.user_profile = user_profile;
        }
    }
})
