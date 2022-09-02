import Example from './components/HomeComponent'

const routes = [
    {
        path: '/',
        name: "home",
        component: () => import("./components/HomeComponent"),
    },
    {
        path: '/san-pham/:slug/:id',
        name: "productDetail",
        component: () => import("./components/product/ProductDetailComponent"),
    }
];

export default routes;
