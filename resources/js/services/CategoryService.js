import http from "../http-common";

const PREFIX_URL = "/rest/category/"

class CategoryService {
    findAll(alert) {
        return http.get(PREFIX_URL + "find-all", {alert: alert});
    }

    findAllWithoutChild(alert) {
        return http.get(PREFIX_URL + "find-all-without-child", {alert: alert});
    }

    findTop(alert) {
        return http.get(PREFIX_URL + "find-top", {alert: alert});
    }
}

export default new CategoryService();
