import http from "../http-common";

const PREFIX_URL = "/rest/review/"

class ReviewService {
    save(object) {
        let url = PREFIX_URL + "save";
        return http.post(url, object, {alert401: true});
    };

    delete(object) {
        let url = PREFIX_URL + "delete";
        return http.post(url, object, {alert401: true});
    };

    findByProduct(product_id, last_id) {
        let url = PREFIX_URL + "find-by-product?product_id=" + product_id;
        if (last_id != null) url += "&last_id=" + last_id
        return http.get(url, {alert: alert});
    };
}

export default new ReviewService();
