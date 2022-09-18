import http from "../http-common";
import base from "../base";

const PREFIX_URL = "/rest/order/"

class OrderService {
    checkOut(object, alert) {
        let url = PREFIX_URL + "check-out";
        return http.post(url, object, {alert: alert});
    };
}

export default new OrderService();
