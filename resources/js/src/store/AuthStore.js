import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../constants/constants";
import authApi from "../apis/Auth";

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

        async loginWithPassword(userData) {
            this.processingAuthRequest = true
            try {
                const {data:{data}} = await authApi.login(userData)
                const { email, name,refresh_token,is_admin,photo } = data;
                this.user = {email, name,is_admin,photo}
                localStorage.setItem('logged_in',true)
                localStorage.setItem('refresh_token',refresh_token)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingAuthRequest = false
            }
        },

        async sendUserMagicLink(email) {
            this.processingAuthRequest = true
            try {
                await authApi.sendMagicLink(email)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingAuthRequest = false
            }
        },

        async loginWithMagicLink(token) {
            this.processingAuthRequest = true
            try {
                const {data:{data}} = await authApi.loginWithMagicLink(token)
                const { email, name,refresh_token,is_admin,photo } = data;
                this.user = {email, name,is_admin,photo}
                localStorage.setItem('logged_in',true)
                localStorage.setItem('refresh_token',refresh_token)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingAuthRequest = false
            }
        },

        async fetchAuthUser() {
            try {
                const {data:{data}} = await authApi.getAuthUser()
                this.user = {...data}
                return API_SUCCESS_MESSAGE
            } catch (error) {
                await this.logout();
                return error.response?.data?.message
            }
        },

        async logout() {
            try {
                await authApi.logout()
                localStorage.removeItem('logged_in')
                localStorage.removeItem('refresh_token')
                this.user = {}
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async verifyEmail(token) {
            try {
                await authApi.verifyEmail(token)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async resendEmail(email) {
            this.processingAuthRequest = true
            try {
                await authApi.resendEmail(email)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }finally {
                this.processingAuthRequest = false
            }
        },

        async  requestPasswordResetLink(email) {
            this.processingAuthRequest = true
            try {
                await authApi.requestPasswordResetLink(email)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }finally {
                this.processingAuthRequest = false
            }
        },

        async resetPassword(data) {
            this.processingAuthRequest = true
            try {
                await authApi.resetPassword(data)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }finally {
                this.processingAuthRequest = false
            }
        },

    },

})
