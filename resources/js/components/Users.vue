<template>
    <div>
        <h1>Users</h1>
        <ul>
            <li v-for="(user, index) in users" :key="index">
                {{ user.name }}
                <a :href="`mailto:{{ user.email }}`">{{ user.email }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
// import Vue from "vue";
import axios from "axios";

export default {
    data() {
        return {
            users: Array
        };
    },
    computed: {},
    beforeCreate() {},
    created() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            axios
                .get(process.env.APP_API + "users")
                .then(returnedData => {
                    this.users = returnedData.data.users;
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
</script>
