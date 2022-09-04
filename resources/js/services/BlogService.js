import http from "../http-common";
import base from "../base";

const PREFIX_URL = "/rest/blog/"

class BlogService {
    findAll(param, alert) {
        let url = PREFIX_URL + "find-all";
        if (param != undefined) url = base.object2Param(url, param);
        return http.get(url, {alert: alert});
    };

    detail(id, alert) {
        let url = PREFIX_URL + "detail?id=" + id;
        return http.get(url, {alert: alert});
    };

    related(id, alert) {
        let url = PREFIX_URL + "related?id=" + id;
        return http.get(url, {alert: alert});
    }

    recent(id, alert) {
        let url = PREFIX_URL + "recent";
        if (id != undefined) url += "?id=" + id;
        return http.get(url, {alert: alert});
    }
}

export default new BlogService();
