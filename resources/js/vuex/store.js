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
            state.user = response.data.user;
            Cookies.set("accessToken", response.data.accessToken, {
                expires: response.data.user.expires_at
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
            return axios.post("auth/register", credentials).then(response => {
                commit("SESSION_SET", response.data);
            });
        },
        login({ commit }, credentials) {
            return axios.post("auth/login", credentials).then(response => {
                commit("SESSION_SET", response.data);
            });
        },
        refresh({ commit }) {
            return axios.get("auth/refresh").then(response => {
                commit("SESSION_SET", response.data);
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
