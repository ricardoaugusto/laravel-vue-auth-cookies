import Vue from "vue";
import router from "./router/router";
import axios from "axios";
import * as Cookies from "js-cookie";

require("./bootstrap");
import store from "./vuex/store";
import App from "./App.vue";

axios.defaults.baseURL = process.env.APP_API;
axios.defaults.withCredentials = true;

new Vue({
    store,
    router,
    beforeCreate() {
        const accessToken = Cookies.get("accessToken");

        if (accessToken) {
            axios.defaults.headers.common.Authorization =
                "Bearer " + accessToken;
        }
    },
    created() {
        const accessToken = Cookies.get("accessToken");

        if (accessToken) {
            store.dispatch("refresh");
        }
    },
    render: h => h(App)
}).$mount("#app");
