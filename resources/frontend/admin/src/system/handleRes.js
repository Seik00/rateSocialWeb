export function checkRes(data) {
    if (data.code > 0) {
        console.error(data.message);
        return false;
    } else {
        console.log(data);
        return true;

    }

}

export function handleError(error) {
    console.log(error)
    if (error.response.status == 500) {
        return 'internalError';

    } else if (error.response.status == 401) {
        localStorage.removeItem("userToken");
        setTimeout(() => {
            var current = location.origin+'/';
            window.location.href = current+"manage/sessions/signIn";

        }, 2000);
        return 'unauthorized';

    }else{
        return 'internalError';

    }

}