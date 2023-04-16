<template>
    <component :is="layout"></component>
</template>

<script>
import KinbanAppLayout from "./src/layouts/KinbanAppLayout.vue";
import DefaultLayout from "./src/layouts/Defaultlayout.vue";


export default {
    components: {
        KinbanAppLayout,
        DefaultLayout,
    },

    computed: {
        layout() {
            if (this.$route.matched.some(record => record.path.startsWith('/kinban-app'))) {
                return 'KinbanAppLayout'
            } else {
                return 'DefaultLayout'
            }
        },
    },
};
</script>
