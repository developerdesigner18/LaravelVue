<template>
    <Header></Header>
    <AddUser
        v-if="addUser"
        @addData="close"
        @closeStudentModal="closeStudentModal"
    ></AddUser>

    <section class="py-1 bg-blueGray-50">
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded"
            >
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div
                            class="relative w-full px-4 max-w-full flex-grow flex-1"
                        >
                            <h3
                                class="font-bold tracking-normal text-2xl text-blueGray-700"
                            >
                                STUDENT LIST
                            </h3>
                        </div>
                        <div
                            class="relative w-full px-4 max-w-full flex-grow flex-1 text-right"
                        >
                            <button
                                class="border border-blue-500 text-blue-500 active:text-white active:bg-blue-600 hover:bg-blue-100 hover:text-blue text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button"
                                @click="addInfo"
                            >
                                Add Student
                            </button>
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-x-auto">
                    <table
                        class="items-center bg-transparent w-full border-collapse"
                    >
                        <thead>
                            <tr>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                >
                                    #
                                </th>
                                <th
                                    class="px-6 w-[35%] bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                >
                                    Email-ID
                                </th>
                                <th
                                    class="px-6 w-[15%] text-right bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="(contact, index) in students"
                                :key="contact.id"
                            >
                                <th
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700"
                                >
                                    {{ index + 1 }}
                                </th>
                                <td
                                    class="border-t-0 w-[35%] px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                >
                                    {{ contact.username }}
                                </td>
                                <td
                                    class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                >
                                    {{ contact.email }}
                                </td>
                                <td
                                    class="border-t-0 px-6 text-right align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                >
                                    <button
                                        @click="delUser(contact.id)"
                                        class="border border-red-500 text-red-500 hover:bg-red-100 hover:text-red-700 px-4 py-1 rounded-md shadow-md transition duration-300"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <DeleteModal
        v-if="deleteBox"
        @updateData="updateVal"
        @closeModal="closeDeleteMOdal"
    >
    </DeleteModal>
</template>

<script>
import AddUser from "./AddUser.vue";
import DeleteModal from "./DeleteModal.vue";

import Header from "./Header.vue";
export default {
    name: "UserInfo",
    components: {
        AddUser,
        DeleteModal,
        Header,
    },
    data() {
        return {
            addUser: false,
            students: null,
            edit: false,
            modifyUser: null,
            deleteBox: false,
            deleteUserId: null,
        };
    },
    created() {
        const token = localStorage.getItem("token");
        if (!token) {
            this.$router.push("/login");
        } else {
            this.$store
                .dispatch("fetchUserData")
                .then((res) => {
                    this.students = this.$store.state.students;
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }
    },

    methods: {
        addInfo() {
            this.addUser = true;
        },

        close() {
            const x = this.$store.state.students;
            this.students = x;
            this.addUser = false;
        },

        delUser(id) {
            this.deleteUserId = id;
            this.$store.commit("setId", id);
            this.deleteBox = true;
        },

        closeStudentModal() {
            this.addUser = false;
        },

        updateVal() {
            this.deleteBox = false;
            const deleteid = this.$store.state.deleteId;

            this.$store
                .dispatch("deletedContact", deleteid)
                .then(() => {
                    this.$toast.success("User deleted successfully", {
                        position: "top",
                    });
                })
                .catch((error) => {
                    console.error("Logout failed:", error);
                    this.$toast.error("Something went wrong", {
                        position: "top",
                    });
                });
        },

        closeDeleteMOdal() {
            this.deleteBox = false;
        },
    },
};
</script>
