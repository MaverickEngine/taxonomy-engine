const state = {
    loading_state: "loading",
}
const getters = {
}
const actions = {
    async init({ commit, dispatch, state }) {
        commit("SET_LOADING_STATE", "loaded")
    },
}
const mutations = {
    SET_KEYVAL (state, keyval) {
        state[keyval.key] = keyval.value
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