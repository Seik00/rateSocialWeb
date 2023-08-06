export default (to, from, next) => {
  if (
    localStorage.getItem("boostToken") != null &&
    localStorage.getItem("boostToken").length > 0
  ) {
    next();
  } else {
    localStorage.removeItem("boostToken");
    next("/web/sessions/signIn");
  }
};
