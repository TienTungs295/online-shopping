import http from "../http-common";
import base from "../base";

const PREFIX_URL = "/rest/with-list/"

class WithListService {
    findAll(alert) {
        let url = PREFIX_URL + "find-all";
        return http.get(url, {alert: alert});
    };

    count(alert) {
        let url = PREFIX_URL + "count";
        return http.get(url, {alert: alert});
    };

    save(object, redirectIfUnAuthenticate, alert) {
        let url = PREFIX_URL + "save";
        return http.post(url, object, {alert: alert, redirectIfUnAuthenticate: redirectIfUnAuthenticate});
    };

    delete(object, alert) {
        let url = PREFIX_URL + "delete";
        return http.post(url, object, {alert: alert, redirectIfUnAuthenticate: redirectIfUnAuthenticate});
    }

}

export default new WithListService();
