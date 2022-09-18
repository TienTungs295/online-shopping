import axios from "axios";

const PREFIX_URL = "/data/"

class AddressService {
    findProvinces(alert) {
        let url = PREFIX_URL + "tinh_tp.json";
        return axios.get(url, {alert: alert});
    };

    findDistricts(parent_code, alert) {
        let url = PREFIX_URL + "quan-huyen/" + parent_code + ".json";
        return axios.get(url, {alert: alert});
    };

    findWards(parent_code, alert) {
        let url = PREFIX_URL + "xa-phuong/" + parent_code + ".json";
        return axios.get(url, {alert: alert});
    }
}

export default new AddressService();
