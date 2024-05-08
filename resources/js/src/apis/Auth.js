import {authApi,publicApi} from "./Api";


const ENDPOINT = 'auth';
export default {

    register(userData){
        return publicApi.post(`${ENDPOINT}/register`,userData)
    },

    login(credentials){
        return publicApi.post(`${ENDPOINT}/login`,credentials)
    },

    logout(){
        return authApi.delete(`${ENDPOINT}/logout`)
    },
    getAuthUser(){
        return authApi.get(`${ENDPOINT}/user`)
    },

    verifyEmail(token){
        return publicApi.post(`${ENDPOINT}/email/verify`,{token})
    },

    resendEmail(email){
        return publicApi.post(`${ENDPOINT}/email/resend`,{email})
    },

}
