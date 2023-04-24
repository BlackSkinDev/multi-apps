import axios from 'axios'



export const KinbanAppApi = axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}kinban-app/`,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

