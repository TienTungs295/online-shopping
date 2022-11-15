import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        object: {
            withListCount: 0,
            withList: {},
            cartCount: 0,
            cart: {},
            subTotal: 0,
            subTotalFinal: 0,
            userProfile: null,
            categories: [],
            collections: [],
        }
    },
    getters: {
        withListCount: state => state.object.withListCount,
        withList: state => state.object.withList,
        cartCount: state => state.object.cartCount,
        cart: state => state.object.cart,
        subTotal: state => state.object.subTotal,
        subTotalFinal: state => state.object.subTotalFinal,
        userProfile: state => state.object.userProfile,
        categories: state => state.object.categories,
        collections: state => state.object.collections,
    },
    mutations: {
        setWithListCount(state, newNumber) {
            state.object.withListCount = newNumber;
        },
        setWithList(state, payload) {
            state.object.withList = payload;
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
        setSubTotalFinal(state, newNumber) {
            state.object.subTotalFinal = newNumber;
        },
        setUserProfile(state, userProfile) {
            state.object.userProfile = userProfile;
        },
        setCategories(state, categories) {
            state.object.categories = categories;
        },
        setCollections(state, collections) {
            state.object.collections = collections;
        }
    }
})
