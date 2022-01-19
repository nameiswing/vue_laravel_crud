<template>
    <td class="text-sm text-slate-600 border border-slate-300 py-1 px-3 text-center">{{ product.id }}</td>
    <td class="text-sm text-slate-600 border border-slate-300 py-1 px-3 capitalize">{{ product.name }}</td>
    <td class="text-sm text-slate-600 border border-slate-300 py-1 px-3">{{ product.details }}</td>
    <td class="text-sm text-slate-600 border border-slate-300 py-1 px-3">
        {{ Number.isInteger(product.price) ? numberWithCommas(product.price.toFixed(2)) : numberWithCommas(product.price.toFixed(2)) }}
    </td>
    <td class="text-sm text-slate-600 border border-slate-300 py-1 px-3 text-center relative">
        <div v-show="popper" class="bg-rose-500 text-white flex justify-center items-center absolute top-0 left-0 w-full h-full">
            Deleting
        </div>
        <button
            tooltip="Delete"
            @click.prevent="deleteProduct(product.id)"
            class="
                rounded-full p-2 hover:bg-rose-100 transition-colors relative active:bg-rose-200
                before:content-[attr(tooltip)] before:absolute before:right-8 before:-translate-y-full before:border
                before:rounded-full before:rounded-br-none before:px-3 before:py-1 before:bg-rose-100 before:text-rose-600 before:border-white
                before:drop-shadow before:border-2 before:font-semibold before:hidden hover:before:block
            "
        >
            <TrashIcon class="h-5 w-5 stroke-rose-600"/>
        </button>
        <button
            tooltip="Edit"
            @click.prevent="editProduct"
            class="rounded-full p-2 hover:bg-teal-100 transition-colors relative active:bg-teal-200
                before:content-[attr(tooltip)] before:absolute before:right-8 before:-translate-y-full before:border
                before:rounded-full before:rounded-br-none before:px-3 before:py-1 before:bg-teal-200 before:text-teal-700 before:border-white
                before:drop-shadow before:border-2 before:font-semibold before:hidden hover:before:inline-block

            "
        >
            <PencilIcon class="h-5 w-5 stroke-teal-600"/>
        </button>
    </td>
</template>

<script>
import { TrashIcon, PencilIcon } from '@heroicons/vue/outline';

export default {
    props: ['product'],
    components: {
        TrashIcon, PencilIcon
    },
    data() {
        return {
            popper: false,
        }
    },
    methods: {
        numberWithCommas(num) {
            return num.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        },
        deleteProduct(id) {
            let confirm = window.confirm('Delete product?');
            this.popper = true;
            if(confirm) {
                this.axios.delete(`api/delete-product/${id}`).then( res => {
                    if(res.data.status === 200) {
                        this.$store.commit('setProducts', res.data.products)
                        this.popper = false;
                    }
                    else if(res.data.status === 404) {
                        alert(res.data.message);
                    }
                })
            } else {
                this.popper = false;
            }
        },
        editProduct() {
            this.$store.commit('setEditInfo', this.product);
            this.$store.commit('setCurrentModal', [true, 'editProduct'])
        }
    }
}
</script>