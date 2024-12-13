import "./bootstrap";
import "../css/app.css";

import { Link, createInertiaApp, router } from "@inertiajs/vue3";
import { createApp, h } from "vue";

import MainLayout from "./Layouts/MainLayout.vue";
import { ZiggyVue } from "ziggy-js";

function getOrCreateGuestToken() {
    let token = localStorage.getItem("guest_token");
    if (!token) {
        token = "guest_" + crypto.randomUUID();
        localStorage.setItem("guest_token", token);
    }
    return token;
}

window.guestToken = getOrCreateGuestToken();
window.router = router;

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .component("MainLayout", MainLayout)
            .mount(el);
    },
});
