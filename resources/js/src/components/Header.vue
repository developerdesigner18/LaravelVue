<template>
    <nav class="bg-blue-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-1">
            <div class="flex justify-between h-12">
                <div class="flex"></div>
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <button
                        type="button"
                        @click="logout"
                        class="inline-flex items-center px-5 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-black bg-white hover:text-black hover:bg-white focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-500 transition duration-150 ease-in-out"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Header",
    methods: {
        logout() {
            this.$store
                .dispatch("logout")
                .then(() => {
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.error("Logout failed:", error);
                });
        },
    },
};
</script>
