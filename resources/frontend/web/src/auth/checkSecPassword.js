
import { getMemberInfo,getDownloadLink} from "../system/api/api";
import { handleError } from "../system/handleRes";

export default (to, from, next) => {
    if (
        localStorage.getItem("boostToken") != null &&
        localStorage.getItem("boostToken").length > 0
    ) {
        var result = getDownloadLink();

        result
            .then(function (value) {
                var siteOn = value.data.data.system.SITE_ON;
                if (siteOn == 0) {
                    next("/web/sessions/signIn");
                } else {
                    var result = getMemberInfo();

                    result
                        .then(function (value) {
                            localStorage.setItem('info', JSON.stringify(value.data.data));
                            var secPassword = value.data.data.password2;
                            if (secPassword == null) {
                                next("/web/settings/set-sec-password");
                            } else {
                                next();
                            }


                        })
                        .catch(function (error) {
                            handleError(error)
                            
                        });
                }
            })
            .catch(function () {
              
            });
    } else {
        localStorage.removeItem("boostToken");
        next("/web/sessions/signIn");
    }
};
