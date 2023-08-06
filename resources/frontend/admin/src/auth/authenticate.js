export default (to, from, next) => {
  if (
    localStorage.getItem("userToken") != null &&
    localStorage.getItem("userToken").length > 0
  ) {
    next();
  } else {
    localStorage.removeItem("userToken");
    next("/manage/sessions/signIn");
  }
};
