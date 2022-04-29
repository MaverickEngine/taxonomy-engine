import {axios} from "../../libs/wp_axios";

const find_taxonomy_by_id = (taxonomies, id) => {
    const result = taxonomies.find(taxonomy => taxonomy.id === id);
    if (!result) {
        if (taxonomies.children) {
            return find_taxonomy_by_id(taxonomies.children, id);
        }
    }
    return null;
}

function check_selected(taxonomy) {
    if (taxonomy.selected) {
        return true;
    }
    if (taxonomy.children) {
        for (let child of taxonomy.children) {
            if (check_selected(child)) {
                return true;
            }
        }
    }
    return false;
}

const state = {
    loading_state: "loading",
    page_count: 0,
    current_page: 1,
    taxonomies: {},
    current_taxonomy: {},
    review: {},
    error: false,
    selected_taxonomies: [],
    instructions_visible: false,
}

const getters = {
}

const actions = {
    async init({ commit, dispatch, state }) {
        try {
            const review = (await axios.get(`/wp-json/taxonomyengine/v1/review/${taxonomyengine_post_id}`)).data;
            if (review.review_end && review.review_end !== "0000-00-00 00:00:00") {
                commit("SET_LOADING_STATE", "done");
                return;
            }
            if (review.passed) {
                commit("SET_LOADING_STATE", "passed");
                return;
            }
            const taxonomies = (await axios.get(`/wp-json/taxonomyengine/v1/taxonomies/${taxonomyengine_post_id}`)).data;
            const selected_taxonomies = review.terms ? review.terms.map(term => term.term_id) : [];
            commit("SET_KEYVAL", { key: "selected_taxonomies", value: selected_taxonomies });
            commit("SET_KEYVAL", { key: "taxonomies", value: taxonomies });
            commit("SET_KEYVAL", { key: "review", value: review });
            commit("SET_KEYVAL", { key: "page_count", value: Object.keys(taxonomies).length });
            dispatch("set_page", 1);
            const instructions_visible = localStorage.getItem("taxonomyengine_instructions_visible") === "true";
            commit("SET_KEYVAL", { key: "instructions_visible", value: instructions_visible });
            commit("SET_LOADING_STATE", "loaded")
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
    },

    set_page({ commit, state }, page) {
        commit("SET_KEYVAL", { key: "current_page", value: page });
        commit("SET_KEYVAL", { key: "current_taxonomy", value: state.taxonomies[Object.keys(state.taxonomies)[page - 1]] });
    },

    next_page({ dispatch, state }) {
        if (globalThis.taxonomyengine_require_answer) {
            if (!check_selected(state.current_taxonomy)) {
                return;
            }
        }
        if (state.current_page < state.page_count) {
            dispatch("set_page", state.current_page + 1);
        }
    },

    prev_page({ dispatch, state }) {
        if (state.current_page > 1) {
            dispatch("set_page", state.current_page - 1);
        }
    },
    
    async done({ commit, state }) {
        if (globalThis.taxonomyengine_require_answer) {
            if (!check_selected(state.current_taxonomy)) {
                return;
            }
        }
        await axios.post(`/wp-json/taxonomyengine/v1/taxonomies/${taxonomyengine_post_id}/done`);
        commit("SET_LOADING_STATE", "done");
    },

    async save_taxonomy({ commit, state }, taxonomy) {
        try {
            await axios.post(`/wp-json/taxonomyengine/v1/taxonomies/${taxonomyengine_post_id}`, {taxonomy});
            
        } catch (error) {
            console.error(error)
            commit("SET_KEYVAL", { key: "error", value: error });
        }
    },

    async select_taxonomy({ commit, state }, taxonomy) {
        try {
            const taxonomies = state.taxonomies;
            //Find taxonomy in nested object taxonomies
            const found_taxonomy = find_taxonomy_by_id(taxonomies, taxonomy.id);
            //If taxonomy is not found, return
            if (!found_taxonomy) {
                return;
            }
            found_taxonomy.selected = true;
            commit("SET_KEYVAL", { key: "taxonomies", value: taxonomies });
        } catch (error) {
            console.error(error)
            commit("SET_KEYVAL", { key: "error", value: error });
        }
    },
    hide_instructions({ commit }) {
        commit("SET_KEYVAL", { key: "instructions_visible", value: false });
        localStorage.setItem("taxonomyengine_instructions_visible", false);
    },
    show_instructions({ commit }) {
        commit("SET_KEYVAL", { key: "instructions_visible", value: true });
        localStorage.setItem("taxonomyengine_instructions_visible", true);
    }
}

const mutations = {
    SET_KEYVAL (state, keyval) {
        state[keyval.key] = keyval.value
    },
    SET_LOADING_STATE(state, loading_state) {
        state.loading_state = loading_state;
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}