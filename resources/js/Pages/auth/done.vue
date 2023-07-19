<template>
    <guest-layout>
        <v-app-bar color="primary" :clipped-left="false" fixed dark app>
            <v-toolbar-title v-text="appName" />
            <v-spacer />
            <Link v-if="$page.props.auth.user" :href="route('home')">
                <v-btn text>Dashboard</v-btn>
            </Link>
            <div v-else>
                <Link :href="route('login')">
                    <v-btn text>Login</v-btn>
                </Link>
                <Link :href="route('register')">
                    <v-btn text>Register</v-btn>
                </Link>
            </div>
        </v-app-bar>
        <v-main>
            <v-container>
                <v-card>
                    <v-card-title>
                        <template>
                            <div class="container-form my-5 mx-auto">
                                <div class="w-100 text-center">
                                    <div class="">
                                        <v-img src="https://cdn-icons-png.flaticon.com/128/6204/6204070.png" alt="email" contain class="my-4"></v-img>
                                        <h1>تم التحقق من الحساب بنجاح</h1>
                                        <br>
                                        <v-btn @click="goToPage('login')" class="active btn btn-white login-text mx-3">تسجيل الدخول</v-btn>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </v-card-title>
                </v-card>
            </v-container>
        </v-main>
    </guest-layout>
</template>

<script>
import ApplicationLogo from '../../components/ApplicationLogo.vue'
import GuestLayout from '../../layouts/GuestLayout.vue'
export default {
    components: { ApplicationLogo, GuestLayout },
    computed: {
        appName() {
            return this.$page.props.appName
        },
    },
    methods: {
        goToPage(page) {
            this.$inertia.visit(this.route(page));
        },
    },
}
</script>
