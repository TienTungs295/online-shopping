import http from "../http-common";
import base from "../base";

const PREFIX_URL = "/rest/product/"

class ProductService {

    findAll(param, page, alert) {
        let url = PREFIX_URL + "find-all";
        if (page != undefined) url += "?page=" + page
        return http.get(url, {
            params: {
                param: JSON.stringify(param)
            },
            alert: alert
        });
    }

    findByCollection(collection_id, alert) {
        let url = PREFIX_URL + "find-by-collection";
        if (collection_id != null && collection_id != undefined) url = url += "?collection_id=" + collection_id;
        return http.get(url, {alert: alert});
    }

    findTrending(alert) {
        let url = PREFIX_URL + "find-trending";
        return http.get(url, {alert: alert});
    }

    findFeatured(alert) {
        let url = PREFIX_URL + "find-featured";
        return http.get(url, {alert: alert});
    }

    findOnSale(alert) {
        let url = PREFIX_URL + "find-on-sale";
        return http.get(url, {alert: alert});
    }

    detail(id, alert) {
        let url = PREFIX_URL + "detail?id=" + id;
        return http.get(url, {alert: alert});
    }

    findTopRate(alert) {
        let url = PREFIX_URL + "find-top-rate";
        return http.get(url, {alert: alert});
    }

    findFlashSale(alert) {
        let url = PREFIX_URL + "find-flash-sale";
        return http.get(url, {alert: alert});
    }
}

export default new ProductService();
