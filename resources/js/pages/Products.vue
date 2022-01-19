<template>
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between mb-3 px-2">
            <h1 class="text-2xl text-teal-600 font-semibold">
                Products
            </h1>
            <button @click.prevent="setCurrentModal" class="text-white bg-teal-600 hover:bg-teal-500 px-4 py-1.5 rounded transition-colors">
                Add Product
            </button>
        </div>
        <div class="w-full px-4 py-2 bg-slate-100 border border-b-0 rounded-t-md border-slate-300 flex justify-between flex-sm-column">
            <Search />
            <div>
                <EntryCount />
            </div>
        </div>
        <table class="table-auto w-full border-collapse rounded">
            <thead>
                <tr class="bg-teal-500">
                    <th class="text-white border border-white  border-l-teal-500 text-sm">
                        <button
                            class="font-semibold  border-0 h-11 w-full hover:bg-teal-400/50"
                            @click.prevent="sortBy({orderBy:'id', order: sortParams.id})"
                        >ID</button>
                    </th>
                    <th class="text-white border border-white text-sm">
                        <button
                            class="font-semibold  border-0 h-11 w-full hover:bg-teal-400/50"
                            @click.prevent="sortBy({orderBy:'name', order: sortParams.name})"
                        >Name</button>
                    </th>
                    <th class="font-semibold text-white border border-white p-3 text-sm text-center" >Description</th>
                    <th class="text-white border border-white text-sm">
                        <button
                            class="font-semibold  border-0 h-11 w-full hover:bg-teal-400/50"
                            @click.prevent="sortBy({orderBy:'price', order: sortParams.price})"
                        >Price</button>
                    </th>
                    <th class="font-semibold text-white border border-white  border-r-teal-500 p-3 text-sm" >Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="index" class="even:bg-slate-100/75">
                    <ProductItem :product="product"/>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

import ProductItem from '../components/ProductItem.vue';
import Search from '../components/Search.vue';
import EntryCount from '../components/EntryCount.vue';

export default {
    components: {
        ProductItem,
        Search,
        EntryCount
    },
    data() {
        return {
            controller: new AbortController(),
            sortParams: {
                id: 'asc',
                name: 'asc',
                price: 'asc'
            }
        }
    },
    computed: {
        currentModal() {
            return this.$store.state.currentModal
        },
        products() {
            return this.$store.state.products
        }
    },
    methods: {
        setCurrentModal() {
            this.$store.commit('setCurrentModal', [true, 'addProduct'])
        },
        fetchProducts() {
            this.axios.get('api/products').then(res => {
                if(res.data.status === 200) {
                    console.log(res.data.products)
                    this.$store.commit('setProducts', res.data.products)
                }
            })
        },
        sortBy(param){ //param = { orderBy: col_name, order: 'asc/desc'}
            if(param.order === 'desc') this.sortParams[param.orderBy] = 'asc';
            if(param.order === 'asc') this.sortParams[param.orderBy] = 'desc';

            try {
                console.log(param)
                this.axios.get('api/sorted-products', { params: param }).then( res => {
                    if(res.data.status === 200) {
                        this.$store.commit('setProducts', res.data.products);
                    } else {
                        console.log('Can not sort.', res);
                    }
                })
            }
            catch(err) {
                console.error(err.message);
            }
        },
    },
    beforeMount() {
        this.fetchProducts();
    },
    unmounted() {
        this.controller.abort();
    }
}
</script>
