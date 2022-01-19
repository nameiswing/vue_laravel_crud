import { createRouter, createWebHistory } from 'vue-router';
import Welcome from './pages/Welcome';
import Products from './pages/Products';

const routes = [
    { path: '/', name: "welcome", component: Welcome },
    { path: '/products', name: "products", component: Products },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router;
