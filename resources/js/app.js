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
    faShirt,
    faWifi,
    faSoap,
    faUtensils,
    faKitchenSet,
    faFan,
    faTv,
    faPersonSwimming,
    faParking,
    faSmoking,
    faSquareParking,
    faWind,
    faSnowflake,
    faCarBattery,
    faMugHot,
    faBath,
    faVault,
    faBicycle,
    faDog,
    faMountain,
    faTemperatureQuarter,
    faPersonHiking,
    faBed,
    faTableTennisPaddleBall,
    faUmbrellaBeach,
    faKey,
    faEye,
    faHouseChimney,
    faStopwatch,
} from "@fortawesome/free-solid-svg-icons";

import {
    faCopyright,
    faTrashCan,
    faPenToSquare,
    faEnvelope,
    faMessage,
} from "@fortawesome/free-regular-svg-icons";

import { faFacebookF, faInstagram } from "@fortawesome/free-brands-svg-icons";
library.add(
    faCircleUser,
    faBars,
    faCopyright,
    faLocationDot,
    faMaximize,
    faTrashCan,
    faPenToSquare,
    faEnvelope,
    faMessage,
    faFacebookF,
    faInstagram,
    faShirt,
    faWifi,
    faSoap,
    faUtensils,
    faKitchenSet,
    faFan,
    faTv,
    faPersonSwimming,
    faParking,
    faSmoking,
    faSquareParking,
    faWind,
    faSnowflake,
    faCarBattery,
    faMugHot,
    faBath,
    faVault,
    faBicycle,
    faDog,
    faMountain,
    faTemperatureQuarter,
    faPersonHiking,
    faBed,
    faTableTennisPaddleBall,
    faUmbrellaBeach,
    faKey,
    faEye,
    faHouseChimney,
    faStopwatch,
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
