<template lang="pug">
table.taxonomyengine-reviewer-table.wp-list-table.widefat.fixed.striped.table-view-list
    thead
        tr
            td.manage-column.column-cb.check-column
                input(type="checkbox")
            td Username
            td Name
            td Email
            td Roles
            td Weight
            td.check-column
    tbody
        tr(v-for="user in users")
            th.check-column
                input.editor(type="checkbox" v-model="user.selected")
            th.column-username
                img.avatar.avatar-32.photo(:src="user.avatar" width="32" height="32")
                strong
                    a(href="#")
                        span.screen-reader-text
                            | Username:
                        | {{ user.user_login }}
            th.column-name
                span.screen-reader-text
                    | Name:
                | {{ user.display_name }}
            th.column-email
                a(:href="`mailto:${user.user_email}`")
                    span.screen-reader-text
                        | Email:
                    | {{ user.user_email }}
            th
                span.screen-reader-text
                    | Roles:
                |  {{ user.roles.join(', ') }}
            th
                span.screen-reader-text
                    | Weight:
                input(v-if="user.is_reviewer" type="number" v-model="user.taxonomyengine_reviewer_weight" min="0" max="1" step="0.1" @change="updateUserWeight(user)")
            th.check-column
                a(v-if="!user.is_reviewer" href="#" @click.prevent="addReviewer(user)")
                    span.dashicons.dashicons-plus
                a(v-if="user.is_reviewer" href="#" @click.prevent="removeReviewer(user)")
                    span.dashicons.dashicons-minus
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
    name: 'TaxonomyEngineReports',
    components: {},
    props: [
        "users"
    ],
    data() {
        return {
            user_search: '',
        }
    },
    methods: {
        searchUsers: function(e) {
            e.preventDefault();
            this.$store.dispatch("Reviewers/search_users", this.user_search)
        },
        addReviewer: function(user) {
            this.$store.dispatch("Reviewers/add_reviewer", user)
        },
        removeReviewer: function(user) {
            this.$store.dispatch("Reviewers/remove_reviewer", user)
        },
        updateUserWeight: function(user) {
            this.$store.dispatch("Reviewers/update_user_weight", user)
        }
    },
})
</script>

<style lang="less" scoped>
.taxonomyengine-reviewer-table {
    margin-top: 1em;
}
</style>