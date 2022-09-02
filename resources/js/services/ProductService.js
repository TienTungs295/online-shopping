import http from "../http-common";

const PREFIX_URL = "/rest/product/"

class ProductService {
    findByCollection(collection_id, alert) {
        let url = PREFIX_URL + "find-by-collection";
        if (collection_id != null && collection_id != undefined) url = url += "?collection_id=" + collection_id;
        return http.get(url, {alert: alert});
    }

    findTrending(alert) {
        let url = PREFIX_URL + "find-by-collection";
        return http.get(url, {alert: alert});
    }

    findFeatured(alert) {
        let url = PREFIX_URL + "find-featured";
        return http.get(url, {alert: alert});
    }

    detail(id, alert) {
        let url = PREFIX_URL + "detail?id=" + id;
        return http.get(url, {alert: alert});
    }
}

export default new ProductService();
