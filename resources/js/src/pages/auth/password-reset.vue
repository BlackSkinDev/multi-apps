<template>
    <div class="w-full bg-white rounded-lg shadow sm:max-w-md p-8 mx-auto mt-40">
        <div v-show="!token">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Request Password Change
            </h1>
            <Input v-model="email" type="email" label="Email" placeholder="name@company.com" class="mt-6"/>
            <router-link to="#" class="mt-10">
                <Button :text="'Request password reset link'"  :disabled="disabled" :loading="loading" @click="sendRequestLink"  class="mt-4"/>
            </router-link>
        </div>
        <form class="space-y-4 md:space-y-6 mt-4" action="#" @submit.prevent="updatePassword" v-show="token">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Reset Password
            </h1>
            <Input
                label="Old Password"
                placeholder="••••••••"
                :is-password="true"
                v-model="passwordResetFormData.new_password"
            />
            <Input
                label="New Password"
                placeholder="••••••••"
                :is-password="true"
                v-model="passwordResetFormData.confirm_new_password"
            />
            <Button :text="'Reset Passsword'"  :disabled="disabled" :loading="loading"/>
        </form>
    </div>
</template>

<script>
import {useAuthStore} from "../../store/AuthStore";
import {mapActions,mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";

import {
    APP_NAME, PASSWORD_RESET_LINK_SENT_SUCCESS_MESSAGE, PASSWORD_RESET_SUCCESS_MESSAGE,
} from "../../constants/constants";
import Button from "../../components/ui/button.vue";
import Input from "../../components/ui/input.vue";


export default {
    name: "request-password-reset",
    components:{Button,Input},
    data() {
        return {
            email:"",
            passwordResetFormData:{
                new_password:"",
                confirm_new_password:""
            },
        }
    },
    async mounted() {
        document.title = `${APP_NAME} | New Password Request`;
    },
    methods:{
        ...mapActions(useAuthStore,['requestPasswordResetLink','resetPassword']),
        async sendRequestLink() {
            const res = await TriggerPiniaAction(this.requestPasswordResetLink(this.email), PASSWORD_RESET_LINK_SENT_SUCCESS_MESSAGE, true)
            if (res) {
                this.$router.push('/signin')
            }
            this.email = ""
        },
        async updatePassword() {
            const data = {...this.passwordResetFormData, token: this.token};
            const res = await TriggerPiniaAction(this.resetPassword(data), PASSWORD_RESET_SUCCESS_MESSAGE, true);
            if (res) this.$router.push('/signin')
        }
    },
    computed:{
        ...mapState(useAuthStore,{
            loading:(state)  => state.processingAuthRequest
        }),
        disabled(){
            if (this.token) return this.passwordResetFormData.confirm_new_password     === '' || this.passwordResetFormData.new_password    === ''
            if (!this.token) return this.email   === ''
        },
        token(){
            return this.$route.query.token
        }
    }
}
</script>

<style scoped>

</style>
