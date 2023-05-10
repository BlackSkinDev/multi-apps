<template>
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-2/3 h-screen bg-gray-200 md:bg-transparent hidden md:block">
            <!-- Replace the src with your own image -->
            <img class="w-full h-full object-cover" :src="team" alt="Image">
        </div>
        <div class="flex flex-col justify-center items-center w-full md:w-1/3 px-8 py-6">
            <h1 class="font-bold text-xl p-6 w-full text-gray-700">
                Simplify project management, boost team collaboration, and stay on track with <span class="text-blue-700 cursor-pointer">ProjectzPilot.</span>
            </h1>
            <div class="w-full">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-700">
                        Get started for free
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="registerAccount">
                        <Input
                            label="Name"
                            placeholder="Afeez Azeez"
                            type="text"
                            v-model="registerFormData.name"
                        />
                        <Input
                            label="Email"
                            placeholder="name@company.com"
                            type="email"
                            v-model="registerFormData.email"
                        />
                        <Input
                            label="Password"
                            placeholder="••••••••"
                            :is-password="true"
                            v-model="registerFormData.password"
                        />
                        <Button :text="'Create Account'" :disabled="loading"></Button>
                        <p class="text-gray-700 text-center text-sm">
                            Already have an account? <router-link :to="{name:'signin'}" class="text-blue-500 hover:text-blue-700">Sign in here.</router-link>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Input from "../components/ui/input.vue";
import Button from "../components/ui/Button.vue";
import {mapActions, mapState} from "pinia/dist/pinia";
import {useAuthStore} from "../store/AuthStore";
import {TriggerAction} from "../helpers/TriggerAction";
import {REGISTRATION_SUCCESS_MESSAGE} from "../constants/constants";
import team from "../assests/images/pro.png"
export default {
    name: "Index.vue",
    components:{Input,Button},
    data(){
        return {
            registerFormData:{
                name:"",
                email:"",
                password:""
            },
            team:team
        }
    },
    methods:{
        ...mapActions(useAuthStore,['register']),
        async registerAccount() {
            const res = await TriggerAction(this.register(this.registerFormData),REGISTRATION_SUCCESS_MESSAGE,true);
            if (res) {
                setTimeout(() => {
                    this.$router.push("/kinban-app");
                }, 2000);
            }
        }
    },
    computed:{
        ...mapState(useAuthStore,{
            loading:(state)    => state.processingAuthRequest
        })
    }
}
</script>

<style scoped>

</style>
