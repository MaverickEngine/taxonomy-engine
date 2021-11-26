<template lang="pug">
div.taxonomyengine
    h3 TaxonomyEngine
    Error(v-if="loading_state === 'error'" :error="error")
    ProgressBar.progressbar(v-if="loading_state === 'loaded'" size="large" text-position="bottom" :val="current_page / page_count * 100" :text="`${current_page} / ${page_count}`" text-fg-color="black" color="green")
    TaxonomyEngineTaxonomies(v-if="loading_state === 'loaded'" :current_page="current_page" :page_count="page_count")
    TaxonomyEngineNavigation(v-if="loading_state === 'loaded'" :current_page="current_page" :page_count="page_count")
    TaxonomyEngineDone(v-if="loading_state === 'done'")
    TaxonomyEnginePassed(v-if="loading_state === 'passed'")
</template>

<script lang="ts">
import Vue from 'vue'
import ProgressBar from 'vue-simple-progress'
import { mapState } from 'vuex'
import TaxonomyEngineNavigation from './TaxonomyEngineNavigation.vue'
import TaxonomyEngineTaxonomies from './TaxonomyEngineTaxonomies.vue'
import TaxonomyEngineDone from './TaxonomyEngineDone.vue'
import TaxonomyEnginePassed from './TaxonomyEnginePassed.vue'
import Error from './Error.vue'

export default Vue.extend({
    name: 'ReviewerPostTaxonomy',
    components: {
        ProgressBar,
        TaxonomyEngineNavigation,
        TaxonomyEngineTaxonomies,
        TaxonomyEngineDone,
        Error,
        TaxonomyEnginePassed
    },
    computed: {
        ...mapState("Post", [ 
            "page_count",
            "current_page",
            "loading_state",
            "taxonomies",
            "error"
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

<style lang="less" scoped>
</style>