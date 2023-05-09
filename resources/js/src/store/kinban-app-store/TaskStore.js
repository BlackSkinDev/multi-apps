import { defineStore } from 'pinia'
import TaskApi from "../../apis/kinban-app/Task";
import {API_SUCCESS_MESSAGE} from "../../constants/constants";
export const useTaskStore = defineStore('TaskStore', {
    state: () => {
        return {
            processingRequest:false,

        }
    },
    getters: {

    },
    actions: {

        async deleteProjectTask(task_id){
            try {
                await TaskApi.deleteTask(task_id)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async updateProjectTask(task_id,request) {
            this.processingRequest = true
            try {
                await TaskApi.updateProjectTask(task_id,request)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async unassignTask(task_id) {
            try {
                await TaskApi.unassignTask(task_id)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async moveTask(task_id,request){
            try {
                await TaskApi.moveTask(task_id,request)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },


    },

})
