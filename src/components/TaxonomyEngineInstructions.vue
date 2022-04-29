<template lang="pug">
div
    .taxonomyengine_instructions(v-if="instructions_visible")
        #taxonomyengine_hide_instructions_btn(@click="do_hide_instructions") 
        p(v-html="taxonomyengine_instruction_text")
        
    .taxonomyengine_show_instructions(v-if="!instructions_visible")
        #taxonoyengine_show_instructions(@click="do_show_instructions") &quest;
    p= instructions_visible
</template>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'
export default Vue.extend({
    name: 'TaxonomyEngineInstructions',
    props: {
        taxonomyengine_instruction_text: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            local_taxonomyengine_instruction_text: globalThis.taxonomyengine_instruction_text || "Please select the taxonomies that you want to use for this post.",
        }
    },
    computed: {
        ...mapState("Post", ["instructions_visible"]),
    },
    methods: {
        do_hide_instructions: function() {
            this.$store.dispatch("Post/hide_instructions");
        },
        do_show_instructions: function() {
            this.$store.dispatch("Post/show_instructions");
        }
    }
})
</script>

<style lang="less" scoped>
    .taxonomyengine_instructions {
        padding: 1em;
        background-color: rgb(170, 207, 238);
        border-radius: 0.25em;
        border-color: rgb(33, 150, 243);
        position: relative;
        margin: 1em 0px;
    }

    #taxonomyengine_hide_instructions_btn {
        position: absolute;
        top: -5px;
        right: 5px;
        cursor: pointer;
    }
    
    #taxonomyengine_hide_instructions_btn::before {
        content: "×";
        font-size: 1em;
        color: rgb(33, 150, 243);
    }
    
    #taxonoyengine_show_instructions {
        // border-radius: 50%;
        color: rgb(33, 150, 243);
        display: block;
        // width: 30px;
        // height: 30px;
        // text-align: center;
        // color: white;
        font-size: 1em;
        // line-height: 27px;
        position: absolute;
        top: -5px;
        right: 5px;
        cursor: pointer;
    }
</style>