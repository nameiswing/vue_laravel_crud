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
                rounded-full p-2 hover:bg-rose-100 transition-colors relative
                before:content-[attr(tooltip)] before:absolute before:right-8 before:-translate-y-full before:bg-slate-100 before:border
                before:rounded-lg before:rounded-br-none before:px-2 before:py-1 before:bg-rose-500/90 before:text-white before:border-white
                before:hidden hover:before:block
            "
        >
            <TrashIcon class="h-5 w-5 stroke-rose-600"/>
        </button>
        <button
            @click.prevent="editProduct"
            class="rounded-full p-2 hover:bg-teal-100 transition-colors"
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