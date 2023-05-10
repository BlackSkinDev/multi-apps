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
        async fetchUsers(q) {

            try {
                const {data:{data}} = await UserApi.getUsers(q)
                this.users = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async fetchUser(id) {

            try {
                const {data:{data}} = await UserApi.getUser(id)
                this.user = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },
    },

})
