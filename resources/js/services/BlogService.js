import http from "../http-common";

const PREFIX_URL = "/rest/blog/"

class ProductService {
    findAll(collection_id, alert) {
        let url = PREFIX_URL + "find-all";
        return http.get(url, {alert: alert});
    }
}

export default new ProductService();
