<template>
    <div @click.self="closeModal" v-show="currentModal" class="w-screen h-screen flex justify-center items-center bg-gray-900/25 absolute top-0 left-0">
        <form class="rounded-md w-96 min-w-xs bg-white py-3 px-2" @submit.prevent="addProduct">
            <fieldset class="px-4 pt-2 pb-4 flex flex-col ">
                <!-- idk but flex doesn't work on legend tag so I used div -->
                <div class="flex justify-between mb-2">
                    <div class="text-lg font-semibold text-teal-600">Add Product</div>
                    <button @click.prevent="closeModal" class="text-xl font-semibold text-rose-600 rounded-full px-1.5 hover:bg-slate-100">&times;</button>
                </div>
                <div class="mb-3">
                    <label for="product_name" class="block text-sm text-slate-500 font-semibold mb-1">Name</label>
                    <input type="text" name="product_name" id="product_name" class="w-full px-2 py-1 border rounded focus:outline-teal-600" v-model="product_name" required>
                </div>
                <div class="mb-3">
                    <label for="detail" class="block text-sm text-slate-500 font-semibold mb-1">Detail</label>
                    <textarea type="text" name="detail" id="detail" class="w-full px-2 py-1 border rounded focus:outline-teal-600" v-model="details" required></textarea>
                </div>
                <div class="mb-6">
                    <label for="price" class="block text-sm text-slate-500 font-semibold mb-1">Price</label>
                    <input type="number" min="0" max="99999" step="0.01" name="price" id="price" class="w-full px-2 py-1 border rounded focus:outline-teal-600" v-model="price" required>
                </div>
                <input :value="buttonProgress" type="submit" class="ms-auto text-white bg-teal-600 hover:bg-teal-700 px-5 py-1.5 rounded transition-colors cursor-pointer" />
            </fieldset>
        </form>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                product_name: '',
                details: '',
                price: '0.00',
                buttonProgress: 'Add',
            }
        },
        computed: {
            currentModal() {
                return Boolean(
                    this.$store.state.currentModal[0] === true &&
                    this.$store.state.currentModal[1] === 'addProduct'
                )
            },
            productInfo() {
                return {
                    name: this.product_name,
                    details: this.details,
                    price: this.price
                }
            }
        },
        methods: {
            closeModal() {
                this.$store.commit('setCurrentModal', [false, ''])
            },
            addProduct() {
                this.buttonProgress = 'Adding. . .'
                this.axios.post('api/add-product', this.productInfo).then( res => {
                    if(res.data.status === 200) {
                        console.log(res.data.products);
                        this.$store.commit('setProducts', res.data.products);
                        this.buttonProgress = 'Success!'
                        this.product_name = '';
                        this.details = '',
                        this.price = '0.00';
                        setTimeout(() => {
                            this.closeModal()
                            this.buttonProgress = 'Add';
                        }, 1000);
                    } else {
                        console.log('Unable to add product.')
                    }
                })
            }
        }
    }
</script>