import {KinbanAppApi} from "./Api";


const ENDPOINT = 'auth';
export default {

    register(userData){
        return KinbanAppApi.post(`${ENDPOINT}/register`,userData)
    },
    login(credentials){
        return KinbanAppApi.post(`${ENDPOINT}/login`,credentials)
    },
    logout(){
        return KinbanAppApi.post(`${ENDPOINT}/logout`)
    },
    fetchAuthUser(){
        return KinbanAppApi.get(`${ENDPOINT}/user`)
    },





}
