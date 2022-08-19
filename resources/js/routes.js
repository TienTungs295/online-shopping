import Example from './components/HomeComponent'

const routes = [
    {
        path: '/',
        name: "home",
        component: () => import("./components/HomeComponent"),
    }
];

export default routes;
