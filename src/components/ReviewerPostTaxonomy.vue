<template lang="pug">
div
    h3 TaxonomyEngine
    ProgressBar(size="large" text-position="inside" :val="current_page / page_count * 100"  :text="`${current_page} / ${page_count}`" text-fg-color="white" color="green")
    TaxonomyEngineTaxonomies(:current_page="current_page" :page_count="page_count")
    TaxonomyEngineNavigation(:current_page="current_page" :page_count="page_count")
</template>

<script lang="ts">
import Vue from 'vue'
import ProgressBar from 'vue-simple-progress'
import { mapState } from 'vuex'
import TaxonomyEngineNavigation from './TaxonomyEngineNavigation.vue'
import TaxonomyEngineTaxonomies from './TaxonomyEngineTaxonomies.vue'

export default Vue.extend({
    name: 'ReviewerPostTaxonomy',
    components: {
        ProgressBar,
        TaxonomyEngineNavigation,
        TaxonomyEngineTaxonomies
    },
    computed: {
        ...mapState("Post", [ 
            "page_count",
            "current_page",
            "loading_state",
            "taxonomies"
        ]),
    },
    data() {
        return {
            taxonomiesLoaded: false
        }
    },
    async mounted() {
        await this.$store.dispatch("Post/init");
    },
    methods: {
    }
})
</script>