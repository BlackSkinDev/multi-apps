<template>
    <AppHeader/>
    <router-view/>
</template>

<script>
import AppHeader from "../components/Kinban-App/App-Header.vue";
export default {
    name: "KinbanAppLayout",
    components:{
        AppHeader

    }
};
</script>

<style scoped>

</style>
