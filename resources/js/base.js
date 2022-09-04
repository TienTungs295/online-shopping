const base = {}
base.object2Param = function (str, obj) {
    var str = str || "";
    for (var key in obj) {
        let value = obj[key];
        if (value == "" || value == undefined) continue;
        if (str.indexOf("?") != -1) str += "&";
        else str += "?";
        str += key + "=" + value;
    }
    return str;
}
export default base;
