<template lang="pug">
div
    h2 {{message}}
    p Ready to rate another article?
    a(href="/wp-json/taxonomyengine/v1/next_article/redirect") Next Article
</template>

<script lang="ts">
import Vue from 'vue'
const messages = [
    "Nice Job!",
    "Well done",
    "I like your work",
    "Keep it up!",
    "You're doing great",
    "Nice one...",
    "Just one more...",
    "You're on fire!",
    "You're a star",
    "Keep this up and I'll have to tell the boss",
    "I'm impressed!",
    "Thanks!",
    "Imagine if you used your power for good...",
    "You're on a roll",
    "Don't stop now!",
    "Genius!",
    "You deserve a raise",
    "Are we paying you for this?",
    "Colour me impressed",
    "You're a pro!",
    "Good job",
    "You're a greater rater"
]
export default Vue.extend({
    name: 'TaxonomyEngineDone',
    data() {
        return {
            message: messages[Math.floor(Math.random() * messages.length)]
        }
    }
})
</script>