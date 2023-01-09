import "./bootstrap";

import "../sass/app.scss";

import { createApp } from "vue/dist/vue.esm-bundler.js";

import AppComponent from "@/App.vue";
import router from "@/router";

const app = createApp({
    components: {
        AppComponent,
    },
});

app.use(router);
app.mount("#app");
