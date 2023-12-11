import { createRouter, createWebHistory } from 'vue-router';
import ProductComponent from '../components/ProductComponent.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: ProductComponent
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;