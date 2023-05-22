import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../constants/constants";
import settingApi from "../apis/Setting";

export const useSettingStore = defineStore('CompanyStore', {
    state: () => {
        return {
            processingRequest:false,
        }
    },

    actions: {
        async changeUserPassword(data) {
            this.processingRequest = true
            try {
                await settingApi.changeUserPassword(data)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

    },

})
