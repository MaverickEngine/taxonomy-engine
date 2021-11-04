<?php

class TaxonomyEngineAdmin {

    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'menu' ]);
        require_once(plugin_basename('taxonomyengine-settings.php' ) );
        $taxonomyengine_settings = new TaxonomyEngineSettings($this->taxonomyengine_globals);
        require_once(plugin_basename('taxonomyengine-reports.php' ) );
        $taxonomyengine_reports = new TaxonomyEngineReports($this->taxonomyengine_globals);
        require_once(plugin_basename('taxonomyengine-taxonomy.php' ) );
        $taxonomyengine_taxonomy = new TaxonomyEngineTaxonomy($this->taxonomyengine_globals);
    }

    function menu() {
        add_menu_page(
            'TaxonomyEngine',
			'TaxonomyEngine',
			'manage_options',
			'taxonomyengine',
			null,
            "",
            30
        );
    }
}