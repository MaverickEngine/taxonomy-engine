import Vue from 'vue';
import ReviewerPostTaxonomy from './components/ReviewerPostTaxonomy.vue';
import TaxonomyEngineReports from './components/reports/TaxonomyEngineReports.vue';
import store from './store';

(async function main() {
    if (document.getElementById('TaxonomyEngineApp')) {
        new Vue({
            store,
            el: "#TaxonomyEngineApp",
            render (h) {
                return h(ReviewerPostTaxonomy)
            }
        });
    }
    if (document.getElementById('TaxonomyEngineReports')) {
        new Vue({
            store,
            el: "#TaxonomyEngineReports",
            render (h) {
                return h(TaxonomyEngineReports)
            }
        });
    }
})();