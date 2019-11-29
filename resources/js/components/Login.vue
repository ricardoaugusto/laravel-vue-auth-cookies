<template>
    <div>
        <form autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="user@example.com"
                    v-model="email"
                    required
                />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    class="form-control"
                    v-model="password"
                    required
                />
            </div>
            <div class="alert alert-danger" v-if="errorMessage">
                {{ errorMessage }}
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            email: null,
            password: null,
            errorMessage: ""
        };
    },
    methods: {
        login() {
            let credentials = {
                email: this.email,
                password: this.password
            };

            this.$store
                .dispatch("login", credentials)
                .then(() => {
                    this.$router.push({ name: "dashboard" });
                })
                .catch(err => {
                    this.errorMessage = err.response.data.error.msg;
                });
        }
    }
};
</script>
