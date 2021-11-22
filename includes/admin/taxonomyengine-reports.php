<?php

class TaxonomyEngineReports {
    
    public function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'reports_page' ]);
        add_action('rest_api_init', [$this, 'register_api_routes' ]);
        $this->taxonomyengine_db = new TaxonomyEngineDB($this->taxonomyengine_globals);
    }

    public function reports_page() {
        add_submenu_page(
            'taxonomyengine',
			'TaxonomyEngine Reports',
			'Reports',
			'manage_options',
			'taxonomyengine_reports',
			[ $this, 'taxonomyengine_reports' ],
		);
    }

    public function taxonomyengine_reports() {
        $review_end_histogram = $this->taxonomyengine_db->review_end_histogram();
		require_once plugin_dir_path( dirname( __FILE__ ) ).'admin/views/reports.php';
    }

    function register_api_routes() { // TODO: Clean this up
        register_rest_route( "taxonomyengine/v1", "/reports/review_end_histogram", [
            'methods' => 'GET',
            'callback' => [$this, 'get_review_end_histogram'],
            'permission_callback' => [$this, 'check_administrator_access']
        ]);
    }

    function check_administrator_access(WP_REST_Request $request) {
        return current_user_can('administrator');
    }

    function get_review_end_histogram($request) {
        $review_end_histogram = $this->taxonomyengine_db->review_end_histogram();
        return $review_end_histogram;
    }
}