<template>

        <div class="w-full bg-white rounded-lg shadow sm:max-w-md p-10 mx-auto mt-40">
            <div v-if="verificationStatus === 'failed'" >
                <Input v-model="email" type="email" label="Email" placeholder="name@company.com" class="mt-4"/>
                <router-link to="#" class="mt-10">
                    <Button :text="'Request new link'"  :disabled="disabled" @click="resendVerificationEmail"  class="mt-4"/>
                </router-link>
            </div>
        </div>

</template>

<script>
import {useAuthStore} from "../../store/AuthStore";
import {mapActions} from "pinia";
import SquareLoader from "vue-spinner/src/SquareLoader.vue";
import {TriggerPiniaAction} from "../../util";
import {
    EMAIL_VERIFICATION_RESENT_SUCCESS_MESSAGE,
    EMAIL_VERIFICATION_SUCCESS_MESSAGE
} from "../../constants/constants";
import Button from "../../components/ui/button.vue";
import Input from "../../components/ui/input.vue";

export default {
    name: "verify-email",
    components:{Button,SquareLoader,Input},
    data() {
        return {
            verificationStatus: '',
            email:""
        }
    },
    async mounted() {
        const token = this.$route.params.token
        const res = await TriggerPiniaAction(this.verifyEmail(token),EMAIL_VERIFICATION_SUCCESS_MESSAGE,true);
        if(res) this.$router.push('/signin')
        else    this.verificationStatus = 'failed'
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
        disabled(){
            return this.email === ''
        },
    }
}
</script>

<style scoped>

</style>
