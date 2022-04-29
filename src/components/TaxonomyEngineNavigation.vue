<template lang="pug">
#taxonomyengine_navigation
    div.nav_arrow(v-if="current_page > 1" @click="prev_page") 
        div.arrow.up
    div.nav_arrow(v-if="current_page < page_count" @click="next_page" v-bind:class="{taxonomyengine_disable_arrow: !next_enabled()}")
        div.arrow.down
    div.done(@click="done" v-if="current_page == page_count" v-bind:class="{taxonomyengine_disable_arrow: !next_enabled()}")
        div.done_text Done
</template>

<script lang="ts">
import Vue from 'vue'
import { mapActions, mapState } from 'vuex'

function check_selected(taxonomy) {
    if (taxonomy.selected) {
        return true;
    }
    if (taxonomy.children) {
        for (let child of taxonomy.children) {
            if (check_selected(child)) {
                return true;
            }
        }
    }
    return false;
}

export default Vue.extend({
    name: "TaxonomyEngineNavigation",
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
    methods: {
        ...mapActions("Post", [
            'prev_page',
            'next_page',
            'done'
        ])
    },
    computed: {
        ...mapState("Post", [ "current_taxonomy" ]),
        
    },
    data() {
        return {
            next_enabled: function() {
                if (!globalThis.taxonomyengine_require_answer) return true;
                return check_selected(this.current_taxonomy);
            }
        }
    },
})
</script>

<style lang="less" scoped>
#taxonomyengine_navigation {
    display: flex;
    justify-content: right;
    align-items: center;
    margin-top: 20px;
    .nav_arrow {
        width: 40px;
        height: 40px;
        overflow: hidden;
        background-color: rgb(78, 156, 78);
        padding-left: 15px;
        border-radius: 8%;
        margin: 5px;
        cursor: pointer;
    }

    .arrow {
        border: solid white;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
    }

    .right {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
    }

    .left {
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg);
    }

    .up {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
    }

    .down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }

    .done {
        background-color: rgb(78, 156, 78);
        border-radius: 5%;
        height: 40px;
        line-height: 40px;
        padding: 0px 10px;
        text-align: center;
        color: white;
        cursor: pointer;
    }

    .taxonomyengine_disable_arrow {
        background-color: #96ce96;
    }
}
</style>