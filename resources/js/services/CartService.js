import http from "../http-common";

const PREFIX_URL = "/rest/cart/"

class CartService {
    findAll(code = null, alert) {
        let url = PREFIX_URL + "find-all";
        return http.get(url, {alert: alert});
    };

    add(object, alert) {
        let url = PREFIX_URL + "add";
        return http.post(url, object, {alert: alert});
    };

    update(object, alert) {
        let url = PREFIX_URL + "update";
        return http.post(url, object, {alert: alert});
    };

    applyCoupon(object, alert) {
        let url = PREFIX_URL + "apply-coupon";
        return http.post(url, object, {alert: alert});
    };

    removeCoupon(alert) {
        let url = PREFIX_URL + "remove-coupon";
        return http.post(url, {}, {alert: alert});
    };

    remove(object, alert) {
        let url = PREFIX_URL + "remove";
        return http.post(url, object, {alert: alert});
    }
}

export default new CartService();
