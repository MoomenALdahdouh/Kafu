<template>
    <guest-layout>
        <v-main>
            <v-container fluid>
                <v-row align="center" justify="center" style="height: 100vh">
                    <v-col cols="12" sm="12" md="10" lg="4">
                        <v-card>
                            <v-card-title class="d-flex align-center justify-center">
                                <Link :href="route('/')">
                                    <application-logo style="height: 75px"/>
                                </Link>
                            </v-card-title>
                            <v-card-text>
                                <p class="text-2xl font-weight-semibold text--primary mb-2">
                                    Register your Incubators 🚀
                                </p>
                            </v-card-text>
                            <v-card-text>
                                <v-form @submit.prevent="register">
                                    <v-text-field
                                        v-model="form.name"
                                        prepend-inner-icon="mdi-home"
                                        label="Name"
                                        outlined
                                        dense
                                        type="text"
                                        :error-messages="form.errors.name"
                                    />
                                    <v-text-field
                                        v-model="form.in_name"
                                        prepend-inner-icon="mdi-account"
                                        label="Incubator Name"
                                        outlined
                                        dense
                                        type="text"
                                        :error-messages="form.errors.in_name"
                                    />
                                    <v-text-field
                                        v-model="form.projects"
                                        prepend-inner-icon="mdi-gavel"
                                        label="Projects"
                                        type="number"
                                        outlined
                                        dense
                                        :error-messages="form.errors.projects"
                                    />
                                    <v-text-field
                                        v-model="form.email"
                                        prepend-inner-icon="mdi-email"
                                        label="Email"
                                        type="email"
                                        outlined
                                        dense
                                        :error-messages="form.errors.email"
                                    />
                                    <v-text-field
                                        v-model="form.mobile"
                                        prepend-inner-icon="mdi-phone"
                                        label="Mobile"
                                        type="tel"
                                        outlined
                                        dense
                                        :error-messages="form.errors.mobile"
                                    />
                                    <v-textarea
                                        v-model="form.message"
                                        prepend-inner-icon="mdi-message"
                                        label="Message"
                                        outlined
                                        dense
                                        :error-messages="form.errors.message"
                                        rows="4"
                                    />
                                    <v-text-field
                                        v-model="form.password"
                                        prepend-inner-icon="mdi-lock"
                                        label="Password"
                                        outlined
                                        dense
                                        :error-messages="form.errors.password"
                                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="showPassword ? 'text' : 'password'"
                                        @click:append="showPassword = !showPassword"
                                    />
                                    <v-text-field
                                        v-model="form.password_confirmation"
                                        prepend-inner-icon="mdi-lock"
                                        label="Password Confirmation"
                                        :error-messages="form.errors.password_confirmation"
                                        outlined
                                        dense
                                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="showPassword ? 'text' : 'password'"
                                        @click:append="showPassword = !showPassword"
                                    />
                                    <v-btn :loading="form.processing" type="submit" block color="primary" class="mt-3"
                                    >Register
                                    </v-btn
                                    >
                                </v-form>
                            </v-card-text>
                            <v-card-text
                                class="d-flex align-center justify-center flex-wrap mt-2"
                            >
                                <span class="me-2"> Already have an account? </span>
                                <Link :href="route('login')"> Sign in instead</Link>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </guest-layout>
</template>

<script>
import GuestLayout from '../../layouts/GuestLayout.vue';
import ApplicationLogo from "../../components/ApplicationLogo";

export default {
    components: {
        ApplicationLogo,
        GuestLayout,
    },
    data() {
        return {
            showPassword: false,
            isLoading: false,
            form: this.$inertia.form({
                name: null,
                email: null,
                in_name: null,
                projects: null,
                mobile: null,
                message: null,
                password: null,
                password_confirmation: null,
            }),
        };
    },
    methods: {
        register() {
            this.form.post("/register");
        },
    },
};
</script>
