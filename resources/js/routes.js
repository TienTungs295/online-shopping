import Example from './components/ExampleComponent'

const routes = [
    {
        path: '/test',
        alias: "/test",
        name: "test",
        component: () => import("./components/ExampleComponent"),
    }
];

export default routes;
