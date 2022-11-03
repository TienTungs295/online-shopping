import http from "../http-common";

const PREFIX_URL = "/rest/with-list/"

class WithListService {
    findAll(alert) {
        let url = PREFIX_URL + "find-all";
        return http.get(url, {alert: alert});
    };

    save(object, alert) {
        let url = PREFIX_URL + "save";
        return http.post(url, object, {alert: alert, redirectToLoginIfUnAuthen: true});
    };

    delete(object, alert) {
        let url = PREFIX_URL + "delete";
        return http.post(url, object, {alert: alert, redirectToLoginIfUnAuthen: true});
    }
}

export default new WithListService();
