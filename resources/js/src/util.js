import {toast} from "./plugins/Toast";
import {API_SUCCESS_MESSAGE} from "./constants/constants";



export const TriggerPiniaAction = async (action, message = null, triggerSuccessToast = false) => {
    const response = await action;

    if (response !== API_SUCCESS_MESSAGE) {
        toast.error(response);
    } else if (response === API_SUCCESS_MESSAGE && triggerSuccessToast && message) {
        toast.success(message);
    }

    return response === API_SUCCESS_MESSAGE;
};

export const authCheck = () => {
    if (localStorage.getItem('logged_in')) return true
    return false
}


export const ValidateEmail =  (email) => {
    let emailPattern = /\S+@\S+\.\S+/;
    return emailPattern.test(email);
};

export const ValidatePassword =  (password) => {
    return password.length >= 6;
};


export const ValidateUsername =  (username) => {
    return username.length >= 6;
};

export const getRandomBgColors =  () => {
    let bg_colors = []
    for (let i = 0; i < 500; i++) {
        const color = '#' + Math.floor(Math.random()*16777215).toString(16);
        bg_colors.push(color);
    }
    return bg_colors;
};


