<template>
    <div class="mb-5">
        <router-link to="/">Home</router-link> |
        <router-link to="/products">Products</router-link>
    </div>
</template>

<script>

</script>

<style scoped>
    a {
        color: #35495e;
        font-weight: 600;
        /* text-transform: uppercase; */
    }
    .router-link-active {
        color: #0D9488;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 1.5px;
    }
</style>
