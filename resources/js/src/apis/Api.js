import axios from 'axios'


// Public API instance with default options
export const Api = axios.create({
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

