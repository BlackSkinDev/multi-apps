import {Api,publicApi} from "./Api";


const ENDPOINT = 'auth';
export default {

    register(userData){
        return publicApi.post(`${ENDPOINT}/register`,userData)
    },

    login(credentials){
        return publicApi.post(`${ENDPOINT}/login`,credentials)
    },

    sendMagicLink(email){
        return Api.post(`${ENDPOINT}/magic-login`,{email})
    },

    loginWithMagicLink(token){
        return Api.post(`${ENDPOINT}/magic-login/verify`,{token})
    },

    logout(){
        return Api.post(`${ENDPOINT}/logout`)
    },
    getAuthUser(){
        return Api.get(`${ENDPOINT}/user`)
    },

    verifyEmail(token){
        return Api.post(`${ENDPOINT}/email/verify`,{token})
    },

    resendEmail(email){
        return Api.post(`${ENDPOINT}/email/resend`,{email})
    },

    requestPasswordResetLink(email){
        return Api.post(`${ENDPOINT}/password-reset`,{email})
    },

    resetPassword(data){
        return Api.post(`${ENDPOINT}/password-reset/reset`,data)
    },




}
