import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../../constants/kinban-app-constants";
import authApi from "../../apis/kinban-app/Auth";
export const useAuthStore = defineStore('AuthStore', {
    state: () => {
        return {
            user:{},
            processingAuthRequest:false,
        }
    },

    actions: {

        async register(userData) {
            this.processingAuthRequest = true
            try {
                await authApi.register(userData)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingAuthRequest = false
            }
        },

        async login(userData) {
            this.processingAuthRequest = true
            try {
                const {data:{data}} = await authApi.login(userData)
                this.resetFormData('login')
                const { email, name,refresh_token } = data;
                this.user = {email,name}
                localStorage.setItem('logged_in',true)
                localStorage.setItem('refresh_token',refresh_token)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingAuthRequest = false
            }
        },


        async logout() {
            try {
                await authApi.logout()
                localStorage.removeItem('logged_in')
                localStorage.removeItem('refresh_token')
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

    },

})
