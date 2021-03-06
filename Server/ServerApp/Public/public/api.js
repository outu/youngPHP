
const API_INDEX = "/ServerApp.php";


const apiRequest = (sModule, sController, sAction, arrExtraParameters = {}) => {
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    const params = new URLSearchParams();
    params.append('module', sModule);
    params.append('controller', sController);
    params.append('action', sAction);
    for (let k in arrExtraParameters) {
        if (arrExtraParameters.hasOwnProperty(k)) {
            params.append(k, arrExtraParameters[k]);
        }
    }

    return axios.post(API_INDEX, params).then((response) => {
        console.log("THEN_0", response);
        if (response.data.code != '200'){
            console.log('REJCET_0');
            return Promise.reject(response.data.message);
        }
        console.log("THEN_0_OK", response);

        return response;
    }).catch((error) => {
        console.log("CATCH_0", error);
        throw error;
    });
};



export const API_CREATE_COPY_TASK = (arrExtraParameters) => {
    return apiRequest('Task', 'Index', 'createCopyTask', arrExtraParameters)
}

export const API_CREATE_HIGH_TASK = (arrExtraParameters) => {
    return apiRequest('Task', 'Index', 'createHighTask', arrExtraParameters)
}

export const API_GET_HIGH_TASK = (arrExtraParameters) => {
    return apiRequest('Task', 'Good', 'getGood', arrExtraParameters)
}

export const API_GET_RUNNING_TASK = (arrExtraParameters) => {
    return apiRequest('Task', 'Index', 'getRunningTask', arrExtraParameters)
}

export const API_GET_COMPLETED_TASK = (arrExtraParameters) => {
    return apiRequest('Task', 'Index', 'getCompletedTask', arrExtraParameters)
}