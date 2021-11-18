<template lang="pug">
    ul.taxonomyengine-list()
        li() 
            input(v-if="level > 0" type="checkbox" v-model="taxonomy.selected" @change="save_taxonomy" :disabled="selected_taxonomies.includes(taxonomy.id)")
            label {{taxonomy.name}}
            div.taxonomyengine-list-item(v-for="child in taxonomy.children")
                TaxonomyEngineTaxonomiesList(:taxonomy="child" :level="level + 1")
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'

export default Vue.extend({
    name: 'TaxonomyEngineTaxonomiesList',
    computed: {
        ...mapState("Post", [ "selected_taxonomies" ])
    },
    props: {
        taxonomy: {
            type: Object,
            required: true
        },
        level: {
            type: Number,
            required: true
        }
    },
    methods: {
        save_taxonomy() {
            this.$store.dispatch('Post/save_taxonomy', this.taxonomy)
        }
    },
})
</script>

<style lang="less" scoped>
.taxonomyengine-list {
    list-style: none;
    padding: 0 ;
    margin: 0;

    .taxonomyengine-list-item {
        padding-left: 40px;
    }
}
</style>