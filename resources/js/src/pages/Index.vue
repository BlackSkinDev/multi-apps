<template>
    <div class="flex flex-col md:flex-row ">
        <div class="w-full md:w-2/3 min-h-screen bg-gray-200 md:bg-transparent hidden md:block">
            <img class="w-full h-full object-cover" :src="team_image" alt="Image">
        </div>
        <div class="flex flex-col justify-center items-center w-full md:w-1/3 px-8 py-6">
            <h1 class="font-bold text-xl p-6 w-full text-gray-700 " >
                Simplify project management, boost team collaboration, and stay on track with <span class="text-blue-700 cursor-pointer">{{app_name}}.</span>
            </h1>
            <div class="w-full">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-700">
                        Get started for free
                    </h1>
                    <form class="space-y-4 md:space-y-6 " :class="loading ? 'opacity-50' : ''" action="#" @submit.prevent="registerAccount">
                        <Input
                            label="Name"
                            placeholder="Afeez Azeez"
                            type="text"
                            v-model="registerFormData.name"
                        />
                        <Input
                            label="Username"
                            placeholder="afeez_dev"
                            type="text"
                            v-model="registerFormData.username"
                            name="username"
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
                        <Button :text="'Create Account'" :disabled="disabled" :loading="loading" />
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
import Button from "../components/ui/button.vue";
import {mapActions, mapState} from "pinia/dist/pinia";
import {useAuthStore} from "../store/AuthStore";
import {TriggerPiniaAction} from "../util";
import {APP_NAME, REGISTRATION_SUCCESS_MESSAGE} from "../constants/constants";
import team from "../assests/images/pro.png"
export default {
    name: "Index.vue",
    components:{Input,Button},
    data(){
        return {
            registerFormData:{
                name:"",
                email:"",
                username:"",
                password:""
            },
            team_image:team,
            app_name:APP_NAME
        }
    },
    mounted() {
        document.title = `${this.app_name} | Sign up`;
    },
    methods:{
        ...mapActions(useAuthStore,['register']),
        resetForm(){
            this.registerFormData ={
                name:"",
                email:"",
                username:"",
                password:""
            }
        },
        async registerAccount() {
            const res = await TriggerPiniaAction(this.register(this.registerFormData),REGISTRATION_SUCCESS_MESSAGE,true);
            if (res) {
                this.resetForm();
                setTimeout(() => {
                    this.$router.push("/signin");
                }, 2000);
            }
        },

    },
    computed:{
        ...mapState(useAuthStore,{
            loading:(state)         => state.processingAuthRequest,
        }),
        disabled(){
            return this.registerFormData.name     === ''
                || this.registerFormData.email    === ''
                || this.registerFormData.password === ''
                || this.registerFormData.username === ''

        }
    },
}
</script>

<style scoped>

</style>
