<template lang="pug">
    p
        | Test
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'ReviewerPostTaxonomy',
    props: {
        post: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            taxonomies: [],
            taxonomiesLoaded: false
        }
    },
    created() {
        this.loadTaxonomies()
    },
    methods: {
        loadTaxonomies() {
            this.taxonomiesLoaded = false
            this.$http.get(`/wp-json/wp/v2/taxonomies?per_page=100`).then(response => {
                this.taxonomies = response.data
                this.taxonomiesLoaded = true
            })
        }
    }
})
</script>