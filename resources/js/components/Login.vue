<template>
    <div>
        <form autocomplete="off" @submit.prevent="login" method="post">
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
                    <span>{{ errors[0] }}</span>
                </div>
            </ValidationProvider>
            <div class="alert alert-danger" v-if="errorMessage">
                {{ errorMessage }}
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
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
            errorMessage: "",
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
                password: this.fields[1].value
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
