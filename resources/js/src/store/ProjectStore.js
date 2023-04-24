import { defineStore } from 'pinia'
import projectApi from "../apis/Project";
import {API_SUCCESS_MESSAGE} from "../../constants";
export const useProjectStore = defineStore('ProjectStore', {
    state: () => {
        return {
            processingRequest:false,
            projects:[],
            project:{},
            project_stages_tasks:[],
            users:[],
            // task:{},
            // selectedProjectTasks:[],
            // loadingProjectTasks:false,
            // selectedProjectTasksMirror:[],
            // currentProjectId:null,

        }
    },
    getters: {

    },
    actions: {

        async createProject(request) {
            this.processingRequest = true
            try {
                await projectApi.createProject(request)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },


        async fetchProjects() {
            this.processingRequest = true
            try {
                const {data:{data}} = await projectApi.getProjects()
                this.projects = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }finally {
                this.processingRequest = false
            }
        },

        async fetchProject(ref) {
            this.processingRequest = true
            try {
                const {data:{data}} = await projectApi.getProject(ref)
                this.project = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }finally {
                this.processingRequest = false
            }
        },

        async updateProject(request) {
            try {
                await projectApi.updateProject(this.project.id,request)
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            }
        },

        async fetchTasks() {
            this.processingRequest = true
            try {
                const {data:{data}} = await projectApi.getTasks(this.project.id)
                this.project_stages_tasks = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },

        async fetchUsers() {

            try {
                const {data:{data}} = await projectApi.getUsers()
                this.users = data
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
