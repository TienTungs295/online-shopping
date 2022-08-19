import axios from "axios";

const SUCCESS = 2;
const ERROR = 4;

const http = axios.create({
    headers: {
        "Content-type": "application/json"
    }
});
http.interceptors.request.use(function (config) {
    return config;
}, function (error) {
    return Promise.reject(error);
});
http.interceptors.response.use(function (response) {
    let data = response.data || {};
    if (data.status == SUCCESS) {
        // if (error.config.alert) {
        //
        // }
        return data.data;
    } else {
        return Promise.reject(data);
    }
}, function (error) {

    return Promise.reject(error);
});
export default http;
