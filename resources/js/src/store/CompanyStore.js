import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../constants/constants";
import companyApi from "../apis/Company";
import {useAuthStore} from "./AuthStore";

export const useCompanyStore = defineStore('CompanyStore', {
    state: () => {
        return {
            processingRequest:false,
            company:{},
            users:[],
            searched_users:[]
        }
    },

    actions: {
        async createUserCompany(companyData) {
            this.processingRequest = true
            try {
                await companyApi.createUserCompany(companyData)
                await useAuthStore().fetchAuthUser()
                await this.fetchUserCompany();
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async fetchUserCompany() {
            try {
                const {data:{data}} = await companyApi.getUserCompany()
                this.company = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async updateUserCompany(companyData) {
            this.processingRequest = true
            try {
                await companyApi.updateUserCompany(companyData)
                await useAuthStore().fetchAuthUser()
                await this.fetchUserCompany();
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async fetchCompanyUsers(q) {
            this.processingRequest = true
            try {
                const {data:{data}} = await companyApi.fetchCompanyUsers(q)
                this.users =  data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async searchCompanyUsers(q) {
            this.processingRequest = true
            try {
                const {data:{data}} = await companyApi.fetchCompanyUsers(q)
                this.searched_users =  data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

    },

})
