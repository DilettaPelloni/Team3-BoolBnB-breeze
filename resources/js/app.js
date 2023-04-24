import "./bootstrap";
import "../css/app.css";
import "~resources/scss/app.scss";

import.meta.glob(["../img/**"]);

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faCircleUser,
    faBars,
    faLocationDot,
    faMaximize,
} from "@fortawesome/free-solid-svg-icons";
import { faFacebookF } from "@fortawesome/free-brands-svg-icons";
import { faInstagram } from "@fortawesome/free-brands-svg-icons";

library.add(
    faCircleUser,
    faBars,
    faLocationDot,
    faMaximize,
    faTrashCan,
    faPenToSquare,
    faEnvelope,
    faMessage,
    faFacebookF,
    faInstagram
);

import {
    faCopyright,
    faTrashCan,
    faPenToSquare,
    faEnvelope,
    faMessage,
} from "@fortawesome/free-regular-svg-icons";
library.add(
    faCircleUser,
    faBars,
    faCopyright,
    faLocationDot,
    faMaximize,
    faTrashCan,
    faPenToSquare,
    faEnvelope,
    faMessage
);

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "BoolBnB";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("font-awesome-icon", FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
