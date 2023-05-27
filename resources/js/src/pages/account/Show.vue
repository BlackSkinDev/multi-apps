<template>
    <div class="px-16 mt-28">
        <p class="text-xl font-bold mb-8">My Account</p>
        <div class="flex flex-col md:flex-row justify-between">
            <div class="w-full md:w-2/3 pr-8 order-2 md:order-1">
                <div class="mb-8">
                    <form @submit.prevent="submitForm" class="space-y-4">
                        <TextInput label="Name" placeholder="Name" v-model="userForm.name" type="text" />
                        <TextInput label="Username" placeholder="Username" v-model="userForm.username" type="text" />
                        <TextInput label="Phone" placeholder="Phone" v-model="userForm.phone" type="text" />
                        <TextInput label="Linkedin" placeholder="Linkedin" v-model="userForm.linkedin" type="text" />
                        <RichEditor ref="richEditor" label="Bio" @editor-text="setEditorValue" :defaultValue="userForm?.bio" v-if="userForm?.bio || isEditing" />
                        <Button :text="'Save Changes'" :disabled="disabled" :loading="loading" />
                    </form>
                </div>
            </div>

            <div class="w-full md:w-1/3 mt-4 md:mt-0 md:pl-8 order-1 md:order-2">
                <div class="flex flex-col mb-4 space-y-4 items-center">
                    <img v-if="userInfo.image" :src="userInfo.image" alt="My Logo" class="w-750 h-75  mb-" />
                    <p class="font-bold text-center text-gray-600">{{ userInfo?.name }}</p>
                    <p v-if="userInfo.email">{{userInfo.email}}</p>
                    <p v-if="userInfo.username">@{{userInfo.username}}</p>
                    <p  v-if="userInfo.linkedin">{{userInfo.linkedin}}</p>
                    <p  v-if="userInfo.phone">{{userInfo.phone}}</p>
                    <p  v-if="userInfo.bio" class="text-sm text-gray-600 text-center text-justify" v-html="userInfo?.bio "/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RichEditor from "../../components/ui/RichEditor.vue";
import TextInput from "../../components/ui/TextInput.vue";
import Button from "../../components/ui/Button.vue";
import FileInput from "../../components/ui/FileInput.vue";
import {useUserStore} from "../../store/UserStore";
import {mapActions, mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
import {APP_NAME, UPDATE_USER_ACCOUNT_SUCCESS_MESSAGE} from "../../constants/constants";
export default {
    components: {
        TextInput,
        RichEditor,
        FileInput,
        Button,
    },
    data() {
        return {
            userForm: {},
            src:"",
            isEditing:false
        };
    },
    async created() {
        document.title = `${APP_NAME} | My Account`;
        await TriggerPiniaAction(this.fetchUserAccountInfo())
        await this.$nextTick(() => {
            this.userForm = {...this.userInfo}
        });
    },
    methods: {
        ...mapActions(useUserStore,['fetchUserAccountInfo','updateUserInfo']),
        async submitForm() {
            await TriggerPiniaAction(this.updateUserInfo(this.userForm),UPDATE_USER_ACCOUNT_SUCCESS_MESSAGE,true)
        },
        setEditorValue(text) {
            this.isEditing = this.$refs.richEditor.isEditing
            this.userForm.bio = text;
        },
        handleLogoChange(file) {
            this.src = file;
        },

    },
    computed:{
        ...mapState(useUserStore,{
            userInfo:(state)  => state.userAccountInfo,
            loading:(state)  => state.processingRequest
        }),
        disabled(){
            return this.userForm.name === '' ||
                   this.userForm.username === ''

        }
    }
};
</script>
