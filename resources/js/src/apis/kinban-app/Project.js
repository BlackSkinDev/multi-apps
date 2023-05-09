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

    getUsers(q){
        const params =  { ...(q && { q })};
        return KinbanAppApi.get(`${BASE_ENDOINT}/users`,{params})
    },

    saveProjectTask(project_id,request){
        return KinbanAppApi.post(`${BASE_ENDOINT}/${project_id}/tasks`,request)
    },

}
