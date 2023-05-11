<template>
    <AppHeader/>
    <router-view/>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
import {TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {mapActions} from "pinia";
export default {
    name: "DashboardLayout",
    components:{
        AppHeader

    },
    async created() {
        const res = await TriggerPiniaAction(this.fetchAuthUser())
        if(!res)this.$router.push("/signin");
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser'])
    }
};
</script>

<style scoped>

</style>
