<template>
    <component :is="layout"></component>
</template>

<script>
import DashboardLayout from "./src/layouts/DashboardLayout.vue";
import IndexLayout from "./src/layouts/IndexLayout.vue";
import {toast} from "./src/plugins/Toast";


export default {
    components: {
        DashboardLayout,
        IndexLayout,
    },

    data() {
         return {
                isOnline: navigator.onLine,
                app_env:import.meta.env.VITE_APP_ENV
         };
     },
     created() {
        if (this.app_env === 'production'){
            window.addEventListener('online', this.handleNetworkChange);
            window.addEventListener('offline', this.handleNetworkChange);
        }
     },

    methods: {
        handleNetworkChange() {
            this.isOnline = navigator.onLine;
            if (this.isOnline) {
                toast.success("Connected",{position:'bottom-left'});
            } else {
                toast.error("Disconnected",{position:'bottom-left'});
            }
        },
    },

    computed: {
        layout() {
            if (this.$route.matched.some(record => record.path.startsWith('/dashboard'))) {
                return 'DashboardLayout'
            } else {
                return 'IndexLayout'
            }
        },
    },
};
</script>
