<template>
    <div class="container">
        <form
            autocomplete="off"
            @submit.prevent="login"
            method="post"
            class="row"
        >
            <div class="col-md-4 offset-md-4">
                <h1>Login</h1>
                <ValidationProvider
                    v-for="field in fields"
                    :key="field.id"
                    :name="field.name"
                    :rules="field.rules"
                    v-slot="{ errors }"
                    persist
                >
                    <div class="form-group">
                        <label :for="field.id">{{ field.label }}</label>
                        <input
                            v-model.lazy="field.value"
                            :id="field.id"
                            :name="field.name"
                            :type="field.type"
                            :placeholder="field.label"
                            class="form-control"
                            v-on:focusin="clearErrorMessage()"
                        />
                        <span class="text-danger">{{ errors[0] }}</span>
                    </div>
                </ValidationProvider>
                <p>
                    <label>
                        <input
                            type="checkbox"
                            name="remember"
                            v-model="remember"
                            value="1"
                        />
                        Remember me
                    </label>
                </p>
                <div class="alert alert-danger" v-if="errorMessage">
                    {{ errorMessage }}<br />
                    <a href="#">Did you forget your password?</a>
                </div>
                <p class="text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </p>
                <p class="text-center">
                    Don't have an account?
                    <router-link :to="{ name: 'register' }"
                        >Register</router-link
                    >
                </p>
            </div>
        </form>
    </div>
</template>
<script>
import { ValidationProvider } from "vee-validate";

export default {
    components: {
        ValidationProvider
    },
    data() {
        return {
            remember: false,
            errorMessage: "",
            errors: {},
            fields: [
                {
                    id: "email",
                    type: "email",
                    name: "email",
                    label: "E-mail",
                    rules: "required|email",
                    value: ""
                },
                {
                    id: "password",
                    type: "password",
                    name: "password",
                    label: "Password",
                    rules: "required",
                    value: ""
                }
            ]
        };
    },
    methods: {
        login() {
            let credentials = {
                email: this.fields[0].value,
                password: this.fields[1].value,
                remember: this.remember
            };

            this.$store
                .dispatch("login", credentials)
                .then(() => {
                    this.$router.push({ name: "dashboard" });
                })
                .catch(err => {
                    this.errorMessage = err.response.data.message;
                });
        },
        clearErrorMessage() {
            this.errorMessage = null;
        }
    }
};
</script>
