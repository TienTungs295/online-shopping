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

    logout(alert) {
        let url = PREFIX_URL + "logout";
        return http.post(url, {alert: alert});
    };

    refresh(object, alert) {
        let url = PREFIX_URL + "refresh";
        return http.post(url, object, {alert: alert});
    };

    userProfile(alert) {
        let url = PREFIX_URL + "user-profile";
        return http.get(url, {alert: alert});
    };

    isAuthenticated(redirectToLoginIfUnAuthen, redirectToHomeIfAuthen) {
        let url = PREFIX_URL + "is-authenticated";
        return http.get(url,
            {
                redirectToLoginIfUnAuthen: redirectToLoginIfUnAuthen,
                redirectToHomeIfAuthen: redirectToHomeIfAuthen
            }
        );
    }

    update(object, alert) {
        let url = PREFIX_URL + "update";
        return http.post(url, object, {alert: alert, redirectToLoginIfUnAuthen: true});
    };

    changePass(object, alert) {
        let url = PREFIX_URL + "change-pass";
        return http.post(url, object, {alert: alert, redirectToLoginIfUnAuthen: true});
    };

    changePassWithToken(object, alert) {
        let url = PREFIX_URL + "change-password-with-token";
        return http.post(url, object, {alert: alert});
    };

    forgotPasswordValidate(token, alert) {
        let url = PREFIX_URL + "validate-token?token=" + token;
        return http.get(url, {alert: alert});
    };

    resetPass(email, alert) {
        let url = PREFIX_URL + "reset-password";
        return http.post(url, {email: email}, {alert: alert});
    };
}

export default new AuthService();
