import {KinbanAppApi} from "./Api";

const BASE_ENDOINT = 'tasks'

export default {

    deleteTask(task_id){
        return KinbanAppApi.delete(`${BASE_ENDOINT}/${task_id}`)
    },

    updateProjectTask(task_id,request){
        return KinbanAppApi.patch(`${BASE_ENDOINT}/${task_id}`,request)
    },

    unassignTask(task_id){
        return KinbanAppApi.patch(`${BASE_ENDOINT}/${task_id}/unassign`)
    },

    moveTask(task_id,request){
        return KinbanAppApi.patch(`${BASE_ENDOINT}/${task_id}/move`,request)
    }



}
