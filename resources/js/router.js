import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: () => import('./Pages/HomeRoute.vue'),
    },
    {
        path: '/posts/:id',
        component: () => import('./Pages/PostsRoute.vue'),
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
