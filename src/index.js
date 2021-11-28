import Vue from 'vue';
import ReviewerPostTaxonomy from './components/ReviewerPostTaxonomy.vue';
import TaxonomyEngineReports from './components/reports/TaxonomyEngineReports.vue';
import store from './store';

(async function main() {
    new Vue({
        store,
        el: "#TaxonomyEngineApp",
        render (h) {
            return h(ReviewerPostTaxonomy)
        }
    });
    new Vue({
        store,
        el: "#TaxonomyEngineReports",
        render (h) {
            return h(TaxonomyEngineReports)
        }
    });
})();