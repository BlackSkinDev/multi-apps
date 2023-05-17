import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../constants/constants";
import companyApi from "../apis/Company";

export const useCompanyStore = defineStore('CompanyStore', {
    state: () => {
        return {
            processingRequest:false,
        }
    },

    actions: {
        async createUserCompany(companyData) {
            this.processingRequest = true
            try {
                await companyApi.createUserCompany(companyData)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },
    },

})
