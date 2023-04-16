import {Api} from "./Api";

const BASE_ENDPOINT = 'tasks'

export default {

    getProjects(){
        return Api.get(`projects`)
    },

    createTask(taskData){
        return Api.post(`${BASE_ENDPOINT}`,taskData)
    },

    getTask(task_id){
        return Api.get(`${BASE_ENDPOINT}/${task_id}`)
    },

    editTask(task_id,taskData){
        return Api.patch(`${BASE_ENDPOINT}/${task_id}`,taskData)
    },

    getProjectTasks(project_id){
        return Api.get(`projects/${project_id}/tasks`)
    },

    updatePriorities(tasks){
        return Api.patch(`${BASE_ENDPOINT}/update-priorities`,{tasks})
    },

    deleteTask(task_id){
        return Api.delete(`${BASE_ENDPOINT}/${task_id}`)
    }








}
