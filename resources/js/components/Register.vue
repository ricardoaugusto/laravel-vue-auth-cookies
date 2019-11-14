<template>
    <div>
        <div class="alert alert-success" v-if="success">
            <p>
                Registration completed. You can now
                <router-link :to="{ name: 'login' }">login.</router-link>
            </p>
        </div>
        <form
            autocomplete="off"
            @submit.prevent="register"
            v-if="!success"
            method="post"
        >
            <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="name"
                    required
                />
                <span class="help-block" v-if="errors.name">{{
                    errors.name[0]
                }}</span>
            </div>
            <div
                class="form-group"
                v-bind:class="{ 'has-error': errors.email }"
            >
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="user@example.com"
                    v-model="email"
                    required
                />
                <span class="help-block" v-if="errors.email">{{
                    errors.email[0]
                }}</span>
            </div>
            <div
                class="form-group"
                v-bind:class="{ 'has-error': errors.password }"
            >
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    class="form-control"
                    v-model="password"
                    required
                />
                <span class="help-block" v-if="errors.password">{{
                    errors.password[0]
                }}</span>
            </div>
            <button type="submit" class="btn btn-default">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            success: false,
            errors: {}
        };
    },
    methods: {
        register() {
            let credentials = {
                name: this.name,
                email: this.email,
                password: this.password
            };

            this.$store
                .dispatch("register", credentials)
                .then(() => {
                    this.$router.push({ name: "dashboard" });
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                });
        }
    }
};
</script>
