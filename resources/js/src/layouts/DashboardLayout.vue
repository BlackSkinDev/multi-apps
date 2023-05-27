<template>
    <AppHeader/>
    <div class="flex h-screen bg-gray-100">
        <LeftSideBar v-if="user.has_company"/>
        <div class="flex-1 overflow-auto bg-white">
            <div class="mt-16">
                <router-view/>
            </div>
        </div>
<!--       <RightSideBar v-if="user.has_company"/>-->
        <div class="starters-tour-guide">
            <v-tour name="myTour" :steps="steps" :options="myOptions" :callbacks="myCallbacks"/>
            <div v-show="showTour" class="fixed inset-0 bg-black bg-opacity-50" ></div>
        </div>

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
    data() {
        return {
            showTour:false,
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
            myCallbacks: {
                onFinish:()=>{this.showTour = false},
                onStart:()=>{this.showTour = true},
                onSkip:()=>{this.showTour = false},
                onStop:()=>{this.showTour = false},
            }
        };
    },
    async created() {
        const res = await TriggerPiniaAction(this.fetchAuthUser())
        if(!res)  this.$router.push({ name: "signin" });

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
        this.showWelcomeTour();
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser']),
        showWelcomeTour(){
            const hasShownTourLocalStorage = localStorage.getItem('hasShownTour');
            const hasShownTourCookie = this.getCookie('hasShownTour');
            if (!hasShownTourLocalStorage && !hasShownTourCookie) {
                setTimeout(() => {
                    this.$tours['myTour'].start();
                }, 500);

                localStorage.setItem('hasShownTour', 'true');
                this.setCookie('hasShownTour', 'true', 365);
            }
        },
        getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        },
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            document.cookie = `${name}=${value}; ${expires}; path=/`;
        }
    },
    computed:{
        ...mapState(useAuthStore, {
            user: (state) => state.user,
        })
    }
};
</script>

<style >
.starters-tour-guide {
    /* Your existing styles for the tour guide */
}

.starters-tour-guide::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(8px); /* Adjust the blur radius as needed */
    z-index: -1;
}
.starters-tour-guide .v-step__header,.v-step__arrow--dark[data-v-da2d894c]:before{
    background:#0039a6 !important;
}
.starters-tour-guide .v-step{
    background:#0039a6 !important;
    width:200px!important;
    position: relative;
    opacity: initial;
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
