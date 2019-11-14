import Vue from "vue";
import Router from "vue-router";
import * as Cookies from "js-cookie";

import Home from "../components/Home.vue";
import Register from "../components/Register.vue";
import Login from "../components/Login.vue";
import Dashboard from "../components/Dashboard.vue";
import Users from "../components/Users.vue";

Vue.use(Router);

const isLoggedIn = (to, from, next) => {
    let accessToken =
        typeof Cookies.get("accessToken") != "undefined"
            ? Cookies.get("accessToken")
            : false;

    if (!accessToken) {
        next({ name: "home" });
    } else {
        next();
    }
};

const options = {
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/register",
            name: "register",
            component: Register
        },
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/users",
            name: "users",
            component: Users,
            meta: {
                requiresAuth: true
            },
            beforeEnter: isLoggedIn
        }
    ]
};
// options.beforeEach((to, from, next) => {
//     let accessTokenCookie = true; //Cookies.get("accessToken");
//     let noAccessTokenCookie = typeof accessTokenCookie == "undefined";
//
//     if (requiresAuth && noAccessTokenCookie) {
//         next({ name: "login" });
//     } else {
//         next();
//     }
// });

const router = new Router(options);
export default router;

// router.beforeEach((to, from, next) => {
//     let loggedIn = store.getters.loggedIn;
//     if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
//         next({ name: "login" });
//     } else {
//         next();
//     }
// });
