import { defineStore } from 'pinia'
import {API_SUCCESS_MESSAGE} from "../constants";
import taskApi from "../apis/Task";
export const useTaskStore = defineStore('TaskStore', {
    state: () => {
        return {
            processingRequest:false,
            projects:[],
            task:{},
            selectedProjectTasks:[],
            loadingProjectTasks:false,
            selectedProjectTasksMirror:[],
            currentProjectId:null,

        }
    },
    getters: {

    },
    actions: {

        async fetchProjects(taskData) {
            try {
                const {data:{data}} = await taskApi.getProjects(taskData)
                this.projects = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async createTask(taskData) {
            this.processingRequest = true
            try {
                await taskApi.createTask(taskData)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async fetchTask(task_id) {
            this.processingRequest = true
            try {
                const {data:{data}} = await taskApi.getTask(task_id)
                this.task = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async editTask(task_id,taskData) {
            this.processingRequest = true
            try {
                const {data:{data}} = await taskApi.editTask(task_id,taskData)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async fetchProjectTasks(project_id) {
            this.loadingProjectTasks = true
            try {
                const {data:{data}} = await taskApi.getProjectTasks(project_id)
                this.currentProjectId = project_id
                this.selectedProjectTasks = [...data]
                this.selectedProjectTasksMirror = [...data]
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.loadingProjectTasks = false
            }
        },

        async swapTasksWithMirror() {
            this.selectedProjectTasks = this.selectedProjectTasks.map((task, idx) => {
                return {...task, priority: this.selectedProjectTasksMirror[idx].priority}
            })
            try {
                await taskApi.updatePriorities(this.selectedProjectTasks)
                this.selectedProjectTasksMirror = [...this.selectedProjectTasks]
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async deleteTask(task_id){
            try {
                await taskApi.deleteTask(task_id)
                await this.fetchProjectTasks(this.currentProjectId)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        }




    },

})
