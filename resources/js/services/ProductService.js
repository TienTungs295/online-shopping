import http from "../http-common";

const PREFIX_URL = "/rest/product/"

class ProductService {
    findByCollection($collection_id, alert) {
        return http.get(PREFIX_URL + "find-by-collection?collection_id=" + $collection_id, {alert: alert});
    }
}

export default new ProductService();
