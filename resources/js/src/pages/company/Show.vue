<template>
    <div class="flex">
        <div class="w-2/3 pr-8">
            <h1 class="text-3xl font-bold mb-8">My Company</h1>
            <div class="mb-8">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <TextInput label="Company Name" placeholder="Company Name" v-model="companyForm.name" type="text" />
                    <RichEditor label="Company Description" @editor-text="setEditorValue" :defaultValue="companyForm.description" v-if="companyForm.description" />
                    <FileInput label="Company Logo" placeholder="Company Logo" @file-selected="handleLogoChange" />
                    <Button :text="'Save Changes'" :disabled="disabled" :loading="loading" />
                </form>
            </div>
        </div>

        <div class="w-1/3 pl-8">
            <div class="flex flex-col justify-between h-full">
                <div>
                    <div class="flex flex-col mb-4 space-y-4 items-center">
                        <h3 class="text-lg font-bold text-center text-gray-600">{{ company.name }}</h3>
                        <img :src="companyForm.logo" alt="Company Logo" class="w-60 h-40  mb-2 mt-2" />
                        <p class="text-sm text-gray-600 text-center text-justify" v-html="company.description "/>
                    </div>
                </div>
<!--                <div>-->
<!--                    <h2 class="text-2xl font-bold mb-4">Invite Team Members</h2>-->
<!--                    <form @submit.prevent="inviteMember" class="space-y-4">-->
<!--                        <TextInput label="Email" placeholder="Email" v-model="newMember.email" type="email" name="emails" />-->
<!--                        <Button :text="'Send Invitation'" :disabled="!isEmailValid(newMember.email)" />-->
<!--                    </form>-->
<!--                </div>-->
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
import {UPDATE_COMPANY_SUCCESS_MESSAGE} from "../../constants/constants";
export default {
    components: {
        TextInput,
        RichEditor,
        FileInput,
        Button,
    },
    data() {
        return {
            companyForm: {},
            src:"",
        };
    },
    async created() {
        await TriggerPiniaAction(this.fetchUserCompany())
        await this.$nextTick(() => {
            this.companyForm = {
                name: this.company?.name,
                description: this.company?.description,
                logo: this.company?.image
            };
        });

    },
    methods: {
        ...mapActions(useCompanyStore,['fetchUserCompany','updateUserCompany']),
        async submitForm() {
            const companyData = new FormData()
            companyData.append('logo', this.src)
            companyData.append('name', this.companyForm.name)
            companyData.append('description', this.companyForm.description)
            companyData.append('_method', 'PATCH')
            await TriggerPiniaAction(this.updateUserCompany(companyData),UPDATE_COMPANY_SUCCESS_MESSAGE,true)
        },
        setEditorValue(text) {
            this.companyForm.description = text;
        },
        handleLogoChange(file) {
            this.src = file;
        },

    },
    computed:{
        ...mapState(useCompanyStore,{
            company:(state)  => state.company,
            loading:(state)  => state.processingRequest
        }),
        disabled(){
            return this.companyForm.name === '' ||
                   this.companyForm.description === ''
        }
    }
};
</script>
