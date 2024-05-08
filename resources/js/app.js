import './bootstrap';
import {createPinia} from 'pinia';
import {createApp} from 'vue'
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
import Vue3Tour from 'vue3-tour';
import 'vue3-tour/dist/vue3-tour.css'
import CanvasJSChart from '@canvasjs/vue-charts';


import router from './src/router/index.js'

import App from './App.vue'
const pinia = createPinia();
createApp(App)
    .use(router)
    .use(pinia)
    .use(CanvasJSChart)
    .use(Toast, {
        position: POSITION.TOP_RIGHT,
        timeout: 1500,
    })
    .use(Vue3Tour)
    .mount("#app")
