<template lang="pug">
    ul
        li 
            input(v-if="level > 0" type="checkbox" v-model="taxonomy.selected")
            label {{taxonomy.name}}
            div(v-for="child in taxonomy.children")
                TaxonomyEngineTaxonomiesList(:taxonomy="child" :level="level + 1")
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'TaxonomyEngineTaxonomiesList',
    props: {
        taxonomy: {
            type: Object,
            required: true
        },
        level: {
            type: Number,
            required: true
        }
    }
})
</script>