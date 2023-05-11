<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-32">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Welcome back <span class="ml-4">&#128075;</span>
                </h1>
                <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="loginUser">

                    <Input
                        label="Email"
                        placeholder="name@company.com"
                        type="email"
                        v-model="loginFormData.email"
                    />
                    <Input
                        label="Password"
                        placeholder="••••••••"
                        :is-password="true"
                        v-model="loginFormData.password"
                    />

                    <Button :text="'Login'" :disabled="false"></Button>
                    <p class="text-gray-700 text-center text-sm">
                        Don't have an account? <router-link :to="{name:'homepage'}" class="text-blue-500 hover:text-blue-700">Sign up here.</router-link>
                    </p>
                </form>
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

export default {
    name: "login.vue",
    components:{Input,Button},
    data(){
        return{
            loginFormData:{
                email:"",
                password:""
            },
        }
    },
    methods:{
        ...mapActions(useAuthStore,['login']),
        async loginUser() {
            const response = await TriggerPiniaAction(this.login(this.loginFormData))
            if (response) this.$router.push({ name: "dashboard" })
        }
    },
    computed:{
        ...mapState(useAuthStore,{
            loading:(state)         => state.processingAuthRequest,
        }),
    },
}
</script>

<style scoped>

</style>
