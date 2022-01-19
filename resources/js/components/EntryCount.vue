<template>
    <form class="h-8 flex items-center">
        <label for="entry-count" class="block text-sm text-slate-500 font-semibold mr-2">No. of Results</label>
        <select
            name="entry_count"
            id="entry-count"
            class="capitalize px-2 h-full rounded outline-teal-500 text-slate-600 border border-slate-300 text-sm font-semibold"
            v-model="numOfEntries"
        >
            <option >5</option>
            <option >10</option>
            <option >15</option>
            <option >20</option>
            <option selected>all</option>
        </select>
    </form>
</template>

<script>
export default {
    computed: {
        numOfEntries: {
            get() {
                return this.$store.state.numOfEntries
            },
            set(value) {
                this.$store.commit('setNumOfEntries', value);
            }
        }
    },
    methods: {
        setLimit() { //save entry limit in session
            try {
                this.axios.post(`api/set-limit/${this.numOfEntries}`).then( response => {
                    if(response.data.status == 200) {
                        console.log(response.data.message);
                        this.$store.commit('setProducts', response.data.products);
                    } else {
                        console.warn('Can not set entry limit.');
                    }
                })
            }
            catch(err) {
                console.error(err.message);
            }
        },
        getLimit() {
            try {
                this.axios.get(`api/get-limit`).then( response => {
                    if(response.data.status == 200) {
                        this.$store.commit('setNumOfEntries', response.data.limit);
                    } else {
                        console.warn(res.data.message);
                        this.setLimit();
                    }
                })
            }
            catch(err) {
                console.error(err.message);
            }
        }
    },
    watch: {
        numOfEntries(a,b) {
            if(a !== b) {
                this.setLimit();
                console.log(this.$store.state.numOfEntries);
            }
        }
    },
    beforeMount() {
        this.getLimit();
    }
}
</script>