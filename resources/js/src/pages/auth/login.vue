<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-32">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Welcome back <span class="ml-4">&#128075;</span>
                </h1>

                <!--  Login Form for Password Method-->
                <div>
                    <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="loginUserWithPassword" v-show="sign_in_method === 'password'">

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
                    <span class="flex justify-end text-gray-700 text-center text-sm">
                        <router-link :to="{name:'password-reset-request'}" class="text-blue-500 hover:text-blue-700 mt-2 ">Forgot password?</router-link>
                    </span>
                </div>
                <!--  Login Form for Password Method-->

                <!--  Login Form for Magic Link Method-->
                <div>
                    <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="loginUserWithMagicLink" v-show="sign_in_method === 'magic_link'">
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
                    <p class="text-gray-700 text-center text-sm mt-4">
                        Don't have an account? <router-link :to="{name:'homepage'}" class="text-blue-500 hover:text-blue-700">Sign up here.</router-link>
                    </p>
                </div>
                <!--  Login Form for Magic Link Method-->

            </div>
        </div>
    </div>
</template>

<script>

import Input from "../../components/ui/TextInput.vue";
import Button from "../../components/ui/Button.vue";
import {mapActions, mapState} from "pinia/dist/pinia";
import {useAuthStore} from "../../store/AuthStore"
import {TriggerPiniaAction} from "../../util";
import {APP_NAME, MAGIC_LINK_SENT_SUCCESS_MESSAGE, MAGIC_LOGIN_SUCCESS_MESSAGE} from "../../constants/constants";

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
        }
    },
    async mounted() {
        document.title = `${APP_NAME} | Sign in`;
        const token = this.$route.query.token
        if (token) {
            const res = await TriggerPiniaAction(this.loginWithMagicLink(token),MAGIC_LOGIN_SUCCESS_MESSAGE,true)
            if (res) {
                this.$router.push({ name: "dashboard" })
            }else{
                this.switchLoginMethod();
            }
        }
    },
    methods:{
        ...mapActions(useAuthStore,['loginWithPassword','loginWithMagicLink','sendUserMagicLink']),

        async loginUserWithPassword() {
            const response = await TriggerPiniaAction(this.loginWithPassword(this.passwordLoginFormData))
            if (response) this.$router.push({ name: "dashboard" })
        },

        async loginUserWithMagicLink() {
            const response = await TriggerPiniaAction(this.sendUserMagicLink(this.magicLoginFormData.email),MAGIC_LINK_SENT_SUCCESS_MESSAGE,true)
            if (response){
                this.magicLoginFormData.email = ""
            }
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
