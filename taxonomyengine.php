<?php
/**
 * Plugin Name: TaxonomyEngine
 * Plugin URI: https://github.com/j-norwood-young/taxonomy-engine
 * Description: Categorise your WordPress content with the assistance of machine learning and crowdsourcing
 * Author: Daily Maverick, Jason Norwood-Young
 * Author URI: https://dailymaverick.co.za
 * Version: 0.0.3
 * WC requires at least: 5.8.0
 * Tested up to: 5.8.1
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( plugin_dir_path( __FILE__ ) . 'taxonomyengine_constants.php' );

function taxonomy_engine_admin_init() {
    if (!is_admin()) {
        return;
    }
    $taxonomyengine_globals = [];
    require_once(plugin_basename('includes/admin/taxonomyengine-admin.php' ) );
    $taxonomyengine_admin = new TaxonomyEngineAdmin($taxonomyengine_globals);
}
add_action( 'init', 'taxonomy_engine_admin_init', 3 );

function taxonomy_engine_frontend_init() {
    require_once( plugin_dir_path( __FILE__ ) . 'includes/frontend/taxonomyengine-frontend-reviewer.php' );
    $taxonomyengine_frontend_reviewer = new TaxonomyEngineFrontendReviewer();
}
add_action( 'init', 'taxonomy_engine_frontend_init', 3 );

function taxonomy_engine_api_init() {
    $taxonomyengine_globals = [];
    require_once(plugin_basename('includes/api/taxonomyengine-api.php' ) );
    $taxonomyengine_api = new TaxonomyEngineAPI($taxonomyengine_globals);
}
add_action( 'init', 'taxonomy_engine_api_init', 3 );

function taxonomy_engine_common_init() {
    require_once( plugin_dir_path( __FILE__ ) . 'includes/taxonomyengine-setup.php' );
    $taxonomyengine_setup = new TaxonomyEngineSetup( $taxonomyengine_globals );
}
add_action( 'init', 'taxonomy_engine_common_init', 2 );

// Shortcodes
function shortcodes($atts) {
	// require(plugin_basename("templates/debicheck-form-shortcode.php"));
}

// add_shortcode( 'debicheck-form', 'shortcodes' );