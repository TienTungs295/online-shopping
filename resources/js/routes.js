import Example from './components/HomeComponent'

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
    },
    {
        path: '/gio-hang',
        name: "cart",
        component: () => import("./components/carts/CartComponent"),
    }
];

export default routes;
