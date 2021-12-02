<template lang="pug">
.taxonomyengine-reviewers
    TaxonomyEngineReviewerSearch
    TaxonomyEngineReviewerTable(:users="users")
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'
import TaxonomyEngineReviewerSearch from './TaxonomyEngineReviewerSearch.vue'
import TaxonomyEngineReviewerTable from './TaxonomyEngineReviewerTable.vue'

export default Vue.extend({
    components: {
        TaxonomyEngineReviewerSearch,
        TaxonomyEngineReviewerTable
    },
    computed: {
        ...mapState("Reviewers", ["users", "users_found", "user_search"])
    },
    mounted() {
        this.$store.dispatch("Reviewers/init")
    }
})
</script>