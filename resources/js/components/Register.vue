<template>
    <div class="container">
        <form
            autocomplete="off"
            @submit.prevent="register"
            v-if="!success"
            method="post"
            class="row"
        >
            <div class="col-md-4 offset-md-4">
                <h1>Register</h1>
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
                        />
                        <span class="text-danger">{{ errors[0] }}</span>
                    </div>
                </ValidationProvider>
                <div class="alert alert-danger" v-if="errorMessage">
                    {{ errorMessage }}
                    <ul>
                        <li v-for="error in this.errors">
                            {{ error[0] }}
                        </li>
                    </ul>
                </div>
                <p class="text-center">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </p>
                <p class="text-center">
                    Already have an account?
                    <router-link :to="{ name: 'login' }">Login</router-link>
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
            success: false,
            errorMessage: "",
            errors: {},
            fields: [
                {
                    id: "name",
                    type: "name",
                    name: "name",
                    label: "Name",
                    rules: "required",
                    value: ""
                },
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
        register() {
            let credentials = {
                name: this.fields[0].value,
                email: this.fields[1].value,
                password: this.fields[2].value,
                remember: false
            };

            this.$store
                .dispatch("register", credentials)
                .then(() => {
                    this.$router.push({ name: "dashboard" });
                })
                .catch(err => {
                    this.errorMessage = err.response.data.message;
                    this.errors = err.response.data.errors;
                });
        }
    }
};
</script>
