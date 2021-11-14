<template lang="pug">
    .error
        h3 We've hit a snag
        | {{ error.toString() }}
        
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    props: {
        error: {
            type: Error,
            required: true
        }
    }
})
</script>

<style lang="less" scoped>
.error {
    padding: 1rem;
    background: #fdd;
    border: 1px solid #f00;
    margin-top: 1rem;
}
</style>