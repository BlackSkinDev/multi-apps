<template>
    <div class="w-full bg-white rounded-lg shadow sm:max-w-md p-10 mx-auto mt-40">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Verify Email
        </h1>
        <Input v-model="email" type="email" label="Email" placeholder="name@company.com" class="mt-6"/>
        <router-link to="#" class="mt-10">
            <Button :text="'Request new link'"  :disabled="disabled" :loading="loading" @click="resendVerificationEmail"  class="mt-4"/>
        </router-link>
    </div>
</template>

<script>
import {useAuthStore} from "../../store/AuthStore";
import {mapActions,mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
import {
    APP_NAME,
    EMAIL_VERIFICATION_RESENT_SUCCESS_MESSAGE,
    EMAIL_VERIFICATION_SUCCESS_MESSAGE
} from "../../constants/constants";
import Button from "../../components/ui/button.vue";
import Input from "../../components/ui/input.vue";

export default {
    name: "verify-email",
    components:{Button,Input},
    data() {
        return {
            email:""
        }
    },
    async mounted() {
        document.title = `${APP_NAME} | Verify Email`;
        const token = this.$route.params.token
        const res = await TriggerPiniaAction(this.verifyEmail(token),EMAIL_VERIFICATION_SUCCESS_MESSAGE,true);
        if(res) this.$router.push('/signin')
    },
    methods:{
        ...mapActions(useAuthStore,['verifyEmail','resendEmail']),
        async resendVerificationEmail() {
            const res = await TriggerPiniaAction(this.resendEmail(this.email), EMAIL_VERIFICATION_RESENT_SUCCESS_MESSAGE, true)
            if (res) {
                this.$router.push('/signin')
            }
            this.email = ""
        },
    },
    computed:{
        ...mapState(useAuthStore,{
           loading:(state)  => state.processingAuthRequest
        }),
        disabled(){
            return this.email === ''
        },
    }
}
</script>

<style scoped>

</style>
