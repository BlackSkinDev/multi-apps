import {Api} from "./Api";



export default {

    changeUserPassword(data) {
        return Api.post(`users/account/change-password`, data);
    },

}





