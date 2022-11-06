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
        if (response.config.redirectToHomeIfAuthen && router.history.current.name == "login") router.push({name: "home"});
        if (response.config.alert && data.message != null && data.message != undefined)
            Vue.prototype.$toastr.s(data.message);
        return data.data;
    } else {
        if (data.message != null && data.message != undefined) {
            if (data.alert_type == 2) Vue.prototype.$toastr.w(data.message);
            else Vue.prototype.$toastr.e(data.message);
        }
        return Promise.reject(data);
    }
}, function (error) {
    if (error.response.status == UN_AUTHENTICATED) {
        if (error.response.config.alert401) Vue.prototype.$toastr.e("Bạn cần đăng nhập để thử hiện tác vụ này")
        localStorage.removeItem('access_token');
        store.commit("setUserProfile", null);
        if (error.response.config.redirectToLoginIfUnAuthen && router.history.current.name !== "login")
            router.push({name: 'login'});
    }
    return Promise.reject(error);
});
export default http;
