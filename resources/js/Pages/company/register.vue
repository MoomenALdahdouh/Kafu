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
                                    Register your Company 🚀
                                </p>
                            </v-card-text>
                            <v-card-text>
                                <v-form @submit.prevent="submit">
                                    <v-text-field
                                        v-model="form.name"
                                        label="Company Name"
                                        prepend-inner-icon="mdi-home"
                                        :error-messages="form.errors.name"
                                        type="text"
                                        outlined
                                        dense
                                    />
                                    <v-text-field
                                        v-model="form.name_officer"
                                        prepend-inner-icon="mdi-account"
                                        label="Officer Name"
                                        :error-messages="form.errors.name_officer"
                                        type="text"
                                        outlined
                                        dense
                                    />
                                    <v-text-field
                                        v-model="form.email"
                                        prepend-inner-icon="mdi-email"
                                        label="Email"
                                        type="email"
                                        :error-messages="form.errors.email"
                                        outlined
                                        dense
                                    />
                                    <v-text-field
                                        v-model="form.mobile"
                                        prepend-inner-icon="mdi-phone"
                                        label="Mobile"
                                        type="tel"
                                        :error-messages="form.errors.mobile"
                                        outlined
                                        dense
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
                                    <input type="hidden" v-model="this.$page.props.incubator_key"/>
                                    <div class="d-flex"></div>
                                    <v-btn :disabled="form.processing" text color="error" @click="dialog = false">Cancel
                                    </v-btn>
                                    <v-spacer/>
                                    <v-btn :loading="form.processing" color="primary" type="submit"
                                    >Save
                                    </v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </guest-layout>
</template>

<script>
import ApplicationLogo from "../../components/ApplicationLogo.vue";
import GuestLayout from '../../layouts/GuestLayout.vue';

export default {
    props: ["incubator_key"],
    components: {
        ApplicationLogo,
        GuestLayout,
    },
    /*mounted() {
       //const urlParams = new URLSearchParams(window.location.search);
        this.incubatorKey = this.$page.props.incubator_key;
    },*/
    data() {
        return {
            showPassword: false,
            isLoading: false,
            form: this.$inertia.form({
                name: null,
                name_officer: null,
                email: null,
                mobile: null,
                password: null,
                password_confirmation: null,
                incubatorKey: null,
            }),
        };
    },
    methods: {
        submit() {
            if (this.isUpdate) {
                this.form.put(route("company.update", this.itemId), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.isUpdate = false;
                        this.itemId = null;
                        this.form.reset();
                    },
                });
            } else {
                this.form.post(route("company.register.store"), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        this.dialog = false;
                        this.form.reset();
                    },
                });
            }
        },
    },
};
</script>
