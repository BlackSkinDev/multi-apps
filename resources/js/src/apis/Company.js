import {Api} from "./Api";

const BASE_ENPOINT = 'users/companies'

export default {

    createUserCompany(companyData) {
        const headers = {
            'Content-Type': 'multipart/form-data',
            Accept: 'application/json',
        };

        return Api.post(`${BASE_ENPOINT}`, companyData, { headers });
    },

    getUserCompany(){
        return Api.get(`${BASE_ENPOINT}`);
    },

    updateUserCompany(companyData) {
        const headers = {
            'Content-Type': 'multipart/form-data',
            Accept: 'application/json',
        };

        return Api.post(`${BASE_ENPOINT}`, companyData, { headers });
    },

    fetchCompanyUsers(q){
        const params = {...(q && { q })};
        return Api.get(`${BASE_ENPOINT}/people`,{params});
    },

    getCompanyUser(uuid){
        return Api.get(`${BASE_ENPOINT}/people/${uuid}`);
    }

}





