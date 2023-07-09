<template>
    <v-app style="background-color: #f5f5f5">
        <v-navigation-drawer
            :mini-variant.sync="miniVariant"
            clipped
            v-model="drawer"
            fixed
            app
        >
            <v-list nav>
                <v-list-item-group :value="indexMenu">
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        @click="goToPage(item.to)"
                        v-if="hasPermission(item.permission)">
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.title"/>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="logout">
                        <v-list-item-action>
                            <v-icon>mdi-exit-to-app</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar color="primary" clipped-left fixed dark app>
            <v-app-bar-nav-icon
                v-if="$vuetify.breakpoint.smAndDown"
                @click.stop="drawer = !drawer"
            />
            <v-app-bar-nav-icon v-else @click.stop="miniVariant = !miniVariant"/>
            <v-toolbar-title v-text="appName"/>
            <v-spacer/>
            <div class="d-flex align-center">
                <v-icon dark>mdi-account</v-icon>
                <div class="pl-3">
                    <span class="body-1 font-weight-medium">{{ user.name }}</span>
                    <strong class="body-1 font-weight-medium success" v-if="hasPermission('company')">Wallet {{ wallet }} $</strong>
                </div>
            </div>
        </v-app-bar>
        <v-main>
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
//import ApplicationLogo from "../components/ApplicationLogo.vue";


export default {
    // components: {ApplicationLogo},
    data() {
        return {
            drawer: !this.$vuetify.breakpoint.smAndDown,
            items: [
                {icon: "mdi-apps", title: "Home", permission: "dashboard", to: "home"},
                {icon: "mdi-apps", title: "Companies", permission: "companies", to: "company.index"},
                {icon: "mdi-apps", title: "Jobs", permission: "jobs", to: "job.index"},
                {icon: "mdi-apps", title: "Incubators", permission: "incubators", to: "incubator.index"},
                {icon: "mdi-apps", title: "Plans", permission: "plans", to: "plan.index"},
            ],
            miniVariant: false,
        };
    },
    computed: {
        appName() {
            return /*this.$page.props.appName*/ "Dashboard";
        },
        user() {
            return this.$page.props.auth.user;
        },
        wallet() {
            return this.$page.props.wallet;
        },
        indexMenu() {
            const inertiaUrl = this.$inertia.page.url.split("?")[0];
            const index = this.items.findIndex((item) => {
                const windowUrl = this.route(item.to);
                return windowUrl.includes(inertiaUrl);
            });
            return index;
        },
    },
    /*watch: {
        $page: {
            handler() {
                const message = this.$page.props.flash.message;
                if (message != null) {
                    switch (message.type) {
                        case "success":
                            this.$toast.success(message.text);
                            break;
                        case "error":
                            this.$toast.error(message.text);
                            break;
                    }
                }
            },
        },
    },*/
    methods: {
        logout() {
            this.$inertia.post("/logout");
        },
        hasPermission(permission) {
            // Check if the user has the specified permission
            return (
                Array.isArray(this.$page.props.permissions) &&
                this.$page.props.permissions.includes(permission)
            );
        },
        goToPage(page) {
            this.$inertia.visit(this.route(page));
        },
    },
};
</script>
