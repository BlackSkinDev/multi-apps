import {Api} from "./Api";

const BASE_ENPOINT = 'users'

export default {

    uploadProfilePicture(formData) {
        const headers = {
            'Content-Type': 'multipart/form-data',
            Accept: 'application/json',
        };

        return Api.post(`${BASE_ENPOINT}/profile-picture`, formData,{ headers });
    },

}
