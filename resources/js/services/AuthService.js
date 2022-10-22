import http from "../http-common";

const PREFIX_URL = "/rest/auth/"

class AuthService {
    register(object, alert) {
        let url = PREFIX_URL + "register";
        return http.post(url, object, {alert: alert});
    };

    login(object, alert) {
        let url = PREFIX_URL + "login";
        return http.post(url, object, {alert: alert});
    };

    logout(object, alert) {
        let url = PREFIX_URL + "logout";
        return http.post(url, object, {alert: alert});
    };

    refresh(object, alert) {
        let url = PREFIX_URL + "refresh";
        return http.post(url, object, {alert: alert});
    };

    userProfile(alert) {
        let url = PREFIX_URL + "user-profile";
        return http.get(url, {alert: alert});
    };

    isAuthenticated(redirectIfUnAuthenticate) {
        let url = PREFIX_URL + "is-authenticated";
        return http.get(url, {redirectIfUnAuthenticate: redirectIfUnAuthenticate});
    }
}

export default new AuthService();
