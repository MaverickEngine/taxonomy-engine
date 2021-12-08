<template lang="pug">
div
    h2.page-header Taxonomy Engine Reports
    .card
        .card-header
            h3 Stats
        .card-body
            p
                strong Total number of reviews: 
                | {{ reviews_total }}
            p
                strong Articles reviewed in the last week: 
                | {{ reviews_last_week }}
            p
                strong Articles reviewed on average per day (last seven days): 
                | {{ reviews_last_week_average }}
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'

export default Vue.extend({
    name: 'TaxonomyEngineReports',
    components: {
        
    },
    async mounted() {
        await this.$store.dispatch("Reports/init");
    },
    computed: {
        ...mapState("Reports", [
            "review_end_histogram",
            "reviews_last_week",
            "reviews_last_week_average",
            "reviews_total"
        ])
    },
})
</script>