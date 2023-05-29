import {toast} from "./plugins/Toast";
import {API_SUCCESS_MESSAGE} from "./constants/constants";
import tinycolor from 'tinycolor2';

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
        const color = '#' + Math.floor(Math.random()*1677).toString(16);
        bg_colors.push(color);
    }
    return bg_colors;
};


export const getLighterColor =  (color, amount) => {

    const hslColor = tinycolor(color).toHsl();

    hslColor.l += 3;

    return tinycolor(hslColor).toHexString();
};


export const  ColorLuminance = (hex, lum)  => {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    }
    lum = lum || 0;

    // convert to decimal and change luminosity
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i*2,2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00"+c).substr(c.length);
    }

    return rgb;
}
