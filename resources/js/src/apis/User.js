import {KinbanAppApi} from "./Api";

const BASE_ENDOINT = 'users'

export default {


    getUsers(q){
        const params =  { ...(q && { q })};
        return KinbanAppApi.get(`${BASE_ENDOINT}`,{params})
    },





}
