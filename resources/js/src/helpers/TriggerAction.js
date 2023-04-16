import {toast} from "../plugins/Toast";
import {API_SUCCESS_MESSAGE} from "../constants";

export const TriggerAction = async (action, message = null, triggerSuccessToast = false) => {
    const response = await action;

    if (response !== API_SUCCESS_MESSAGE) {
        toast.error(response);
    } else if (response === API_SUCCESS_MESSAGE && triggerSuccessToast && message) {
        toast.success(message);
    }

    return response === API_SUCCESS_MESSAGE;
};

