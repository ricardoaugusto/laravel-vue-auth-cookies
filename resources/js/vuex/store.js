import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import * as Cookies from "js-cookie";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null
    },
    mutations: {
        SESSION_SET(state, response) {
            console.info("SESSION_SET");
            state.user = response.data.user;
            Cookies.set("accessToken", response.data.accessToken, {
                expires: 7
            });
            axios.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${response.data.accessToken}`;
        },
        SESSION_CLEAR(state) {
            state.user = null;
            Cookies.remove("accessToken");
            axios.defaults.headers.common["Authorization"] = null;
            location.reload();
        }
    },
    actions: {
        register({ commit }, credentials) {
            return axios.post("auth/register", credentials).then(({ data }) => {
                commit("SESSION_SET", data);
            });
        },
        login({ commit }, credentials) {
            return axios.post("auth/login", credentials).then(data => {
                commit("SESSION_SET", data);
            });
        },
        refresh({ commit }) {
            return axios
                .get("auth/refresh", {
                    headers: {
                        Authorization: `Bearer ${Cookies.get("accessToken")}`
                    }
                })
                .then(({ data }) => {
                    commit("SESSION_SET", data);
                });
        },
        logout({ commit }) {
            axios.get(process.env.APP_API + "auth/logout");
            commit("SESSION_CLEAR");
        }
    },
    getters: {
        loggedIn(state) {
            return !!state.user;
        }
    }
});
