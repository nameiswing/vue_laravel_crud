import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex';
import routes from './routes';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Main from './Main';

//sets axios base URL to whatever host you're running
axios.defaults.baseURL = process.env.BASE_URL;

const app = createApp(Main);

const store = createStore({
    state: {
        currentModal: [false, ''],
        products: [],
        editInfo: { id: '', name: '', details: '', price: ''}, //for edit product info modal
        numOfEntries: 'all', //query result count limit
    },
    mutations: {
        setCurrentModal(state, payload) {
            state.currentModal = payload;
        },
        setProducts(state, payload) {
            state.products = payload;
        },
        setEditInfo(state, payload) {
            state.editInfo = payload;
        },
        setNumOfEntries(state, payload) {
            state.numOfEntries = payload;
        }
    }
})

app.use(routes);
app.use(store);
app.use(VueAxios, axios);

app.mount('#app');
