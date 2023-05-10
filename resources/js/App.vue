<template>
    <component :is="layout"></component>
</template>

<script>
import DashboardLayout from "./src/layouts/DashboardLayout.vue";
import IndexLayout from "./src/layouts/IndexLayout.vue";


export default {
    components: {
        DashboardLayout,
        IndexLayout,
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
