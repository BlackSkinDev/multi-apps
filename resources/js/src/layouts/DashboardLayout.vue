<template>
    <AppHeader/>
    <div class="flex h-screen bg-gray-100">
        <LeftSideBar/>
        <div class="flex-1 overflow-auto">
            <div class="p-8 mt-16">
                <router-view/>
            </div>
        </div>
       <RightSideBar/>
    </div>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
import {TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {mapActions} from "pinia";
import LeftSideBar from "../components/LeftSideBar.vue";
import RightSideBar from "../components/RightSideBar.vue";
export default {
    name: "DashboardLayout",
    components:{AppHeader,LeftSideBar,RightSideBar},
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
