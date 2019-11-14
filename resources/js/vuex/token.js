import Vue from "vue";
import axios from "axios";
import * as Cookies from "js-cookie";
// import VueCookies from "vue-cookies";

// Vue.use(VueCookies);
// VueCookies.config("7d");

const AxiosToken = {
    install(Vue, options) {
        Vue.mixin({
            mounted() {
                axios.interceptors.request.use(
                    config => {
                        // const token = $cookies.get("access_token");
                        const token = Cookies.get("access_token");

                        if (token) {
                            config.headers["Authorization"] = `Bearer ${token}`;
                            console.info("Authorization headers set");
                        }
                        return config;
                    },
                    error => {
                        return Promise.reject(error);
                    }
                );
            }
        });
    }
};
export default AxiosToken;
