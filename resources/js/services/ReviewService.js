import http from "../http-common";

const PREFIX_URL = "/rest/review/"

class ReviewService {
    save(object, alert) {
        let url = PREFIX_URL + "save";
        return http.post(url, object, {alert: alert});
    };

    update(object, alert) {
        let url = PREFIX_URL + "update";
        return http.post(url, object, {alert: alert});
    };

    delete(object, alert) {
        let url = PREFIX_URL + "delete";
        return http.post(url, object, {alert: alert});
    };

    findByProduct(product_id, page_size = 1) {
        let url = PREFIX_URL + "find-by-product?product_id=" + product_id + "&page_size=" + page_size;
        return http.get(url, {alert: alert});
    };

    countByProduct(product_id) {
        let url = PREFIX_URL + "count-by-product?product_id=" + product_id;
        return http.get(url, {alert: alert});
    };
}

export default new ReviewService();
