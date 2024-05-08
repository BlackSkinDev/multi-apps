import axios from 'axios'

const storedToken = localStorage.getItem('token') ?? null;

// Public API instance with default options
export const publicApi = axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}v1/`,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

export const authApi = axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}v1/`,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: storedToken ? `Bearer ${storedToken}` : null,
    }
});

export const authFileApi = axios.create({
    headers: {
        'Content-Type': 'multipart/form-data',
        Accept: 'application/json',
        Authorization: storedToken ? `Bearer ${storedToken}` : null,
    }
});
