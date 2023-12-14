import { createRouter, createWebHistory } from 'vue-router';
import ProductComponent from '../components/ProductComponent.vue';
import ProductDetailComponent from '../components/ProductDetailComponent.vue';
import CartComponent from '../components/CartComponent.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: ProductComponent
    },

    {
        path: '/products/:productId',
        name: 'ProductDetail',
        component: ProductDetailComponent,
        props: true
    },

    {
        path: '/cart',
        name: 'Cart',
        component: CartComponent
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;