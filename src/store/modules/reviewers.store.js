import {axios} from "../../libs/wp_axios";

const state = {
    loading_state: "loading",
    users: [],
    user_search: "",
    error: false,
}

const getters = {
}

const _map_user = (user) => {
    user.is_reviewer = user.roles.includes(taxonomyengine_reviewer_role);
    return user;
}


const actions = {
    async init({ commit, dispatch, state }) {
        try {
            commit('SET_LOADING_STATE', 'loading');
            await dispatch('search_users');
            commit("SET_LOADING_STATE", "loaded")
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    },

    async search_users({ commit, dispatch, state }, search_term) {
        try {
            commit("SET_KEYVAL", { key: "user_search", value: search_term });
            commit("SET_LOADING_STATE", "loading");
            const query = {
                search: search_term
            }
            if (!search_term) {
                query.role = taxonomyengine_reviewer_role;
            }
            const response = (await axios.post(`/wp-json/taxonomyengine/v1/reviewers/users`, query));
            const users = response.data.data.map(_map_user);
            commit("SET_KEYVAL", { key: "users", value: users });
            commit("SET_LOADING_STATE", "loaded");
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    },

    async add_reviewer({ commit, dispatch, state }, user) {
        try {
            commit("SET_LOADING_STATE", "loading");
            const result = (await axios.get(`/wp-json/taxonomyengine/v1/reviewers/add_role/${user.id}`)).data.data.map(_map_user)[0];
            commit("UPDATE_USER", result);
            commit("SET_LOADING_STATE", "loaded");
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    },

    async remove_reviewer({ commit, dispatch, state }, user) {
        try {
            commit("SET_LOADING_STATE", "loading");
            const result = (await axios.get(`/wp-json/taxonomyengine/v1/reviewers/remove_role/${user.id}`)).data.data.map(_map_user)[0];
            commit("UPDATE_USER", result);
            commit("SET_LOADING_STATE", "loaded");
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    },

    async update_user_weight({ commit, dispatch, state }, user) {
        try {
            commit("SET_LOADING_STATE", "loading");
            (await axios.post(`/wp-json/taxonomyengine/v1/reviewers/update_user_weight/${user.id}`, { weight: user.taxonomyengine_reviewer_weight }));
            commit("SET_KEYVAL", { key: "users", value: state.users });
            commit("SET_LOADING_STATE", "loaded");
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    }
}

const mutations = {
    SET_KEYVAL (state, keyval) {
        state[keyval.key] = keyval.value
    },
    UPDATE_USER(state, user) {
        console.log(user);
        const index = state.users.findIndex(u => u.id === user.id);
        state.users.splice(index, 1, user);
    },
    SET_LOADING_STATE(state, loading_state) {
        state.loading_state = loading_state;
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}