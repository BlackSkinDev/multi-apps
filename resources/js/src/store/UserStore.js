import { defineStore } from 'pinia'
import UserApi from "../apis/User";
import {API_SUCCESS_MESSAGE} from "../constants/constants";
export const useUserStore = defineStore('UserStore', {
    state: () => {
        return {
            processingRequest:false,
            users:[],
            user:{}
        }
    },
    getters: {

    },
    actions: {
        async uploadProfilePicture(formData) {
            this.processingRequest = true
            try {
                const {data:{data}} = await UserApi.uploadProfilePicture(formData)
                this.users = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

    },

})
