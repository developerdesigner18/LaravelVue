import { createWebHistory, createRouter } from "vue-router";

import UserInfo from "../components/UserInfo.vue";
import LoginPage from "../Pages/LoginPage.vue";

const routes = [
    {
        name: "UserInfo",
        path: "/",
        component: UserInfo,
    },

    {
        name: "LoginPage",
        path: "/login",
        component: LoginPage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
