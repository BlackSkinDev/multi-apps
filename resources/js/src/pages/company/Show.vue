<template>
    <div class="flex">
        <div class="w-2/3 pr-8">
            <h1 class="text-3xl font-bold mb-8">My Company</h1>
            <div class="mb-8">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <TextInput label="Company Name" placeholder="Company Name" v-model="company_name" type="text" />
                    <RichEditor label="Company Description" @editor-text="setEditorValue" :defaultValue="company_description" v-if="company_description" />
                    <FileInput label="Company Logo" placeholder="Company Logo" @file-selected="handleLogoChange" />
                    <Button :text="'Save Changes'" :disabled="disabled" :loading="loading" />
                </form>
            </div>
        </div>

        <div class="w-1/3 pl-8">
            <div class="flex flex-col justify-between h-full">
                <div>
                    <div class="flex flex-col mb-4 space-y-4 items-center">
                        <h3 class="text-lg font-bold text-center text-gray-600">{{ company_name }}</h3>
                        <img :src="company_image" alt="Company Logo" class="w-60 h-40  mb-2 mt-2" />
                        <p class="text-sm text-gray-600 text-center text-justify">{{ company_description }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-4">Invite Team Members</h2>
                    <form @submit.prevent="inviteMember" class="space-y-4">
                        <TextInput label="Email" placeholder="Email" v-model="newMember.email" type="email" name="emails" />
                        <Button :text="'Send Invitation'" :disabled="!isEmailValid(newMember.email)" />
                    </form>
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
import {useCompanyStore} from "../../store/CompanyStore";
import {mapActions, mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
export default {
    components: {
        TextInput,
        RichEditor,
        FileInput,
        Button,
    },
    data() {
        return {
            companyForm: {
                name: this.company?.name,
                description: this.company?.description,
                logo: null
            },
            src:'',
            newMember: {
                email: '',
            },
            disabled: false,
            loading: false,
        };
    },
    async created() {
        await TriggerPiniaAction(this.fetchUserCompany())
    },
    methods: {
        ...mapActions(useCompanyStore,['fetchUserCompany']),
        submitForm() {
            this.disabled = true;
            this.loading = true;

            setTimeout(() => {
                this.disabled = false;
                this.loading = false;
            }, 2000);
        },
        setEditorValue(text) {
            this.company.description = text;
        },
        handleLogoChange(file) {
            this.company.logo = file;
        },
        inviteMember() {
            if (this.isEmailValid(this.newMember.email)) {
                console.log(`Inviting ${this.newMember.email}`);
            }
        },
        isEmailValid(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },
    },
    computed:{
       company_name:{
           get(){
               return useCompanyStore().company.name
           },
           set(value){
               useCompanyStore().company.name = value
           }
       },
        company_description:{
            get(){
                return useCompanyStore().company.description
            },
            set(value){
                useCompanyStore().company.description = value
            }
        },
        company_image:{
            get(){
                return useCompanyStore().company.image
            },
            set(value){
               // useCompanyStore().company.description = value
            }
        },

    }
};
</script>
