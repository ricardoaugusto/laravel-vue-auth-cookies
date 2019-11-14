import Vue from "vue";
import * as Cookies from "js-cookie";
import router from "../router/router";

const RedirectIfNotAuthenticated = {};

RedirectIfNotAuthenticated.install = function(Vue, options) {
    Vue.redirectIfNotAuthenticated = function() {
        const requiresAuth = router.currentRoute.meta.requiresAuth;
        const accessToken = Cookies.get("access_token");

        if (requiresAuth && !accessToken) {
            router.push({ name: "home" });
        }
    };
};
Vue.use(RedirectIfNotAuthenticated);

export default RedirectIfNotAuthenticated;
