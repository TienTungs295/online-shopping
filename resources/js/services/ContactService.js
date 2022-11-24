import http from "../http-common";

const PREFIX_URL = "/rest/contact/"

class ContactService {
    save(object, alert) {
        let url = PREFIX_URL + "save";
        return http.post(url, object, {alert: alert});
    }
}

export default new ContactService();
