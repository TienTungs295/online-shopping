import http from "../http-common";

const PREFIX_URL = "/rest/collection/"

class CollectionService {
    findAll(alert) {
        return http.get(PREFIX_URL + "find-all", {alert: alert});
    }
}

export default new CollectionService();
