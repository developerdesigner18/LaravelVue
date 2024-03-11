import { createApp } from "vue";
import App from "./App.vue";
import store from "./Store/store";
import router from "./router";
import "./index.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

createApp(App).use(router).use(store).use(VueToast).mount("#app");
