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
        <div class="starters-tour-guide">
            <v-tour name="myTour" :steps="steps" :options="myOptions"/>
        </div>
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
    data() {
        return {
            steps: [
                {
                    target: '#v-step-0',
                    header: {
                        title: 'Manage Project',
                    },
                    content: 'Create, organize, and track project progress!',

                },
                {
                    target: '#v-step-1',
                    header: {
                        title: 'Manage Backlogs',
                    },
                    content:'Prioritize and track project tasks!',
                },
                {
                    target: '#v-step-2',
                    header: {
                        title: 'Account Update',
                    },
                    content:'Customize and update your account!',
                    params: {
                        //placement: 'top' //
                    }
                }
            ],
            myOptions: {
                useKeyboardNavigation: true,
                labels: {
                    buttonSkip: 'Skip',
                    buttonPrevious: 'Previous',
                    buttonNext: 'Next',
                    buttonStop: 'Finish'
                }
            },
        };
    },
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
    mounted() {
        setTimeout(() => {
            this.$tours['myTour'].start();
        }, 500);
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

<style >
.starters-tour-guide .v-step__header,.v-step__arrow--dark[data-v-da2d894c]:before{
    background:#0039a6 !important;
}
.starters-tour-guide .v-step{
    background:#0039a6 !important;
    width:200px!important;
}
.starters-tour-guide .v-step__header div{
    font-size: 13px !important;
    width: 100%;
}
.starters-tour-guide .v-step__content div{
    font-size: 11px;
    width: 100%;
}
.starters-tour-guide .v-step__buttons{
    margin-top: 20px !important;
}

</style>
