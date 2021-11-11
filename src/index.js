import Vue from 'vue';
import ReviewerPostTaxonomy from './components/ReviewerPostTaxonomy.vue';
import store from './store';

(async function main() {
    new Vue({
        store,
        el: "#TaxonomyEngineApp",
        render (h) {
            return h(ReviewerPostTaxonomy)
        }
    });
})();