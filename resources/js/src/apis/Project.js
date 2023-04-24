import {KinbanAppApi} from "./Api";

const BASE_ENDOINT = 'projects'

export default {

    createProject(request){
        return KinbanAppApi.post(`${BASE_ENDOINT}`,request)
    },

    getProjects(){
        return KinbanAppApi.get(`${BASE_ENDOINT}`)
    },

    getProject(ref){
        return KinbanAppApi.get(`${BASE_ENDOINT}/${ref}`)
    },

    updateProject(project_id,data){
        return KinbanAppApi.patch(`${BASE_ENDOINT}/${project_id}`,data)
    },

    getTasks(project_id){
        return KinbanAppApi.get(`${BASE_ENDOINT}/${project_id}/tasks`)
    },

    getUsers(){
        return KinbanAppApi.get(`${BASE_ENDOINT}/users`)
    },
    //
    // createTask(taskData){
    //     return Api.post(`${BASE_ENDPOINT}`,taskData)
    // },
    //
    // getTask(task_id){
    //     return Api.get(`${BASE_ENDPOINT}/${task_id}`)
    // },
    //
    // editTask(task_id,taskData){
    //     return Api.patch(`${BASE_ENDPOINT}/${task_id}`,taskData)
    // },
    //
    // getProjectTasks(project_id){
    //     return Api.get(`projects/${project_id}/tasks`)
    // },
    //
    // updatePriorities(tasks){
    //     return Api.patch(`${BASE_ENDPOINT}/update-priorities`,{tasks})
    // },

    deleteTask(task_id){
        return Api.delete(`${BASE_ENDPOINT}/${task_id}`)
    }








}
