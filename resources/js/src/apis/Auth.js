import {Api} from "./Api";


const ENDPOINT = 'auth';
export default {

    register(userData){
        return Api.post(`${ENDPOINT}/register`,userData)
    },
    login(credentials){
        return Api.post(`${ENDPOINT}/login`,credentials)
    },
    logout(){
        return Api.post(`${ENDPOINT}/logout`)
    },
    fetchAuthUser(){
        return Api.get(`${ENDPOINT}/user`)
    },





}
