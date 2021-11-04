<?php

class TaxonomyEngineSettings {
    
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'settings_page' ]);
    }

    function settings_page() {
        add_submenu_page(
            'taxonomyengine',
			'TaxonomyEngine Settings',
			'Settings',
			'manage_options',
			'taxonomyengine',
			[ $this, 'taxonomyengine_settings' ]
		);
    }

    function taxonomyengine_settings() {
		require_once plugin_dir_path( dirname( __FILE__ ) ).'templates/admin/settings.php';
    }
}