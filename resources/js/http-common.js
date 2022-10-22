import axios from "axios";
import Vue from 'vue';
import store from './store'
import router from './router'


const SUCCESS = 2;
const ERROR = 4;
const UN_AUTHENTICATED = 401;

const http = axios.create({
    headers: {
        "Content-type": "application/json"
    }
});

http.interceptors.request.use(function (config) {
    config.headers['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
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
    if (error.response.status == UN_AUTHENTICATED) {
        localStorage.setItem('access_token', null);
        store.commit("setLoggedIn", false);
        store.commit("setUserProfile", null);
        if (error.response.config.redirectIfUnAuthenticate)
            if (router.name !== "login") router.push({name: 'login'})
    }
    return Promise.reject(error);
});
export default http;
