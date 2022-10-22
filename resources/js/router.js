import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "./store";

Vue.use(VueRouter);
const routes = [
    {
        path: '/',
        name: "home",
        component: () => import("./components/HomeComponent"),
    },
    {
        path: '/chi-tiet-san-pham/:slug/:id',
        name: "productDetail",
        component: () => import("./components/products/ProductDetailComponent"),
    },
    {
        path: '/san-pham',
        name: "productList",
        component: () => import("./components/products/ProductListComponent"),
    },
    {
        path: '/tin-tuc-su-kien',
        name: "blogList",
        component: () => import("./components/blogs/BlogListComponent"),
    },
    {
        path: '/chi-tiet-tin-tuc-su-kien/:slug/:id',
        name: "blogDetail",
        component: () => import("./components/blogs/BlogDetailComponent"),
    },
    {
        path: '/san-pham-yeu-thich',
        name: "withList",
        component: () => import("./components/products/WishListComponent"),
        meta: {requiresAuth: true}
    },
    {
        path: '/gio-hang',
        name: "cart",
        component: () => import("./components/carts/CartComponent"),
    },
    {
        path: '/thanh-toan',
        name: "order",
        component: () => import("./components/carts/OrderComponent"),
    },
    {
        path: '/lien-he',
        name: "contact-us",
        component: () => import("./components/ContactUsComponent"),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import("./components/auth/LoginComponent"),
    },
    {
        path: '/logout',
        name: 'logout',
        component: () => import("./components/auth/LogoutComponent"),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import("./components/auth/RegisterComponent"),
    }
];
const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.object.isLoggedIn) {
        next({name: 'login'})
        return;
    }
    if (to.name == 'login' && store.state.object.isLoggedIn) {
        next({name: 'home'})
        return;
    }
    next();
});

export default router;
