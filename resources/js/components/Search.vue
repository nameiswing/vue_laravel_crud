<template>
    <form class="h-8 flex items-center" @submit.prevent="searchProduct">
        <label for="search" class="block text-sm text-slate-500 font-semibold mr-2">Search</label>
        <input
            required
            v-model="searchParam"
            placeholder="Product Name"
            type="search"
            name="search"
            id="search"
            class="text-sm h-full px-2 py-1 border border-slate-300 rounded-l border-r-0 focus:outline-teal-600 placeholder:text-sm placeholder:font-light"
        >
        <button type="submit" class="transition-colors bg-white h-full px-2 flex justify-center items-center rounded-r border border-slate-300 border-l-0 hover:bg-teal-100">
            <span v-if="isSearching" class="text-xs text-teal-500">Searching...</span>
            <SearchIcon v-else class="h-5 w-5 stroke-2 stroke-teal-600" />
        </button>
    </form>
</template>

<script>
    import { SearchIcon } from '@heroicons/vue/outline'

    export default {
        components: {
            SearchIcon
        },
        data() {
            return {
                searchParam: '',
                isSearching: false,
            }
        },
        methods: {
            searchProduct() {
                try {
                    this.isSearching = true;
                    this.axios.get(`api/search-products/${this.searchParam}`).then( res => {
                        if(res.data.status === 200) {
                            if(res.data.products.length === 0) {
                                alert(res.data.message);
                                return this.isSearching = false;
                            };
                            this.$store.commit('setProducts', res.data.products);
                            this.isSearching = false;
                        }
                        else if(res.data.status === 404) {
                            this.isSearching = false;
                            alert('Product not found.')
                        }
                    })
                }
                catch(err) {
                    console.log(err.message);
                }
            }

        }
    }
</script>