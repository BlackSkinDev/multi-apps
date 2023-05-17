<template>
    <AppHeader/>
    <div class="flex h-screen bg-gray-100">
        <LeftSideBar v-if="user.has_company" :company="company"/>
        <div class="flex-1 overflow-auto bg-white">
            <div class="p-8 mt-16">
                <router-view/>
            </div>
        </div>
       <RightSideBar v-if="user.has_company"/>
    </div>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
import {authCheck, TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {useCompanyStore} from "../store/CompanyStore";
import {mapActions, mapState} from "pinia";
import LeftSideBar from "../components/LeftSideBar.vue";
import RightSideBar from "../components/RightSideBar.vue";
export default {
    name: "DashboardLayout",
    components:{AppHeader,LeftSideBar,RightSideBar},
    async created() {
        const res = await TriggerPiniaAction(this.fetchAuthUser())
        if (res) {
            await this.fetchUserCompany(true);
        }else{
            this.$router.push({ name: "signin" });
        }

        if (authCheck()){
            if (this.$route.name === "dashboard") {
                if (this.user.is_admin && !this.user.has_company){
                    this.$router.push({ name: "create-company" });
                }
            }
            if (this.$route.name === "create-company") {
                if (this.user.has_company){
                    this.$router.push({ name: "dashboard" });
                }
            }
        }
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser']),
        ...mapActions(useCompanyStore,['fetchUserCompany']),
    },
    computed:{
        ...mapState(useAuthStore,{
            user:(state)        => state.user,
        }),
        ...mapState(useCompanyStore,{
            company:(state)        => state.company,
        })
    }
};
</script>

<style scoped>

</style>
