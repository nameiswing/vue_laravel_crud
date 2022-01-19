import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home';
import Products from './pages/Products';

const routes = [
    { path: '/', name: "home", component: Home },
    { path: '/products', name: "products", component: Products },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router;
