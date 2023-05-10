<template>
    <AppHeader/>
    <router-view/>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
export default {
    name: "DashboardLayout",
    components:{
        AppHeader

    }
};
</script>

<style scoped>

</style>
