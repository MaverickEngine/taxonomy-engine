import moment from 'moment';
import {axios} from "../../libs/wp_axios";

const state = {
    loading_state: "loading",
    reviews_last_week: "...",
    reviews_last_week_average: "...",
    reviews_total: "...",
    review_end_histogram: [],
    error: false,
}

const getters = {
}

const actions = {
    async init({ commit, dispatch, state }) {
        try {
            const review_end_histogram = await axios.get(`/wp-json/taxonomyengine/v1/reports/review_end_histogram`);
            commit("SET_KEYVAL", { key: "review_end_histogram", value: review_end_histogram.data });
            const reviews_last_week = review_end_histogram.data.filter(row => moment(row.date).isSameOrAfter(moment().subtract(7, 'days'))).reduce((acc, row) => acc + parseInt(row.count), 0);
            commit("SET_KEYVAL", { key: "reviews_last_week", value: reviews_last_week });
            const reviews_last_week_average = reviews_last_week / 7;
            commit("SET_KEYVAL", { key: "reviews_last_week_average", value: Math.round(reviews_last_week_average * 100) / 100 });
            commit("SET_KEYVAL", { key: "reviews_total", value: review_end_histogram.data.reduce((acc, row) => acc + parseInt(row.count), 0) });
            // const review = (await axios.get(`/wp-json/taxonomyengine/v1/review/${taxonomyengine_post_id}`)).data;
            // if (review.review_end && review.review_end !== "0000-00-00 00:00:00") {
            //     commit("SET_LOADING_STATE", "done");
            //     return;
            // }
            // if (review.passed) {
            //     commit("SET_LOADING_STATE", "passed");
            //     return;
            // }
            // const taxonomies = (await axios.get(`/wp-json/taxonomyengine/v1/taxonomies/${taxonomyengine_post_id}`)).data;
            // const selected_taxonomies = review.terms ? review.terms.map(term => term.term_id) : [];
            // commit("SET_KEYVAL", { key: "selected_taxonomies", value: selected_taxonomies });
            // commit("SET_KEYVAL", { key: "taxonomies", value: taxonomies });
            // commit("SET_KEYVAL", { key: "review", value: review });
            // commit("SET_KEYVAL", { key: "page_count", value: Object.keys(taxonomies).length });
            // dispatch("set_page", 1);
            commit("SET_LOADING_STATE", "loaded")
        } catch (error) {
            console.error("Got an error", error.toString())
            commit("SET_KEYVAL", { key: "error", value: error });
            commit("SET_LOADING_STATE", "error")
        }
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