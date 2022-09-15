import http from "../http-common";
import base from "../base";

const PREFIX_URL = "/rest/cart/"

class CartService {
    findAll(alert) {
        let url = PREFIX_URL + "find-all";
        return http.get(url, {alert: alert});
    };

    count(alert) {
        let url = PREFIX_URL + "count";
        return http.get(url, {alert: alert});
    };

    add(object, alert) {
        let url = PREFIX_URL + "add" ;
        return http.post(url, object,{alert: alert});
    };

    update(object, alert) {
        let url = PREFIX_URL + "update";
        return http.post(url, object, {alert: alert});
    };

    remove(object, alert) {
        let url = PREFIX_URL + "remove";
        return http.post(url, object, {alert: alert});
    }
}

export default new CartService();
