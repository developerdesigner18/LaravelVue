<template>
    <div
        class="fixed z-50 inset-0 overflow-y-auto flex items-center justify-center bg-gray-500 bg-opacity-75"
    >
        <div
            class="bg-white rounded-lg overflow-hidden shadow-xl max-w-md w-full relative"
        >
            <button
                @click="closeStudentModal"
                class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700 focus:outline-none"
            >
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>
            </button>

            <div class="p-8">
                <h1 class="text-2xl font-bold text-center mb-6">Add Student</h1>
                <form class="space-y-4">
                    <div>
                        <input
                            type="text"
                            v-model="name"
                            placeholder="Enter your Name"
                            class="inputfield w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 focus:outline-none focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <input
                            type="email"
                            v-model="email"
                            placeholder="Enter your email"
                            class="inputfield w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 focus:outline-none focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <button
                            @click="addStudent"
                            type="button"
                            class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"
                        >
                            Add Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddUser",
    props: {
        user: Object,
        edit: Boolean,
    },
    data() {
        return {
            name: "",
            email: "",
        };
    },

    methods: {
        async addStudent() {
            const contactObj = {
                username: this.name,
                email: this.email,
            };
            try {
                await this.$store.dispatch("createNewData", contactObj);
                await this.$store.dispatch("fetchUserData");
                this.$toast.success("User added successfully", {
                    position: "top",
                });
                this.$emit("add-data");
            } catch (error) {
                this.$toast.error("Failed to add user", {
                    position: "top",
                });
            }
        },

        closeStudentModal() {
            this.$emit("close-student-modal");
        },
    },
};
</script>
