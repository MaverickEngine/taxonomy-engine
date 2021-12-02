<template lang="pug">
div.search-box.taxonomyengine-search-box
    label.screen-reader-text(for="user-search-input") Find Users to Add:
    input.form-control(type="search" placeholder="Search for a user..." v-model="user_search" @keydown.enter="searchUsers")
    input.button(type="button" value="Search" @click="searchUsers")
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState, mapActions } from 'vuex'

export default Vue.extend({
    name: 'TaxonomyEngineReports',
    components: {},
    data() {
        return {
            user_search: '',
        }
    },
    computed: {
        ...mapState("Reviewers", [
            "users_found"
        ])
    },
    methods: {
        searchUsers: function(e) {
            e.preventDefault();
            this.$store.dispatch("Reviewers/search_users", this.user_search)
        },
        addReviewer: function(user) {
            this.$store.dispatch("Reviewers/add_reviewer", user)
        },
        removeReviewer: function(user) {
            this.$store.dispatch("Reviewers/remove_reviewer", user)
        },
        updateUserWeight: function(user) {
            this.$store.dispatch("Reviewers/update_user_weight", user)
        }
    },
})
</script>

<style lang="less" scoped>
.taxonomyengine-search-box {
    margin-bottom: 1em;
}
.search-results {
    margin-top: 1em;
}
</style>