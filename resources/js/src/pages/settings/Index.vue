<template>
    <div>
        <p class="text-xl font-bold mb-8">Personal Settings</p>
        <div class="pr-8 md:pr-0 order-2 md:order-1 w-full md:w-1/3">
            <div class="mt-2">
                <p class="font-medium text-sm">Change Password</p>
                <form @submit.prevent="submitForm" class="space-y-4 mt-1">
                    <TextInput
                        placeholder="Old Password"
                        v-model="passwordForm.old_password"
                        type="password"
                    />
                    <TextInput
                        label="New Password"
                        placeholder="New Password"
                        :is-password="true"
                        v-model="passwordForm.new_password"
                    />
                    <Button :text="'Update Password'" :disabled="disabled" :loading="loading" />
                </form>
            </div>
        </div>

    </div>

</template>

<script>
import TextInput from "../../components/ui/TextInput.vue";
import Button from "../../components/ui/Button.vue";
import {useSettingStore} from "../../store/SettingStore";
import {mapActions, mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
import {APP_NAME, CHANGE_PASSWORD_SUCCESS_MESSAGE} from "../../constants/constants";
export default {
    components: {
        TextInput,
        Button,
    },
    data() {
        return {
            passwordForm: {
                old_password:"",
                new_password:""
            },
        };
    },
    created() {
        document.title = `${APP_NAME} | Personal Settings`;
    },
    methods: {
        ...mapActions(useSettingStore,['changeUserPassword']),
        async submitForm() {
            const res = await TriggerPiniaAction(this.changeUserPassword(this.passwordForm),CHANGE_PASSWORD_SUCCESS_MESSAGE,true)
            if (res){
                this.passwordForm = {
                    old_password:"",
                    new_password:""
                }
            }
        },
    },
    computed:{
        ...mapState(useSettingStore,{
            loading:(state)  => state.processingRequest
        }),
        disabled(){
            return this.passwordForm.old_password === '' ||
                this.passwordForm.new_password === ''
        }
    }
};
</script>
