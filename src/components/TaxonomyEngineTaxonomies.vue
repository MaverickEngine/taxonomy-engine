<template lang="pug">
div#taxonomy-engine-taxonomies
    TaxonomyEngineTaxonomiesList.page_container(:taxonomy="current_taxonomy" :level="0")

</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'
import TaxonomyEngineTaxonomiesList from './TaxonomyEngineTaxonomiesList.vue';

export default Vue.extend({
    name: 'TaxonomyEngineTaxonomies',
    components: {
        TaxonomyEngineTaxonomiesList
    },
    props: {
        current_page: {
            type: Number,
            required: true
        },
        page_count: {
            type: Number,
            required: true
        },
    },
    computed: {
        ...mapState("Post", ["taxonomies", "current_taxonomy"]),
    }
})
</script>

<style lang="less" scoped>
#taxonomy-engine-taxonomies {
    .page_container {
        height: 70vh;
        overflow: scroll;
    }
}
</style>