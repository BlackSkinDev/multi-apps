import {Api} from "./Api";

export default {

    createUserCompany(companyData) {
        const headers = {
            'Content-Type': 'multipart/form-data',
            Accept: 'application/json',
        };

        return Api.post(`users/companies`, companyData, { headers });
    },
}





