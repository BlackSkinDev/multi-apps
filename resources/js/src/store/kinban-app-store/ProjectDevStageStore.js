import { defineStore } from 'pinia'
import ProjectDevStageApi from "../../apis/kinban-app/ProjectDevStage";
import {API_SUCCESS_MESSAGE} from "../../constants/kinban-app-constants";
export const useProjectDevStageStore = defineStore('ProjectDevStageStore', {
    state: () => {
        return {
            processingRequest:false,
            stages:[],

        }
    },
    getters: {

    },
    actions: {

        async fetchProjectDevStages() {
            try {
                const {data:{data}} = await ProjectDevStageApi.getProjectDevStages()
                this.stages = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },



    },

})
