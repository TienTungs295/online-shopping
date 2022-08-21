import http from "../http-common";

const PREFIX_URL = "/rest/product/"

class ProductService {
    findByCollection($collection_id, alert) {
        let url = PREFIX_URL + "find-by-collection";
        if ($collection_id != null) url = url += "?collection_id=" + $collection_id;
        return http.get(url, {alert: alert});
    }
}

export default new ProductService();
