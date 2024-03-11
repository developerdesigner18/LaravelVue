<template>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="w-[95%] max-w-md bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                Login
            </h2>
            <form class="flex flex-col" @submit.prevent="handleLogin">
                <input
                    type="email"
                    v-model="email"
                    class="bg-gray-100 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                    placeholder="Email address"
                />
                <div class="relative mb-4">
                    <input
                        type="text"
                        v-if="showPassword"
                        v-model="password"
                        class="bg-gray-100 w-full text-gray-900 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                        placeholder="Password"
                    />
                    <input
                        type="password"
                        v-else
                        v-model="password"
                        class="bg-gray-100 w-full text-gray-900 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                        placeholder="Password"
                    />
                    <img
                        class="absolute top-1/2 -translate-y-1/2 right-2 w-4 h-4 cursor-pointer"
                        src="../assets//hideeye.svg"
                        alt=""
                        @click="togglePasswordVisibility"
                        v-if="showPassword"
                    />

                    <img
                        class="absolute top-1/2 -translate-y-1/2 right-2 w-4 h-4 cursor-pointer"
                        src="../assets//eye.svg"
                        alt=""
                        @click="togglePasswordVisibility"
                        v-else
                    />
                </div>

                <button
                    type="submit"
                    :disabled="email === '' || password === '' || loader"
                    class="loginBtn bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoginPage",
    data() {
        return {
            email: "",
            password: "",
            showPassword: false,
            loader: false,
        };
    },

    created() {
        const loginStatus = localStorage.getItem("token");
        if (loginStatus) {
            this.$router.push({ name: "UserInfo" });
        }
    },
    methods: {
        handleLogin() {
            if (this.email === "" || this.password === "") {
                alert("Please fill all the fields");
            } else {
                const userInfo = {
                    email: this.email,
                    password: this.password,
                };
                this.loader = true;
                this.$store
                    .dispatch("handleLogin", userInfo)
                    .then(() => {
                        this.loader = false;
                        this.$toast.success("User successfully logged in", {
                            position: "top",
                        });
                        this.$router.push({ name: "UserInfo" });
                    })
                    .catch((error) => {
                        this.loader = false;
                        this.$toast.error("Something went wrong", {
                            position: "top",
                        });
                    });
            }
        },

        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
    },
};
</script>

<style scoped>
.loginBtn:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}
</style>
