<template lang="pug">
    h2.page-header Taxonomy Engine Reports
    .card
        .card-header
            h3 Velocity
        .card-body
            p Reviews completed per day
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
    name: 'TaxonomyEngineReports',
    async mounted() {
        await this.$store.dispatch("Reports/init");
    },
})
</script>