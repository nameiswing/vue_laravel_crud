<template>
    <div class="py-4 px-2 max-w-5xl mx-auto">
        <Nav />
        <main class="entry" id="main">
            <router-view />
        </main>
    </div>
    <AddProduct />
    <EditProduct />
</template>

<script>
import Nav from './components/Nav';
import AddProduct from './components/AddProduct.vue';
import EditProduct from './components/EditProduct.vue';

export default {
    components: {
        Nav, AddProduct, EditProduct
    }
}
</script>

