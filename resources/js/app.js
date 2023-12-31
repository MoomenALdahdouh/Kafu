require("./bootstrap");
require("./plugins/vue-toastification");
import Vue from "vue";
import {
    App as InertiaApp,
    plugin as InertiaPlugin
} from "@inertiajs/inertia-vue";
import { Link } from "@inertiajs/inertia-vue";
import vuetify from "./plugins/vuetify";
import { InertiaProgress } from "@inertiajs/progress";
import MainLayout from "./layouts/MainLayout.vue";
import ApplicationLogo from "./components/ApplicationLogo.vue";

Vue.use(InertiaPlugin);
Vue.component("Link", Link);
Vue.component('main-layout', MainLayout);
Vue.mixin({ methods: { route: window.route } });
const app = document.getElementById("app");

new Vue({
    vuetify,
    components: {
        ApplicationLogo
    },
    render: h =>
        h(InertiaApp, {
            props: {
                title: title => `${title} - My App`,
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => require(`./Pages/${name}`).default
            }
        })
}).$mount(app);

InertiaProgress.init({ color: "#fff" });
