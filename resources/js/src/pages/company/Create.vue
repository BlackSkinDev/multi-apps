<template>
    <div class="mt-28">
        <form @submit.prevent="submitForm" class="p-4 max-w-xl mx-auto mt-2 space-y-8">
            <h2 class="text-xl text-center ">Hi {{user.name}}, Plese create your company to get started</h2>
            <TextInput label="Company Name" placeholder="Company Name" v-model="company.name" type="text"/>
            <RichEditor label="Company Description" @editor-text="setEditorValue"/>
            <FileInput label="Company Logo" placeholder="Company Logo" v-model="company.logo" @file-selected="handleLogoChange"/>
            <Button :text="'Create company'"  :disabled="disabled" :loading="loading"/>
        </form>
    </div>
</template>

<script>
import {useCompanyStore} from "../../store/CompanyStore";
import {mapState,mapActions} from "pinia";
import RichEditor from "../../components/ui/RichEditor.vue";
import TextInput from "../../components/ui/TextInput.vue";
import Button from "../../components/ui/Button.vue";
import FileInput from "../../components/ui/FileInput.vue";
import {useAuthStore} from "../../store/AuthStore";
import {APP_NAME, CREATE_COMPANY_SUCCESS_MESSAGE} from "../../constants/constants";
import {TriggerPiniaAction} from "../../util";
export default {
    components:{RichEditor,TextInput,Button,FileInput},
    data() {
        return {
            company: {
                name: '',
                description: '',
                logo: ''
            },
        };
    },
    methods: {
        ...mapActions(useCompanyStore,['createUserCompany']),
        async submitForm() {
            const companyData = new FormData()
            companyData.append('logo',this.company.logo)
            companyData.append('name',this.company.name)
            companyData.append('description',this.company.description)
            const res = await TriggerPiniaAction(this.createUserCompany(companyData),CREATE_COMPANY_SUCCESS_MESSAGE,true);
            if (res){
                this.$router.push('/dashboard')
            }
        },
        handleLogoChange(file) {
           this.company.logo = file
        },
        setEditorValue(value){
            this.company.description =  value
        },
    },
    mounted() {
        document.title = `${APP_NAME} | Create Company`;
    },
    computed:{
        ...mapState(useCompanyStore,{
            loading:(state)  => state.processingRequest
        }),
        ...mapState(useAuthStore,{
            user:(state)  => state.user,
        }),
        disabled(){
            return this.company.name        === '' ||
                   this.company.description === '' ||
                   this.company.logo        === ''
        }
    }
};
</script>
