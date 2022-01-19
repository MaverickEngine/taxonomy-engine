<template lang="pug">
    ul.taxonomyengine-list()
        li() 
            .taxonomyengine-toggle(v-if="taxonomy.children.length > 0 && level > 0" @click="visible_children = !visible_children")
                .taxonomyengine-arrow.down(v-if="visible_children")
                .taxonomyengine-arrow(v-else)
            input(v-if="level > 0" type="checkbox" v-model="taxonomy.selected" @change="save_taxonomy" :disabled="selected_taxonomies.includes(taxonomy.id)" :id="'taxonomy-' + taxonomy.id")
            label(:for="'taxonomy-' + taxonomy.id" v-bind:class="topLevel") {{taxonomy.name}}
            
            div.taxonomyengine-list-item(:id="`taxonomyengine_children_${taxonomy.id}`" v-for="child in taxonomy.children")
                div(v-if="visible_children")
                    TaxonomyEngineTaxonomiesList(:taxonomy="child" :level="level + 1")
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'

export default Vue.extend({
    name: 'TaxonomyEngineTaxonomiesList',
    computed: {
        ...mapState("Post", [ "selected_taxonomies" ]),
        topLevel: function() {
            return (this.level === 0) ? "taxonomyengine-list-item-top-level" : "";
        }
    },
    data() {
        // TODO: If a taxonomy has a child selected, its children should be visible
        // TODO: If a child is selected, its parent should be selected.
        return {
            visible_children: this.level < 1
        }
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
        async save_taxonomy() {
            if (this.level >= 2) {
                this.$parent.taxonomy.selected = true;
                await this.$store.dispatch('Post/save_taxonomy', this.$parent.taxonomy);
            }
            await this.$store.dispatch('Post/save_taxonomy', this.taxonomy)
        },
    },
})
</script>

<style lang="less" scoped>
.taxonomyengine-list {
    list-style: none;
    padding: 0 ;
    margin: 0;

    label {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: normal;
        line-height: 100%;
        vertical-align: middle;
    }

    .taxonomyengine-list-item-top-level {
        font-weight: bold;
        font-size: 12pt;
        margin-bottom: 15pt;
        display: block;
        text-decoration: underline;
    }

    .taxonomyengine-list-item {
        padding-left: 40px;
    }

    .taxonomyengine-toggle {
        width: 20px;
        height: 20px;
        position: relative;
        display: inline-flex;
        margin-left: -1em;
        cursor: pointer;
    }

    .taxonomyengine-arrow::before {
        position: absolute;
        content: '';
        width: 0;
        height: 0;
        border: .5em solid transparent;
        border-left-color: gray;
        transform-origin: 0 50%;
        transition: transform .25s;
    }

    .taxonomyengine-arrow.down::before {
        transform: rotate(90deg);
        transition: transform .25s;
    }
}
</style>