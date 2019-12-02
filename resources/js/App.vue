<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <router-link :class="`navbar-brand`" :to="{ name: 'home' }"
                    >Auth</router-link
                >
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li v-if="loggedIn" class="nav-item">
                            <router-link
                                :class="`nav-link`"
                                :to="{ name: 'dashboard' }"
                            >
                                Dashboard
                            </router-link>
                        </li>
                        <li v-if="loggedIn" class="nav-item">
                            <router-link
                                :class="`nav-link`"
                                :to="{ name: 'users' }"
                                >Users</router-link
                            >
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="pull-right nav-item" v-if="!loggedIn">
                            <router-link
                                :class="`nav-link`"
                                :to="{ name: 'login' }"
                                >Login</router-link
                            >
                        </li>
                        <li class="nav-item" v-else>
                            <button class="btn btn-default" @click="logout">
                                Logout
                            </button>
                        </li>
                        <li class="nav-item float-md-right" v-if="!loggedIn">
                            <router-link
                                :class="`nav-link`"
                                :to="{ name: 'register' }"
                                >Register</router-link
                            >
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="panel-body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { authComputed } from "./vuex/helpers";

export default {
    computed: {
        ...authComputed
    },
    methods: {
        logout() {
            this.$store.dispatch("logout");
        }
    }
};
</script>
