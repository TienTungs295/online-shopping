import axios from "axios";
import Vue from 'vue';

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
        if (response.config.alert && data.message != null && data.message != undefined)
            Vue.prototype.$toastr.s(data.message);

        return data.data;
    } else {
        if (data.message != null && data.message != undefined)
            Vue.prototype.$toastr.e(data.message);

        return Promise.reject(data);
    }
}, function (error) {
    return Promise.reject(error);
});
export default http;
