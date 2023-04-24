import './bootstrap';
import {createPinia} from 'pinia';
import {createApp} from 'vue'
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";


import router from './src/router/index.js'

import App from './App.vue'
const pinia = createPinia();
createApp(App)
    .use(router)
    .use(pinia)
    .use(Toast, {
        position: POSITION.TOP_RIGHT,
        timeout: 1500
    })
    .mount("#app")
