<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-32">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Welcome back <span class="ml-4">&#128075;</span>
                </h1>

                <!--  Login Form for Password Method-->
                <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="loginUser" v-show="sign_in_method === 'password'">

                    <Input
                        label="Email"
                        placeholder="name@company.com"
                        type="email"
                        v-model="passwordLoginFormData.email"
                        :key="inputKey"
                    />
                    <Input
                        label="Password"
                        placeholder="••••••••"
                        :is-password="true"
                        v-model="passwordLoginFormData.password"
                        :key="inputKey"
                    />

                    <Button :text="'Sign in'"  :disabled="disabled" :loading="loading"/>

                </form>
                <!--  Login Form for Password Method-->

                <!--  Login Form for Magic Link Method-->
                <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="loginUser" v-show="sign_in_method === 'magic_link'">
                    <Input
                        label="Email"
                        placeholder="name@company.com"
                        type="email"
                        v-model="magicLoginFormData.email"
                        :key="inputKey"
                    />
                    <Button :text="'Sign in with Magic Link'"  :disabled="disabled" :loading="loading"/>
                    <p class="text-gray-700 text-center text-sm">
                        Don't have an account? <router-link :to="{name:'homepage'}" class="text-blue-500 hover:text-blue-700">Sign up here.</router-link>
                    </p>
                </form>
                <!--  Login Form for Magic Link Method-->
                <Button :text="btn_text"  :bg-class="'bg-orange-700 hover:bg-orange-600'" @click="switchLoginMethod"/>
                <p class="text-gray-700 text-center text-sm">
                    Don't have an account? <router-link :to="{name:'homepage'}" class="text-blue-500 hover:text-blue-700">Sign up here.</router-link>
                </p>

            </div>
        </div>
    </div>
</template>

<script>

import Input from "../../components/ui/input.vue";
import Button from "../../components/ui/button.vue";
import {mapActions, mapState} from "pinia/dist/pinia";
import {useAuthStore} from "../../store/AuthStore"
import {TriggerPiniaAction} from "../../util";
import {APP_NAME} from "../../constants/constants";

export default {
    name: "login.vue",
    components:{Input,Button},
    data(){
        return{
            passwordLoginFormData:{
                email:"",
                password:""
            },
            magicLoginFormData:{
                email:"",
            },
            sign_in_method:'password',
            inputKey:0,
            app_name:APP_NAME
        }
    },
    mounted() {
        document.title = `${this.app_name} | Sign in`;
    },
    methods:{
        ...mapActions(useAuthStore,['login']),
        async loginUser() {
            const formData = this.sign_in_method === 'password' ? this.passwordLoginFormData : this.magicLoginFormData
            const response = await TriggerPiniaAction(this.login(formData))
            if (response) this.$router.push({ name: "dashboard" })
        },
        switchLoginMethod(){
            this.clearInputErrors();
            this.passwordLoginFormData.password  = ""
            if (this.sign_in_method === 'magic_link'){
                this.sign_in_method = 'password'
            }
            else{
                this.sign_in_method = 'magic_link'
            }
        },
        clearInputErrors(){
            this.inputKey += 1;
        }
    },
    computed:{
        ...mapState(useAuthStore,{
            loading:(state)         => state.processingAuthRequest,
        }),
        disabled(){
            if (this.sign_in_method === 'password') return this.passwordLoginFormData.email     === '' || this.passwordLoginFormData.password    === ''
            if (this.sign_in_method === 'magic_link') return this.magicLoginFormData.email   === ''
        },
        btn_text(){
            if (this.sign_in_method === 'magic_link') return "Switch to Password"
            if (this.sign_in_method === 'password') return "Switch to Magic Link"
        }
    },
}
</script>

<style scoped>

</style>
