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
import {authCheck, TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {mapActions, mapState} from "pinia";
import LeftSideBar from "../components/LeftSideBar.vue";
import RightSideBar from "../components/RightSideBar.vue";
export default {
    name: "DashboardLayout",
    components:{AppHeader,LeftSideBar,RightSideBar},
    async created() {
        const res = await TriggerPiniaAction(this.fetchAuthUser())
        if(!res)this.$router.push("/signin");

        if (authCheck()){
            if (this.$route.name === "dashboard") {
                console.log(this.user)
                if (this.user.is_admin && !this.user.has_company){
                   this.$router.push('/company/create');
                }
            }
        }
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser']),
    },
    computed:{
        ...mapState(useAuthStore,{
            user:(state)        => state.user,
        })
    }
};
</script>

<style scoped>

</style>
