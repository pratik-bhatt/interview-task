import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../Pages/Home.vue'),
    },
    {
        path: '/manage',
        name: 'ManageEmployee',
        component: () => import('../Pages/ManageEmployee.vue'),
    },
    {
        path: '/import-employee',
        name: 'Import',
        component: () => import('../Pages/Import.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
