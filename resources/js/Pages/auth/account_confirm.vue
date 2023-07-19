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
                        <div class="container-form my-5 mx-auto">
                            <div class="w-100 text-center">
                                <div>
                                    <v-img src="https://cdn-icons-png.flaticon.com/128/9840/9840836.png" alt="email" class="align-center" style="object-fit: contain;align-content: center; width: 40%;"></v-img>
                                    <h1>تحقق من عنوان بريدك الإلكتروني</h1>
                                    <br>
                                    <p>تم إرسال رسالة تحقق الى عنوان بريدك الإلكتروني الذي قمت بالتسجيل به، يرجى تأكيد حسابك.!</p>
                                </div>
                            </div>
                        </div>
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
