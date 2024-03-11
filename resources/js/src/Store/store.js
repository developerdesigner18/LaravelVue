import { createStore } from "vuex";
import axios from "axios";

const store = createStore({
    state: {
        students: [],
        isLoggedIn: false,
        deleteId: null,
    },
    mutations: {
        addedContact(state, contact) {
            state.students.push(contact);
        },

        setLoggedIn(state) {
            state.isLoggedIn = true;
        },

        setUserData(state, userData) {
            state.students = userData.data;
        },

        deleteContact(state, id) {
            const index = state.students.findIndex(
                (contact) => contact.id === id
            );
            if (index !== -1) {
                state.students.splice(index, 1);
            }
        },
        setId(state, id) {
            state.deleteId = id;
        },
    },
    actions: {
        handleLogin({ commit }, payload) {
            return axios
                .post("http://127.0.0.1:8000/api/login", payload)
                .then((response) => {
                    localStorage.setItem("token", response.data.data.token);

                    commit("setLoggedIn");
                    return response;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    throw error;
                });
        },

        fetchUserData({ commit }) {
            return axios
                .get("http://127.0.0.1:8000/api/students", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((response) => {
                    commit("setUserData", response.data);
                    return response;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    throw error;
                });
        },

        createNewData({ commit, dispatch }, newData) {
            return axios
                .post("http://127.0.0.1:8000/api/add-student", newData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((response) => {
                    dispatch("fetchUserData");
                    return response;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    throw error;
                });
        },

        deletedContact({ commit }, id) {
            return axios
                .delete(`http://127.0.0.1:8000/api/students/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((response) => {
                    commit("deleteContact", id);
                    return response;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    throw error;
                });
        },

        logout({ commit }) {
            return new Promise((resolve, reject) => {
                axios
                    .get("http://127.0.0.1:8000/api/logout", {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            commit("DELETE_TOKEN");

                            localStorage.removeItem("token");
                            resolve();
                        } else {
                            console.error(
                                "Logout failed with status:",
                                response.status
                            );
                            reject("Logout failed");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        reject(error);
                    });
            });
        },
    },
});

export default store;
