
import { getBankInfo, } from "../../../system/api/api";
export default (to, from, next) => {
    if (localStorage.getItem("boostToken") != null && localStorage.getItem("boostToken").length > 0) {
        var result = getBankInfo();
        result.then(function (value) {
            console.log(value.data)
            if (value.data.data != null) {
                next();
            } else {
                next("/web/withdraw/setBank");
            }
        }).catch(function (e) {
            console.log(e);

        });
    } else {
        localStorage.removeItem("boostToken");
        next("/web/sessions/signIn");
    }
};
