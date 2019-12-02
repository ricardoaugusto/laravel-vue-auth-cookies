<template>
    <div>
        <h1>Laravel 6 Passport Vue.js Auth</h1>
        <router-link
            :to="{ name: 'login' }"
            :class="`btn btn-primary btn-lg btn-block`"
            v-if="!loggedIn"
            >Login</router-link
        >
        <router-link
            :to="{ name: 'register' }"
            :class="`btn btn-primary btn-lg btn-block`"
            v-if="!loggedIn"
            >Register</router-link
        >
        <router-link
            :to="{ name: 'dashboard' }"
            :class="`btn btn-secondary btn-lg btn-block`"
            v-else
            >Dashboard</router-link
        >
    </div>
</template>
<script>
import { authComputed } from "../vuex/helpers";
export default {
    computed: {
        ...authComputed
    }
};
</script>
