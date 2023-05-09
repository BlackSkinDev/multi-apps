import { defineStore } from 'pinia'
import projectApi from "../../apis/kinban-app/Project";
import {API_SUCCESS_MESSAGE} from "../../constants/kinban-app-constants";
export const useProjectStore = defineStore('ProjectStore', {
    state: () => {
        return {
            processingRequest:false,
            projects:[],
            project:{},
            project_stages_tasks:[],
            users:[],
            newProject:{}
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
            try {
                const {data:{data}} = await projectApi.getProject(ref)
                this.project = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
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
                setTimeout(() => {
                    this.processingRequest = false
                }, 1000)
            }
        },

        async saveProjectTask(request) {
            this.processingRequest = true
            try {
                const {data:{data}} = await projectApi.saveProjectTask(this.project.id,request)
                this.newProject = data
                return API_SUCCESS_MESSAGE
            } catch (error) {
                return error.response?.data?.message
            } finally {
                this.processingRequest = false
            }
        },


    },

})
