<template lang="pug">
div
    h2 Article tagged and passed
    a(href="/wp-json/taxonomyengine/v1/next_article/redirect") Next Article
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
    name: 'TaxonomyEngineDone',
})
</script>