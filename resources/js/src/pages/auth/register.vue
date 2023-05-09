<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-32">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
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
                </form>
            </div>
        </div>
    </div>


</template>

<script>

import Input from "../../components/ui/input.vue";
import Button from "../../components/ui/button.vue";
import {useAuthStore} from "../../store/kinban-app-store/AuthStore";
import {mapState,mapActions} from "pinia";
import {TriggerAction} from "../../helpers/TriggerAction";
import {REGISTRATION_SUCCESS_MESSAGE} from "../../constants/constants";

export default {
    name: "register.vue",
    components:{Input,Button},
    data(){
        return {
            registerFormData:{
                name:"",
                email:"",
                password:""
            }
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
