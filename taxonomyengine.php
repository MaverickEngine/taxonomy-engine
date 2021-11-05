<?php
/**
 * Plugin Name: TaxonomyEngine
 * Plugin URI: https://github.com/j-norwood-young/taxonomy-engine
 * Description: Categorise your WordPress content with the assistance of machine learning and crowdsourcing
 * Author: Daily Maverick, Jason Norwood-Young
 * Author URI: https://dailymaverick.co.za
 * Version: 0.0.4-0
 * WC requires at least: 3.9
 * Tested up to: 3.9
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function taxonomy_engine_init() {
    $taxonomyengine_globals = [];
    require_once( plugin_dir_path( __FILE__ ) . 'includes/taxonomyengine-setup.php' );
    $taxonomyengine_setup = new TaxonomyEngineSetup( $taxonomyengine_globals );
    require_once(plugin_basename('includes/taxonomyengine-admin.php' ) );
    $taxonomyengine_admin = new TaxonomyEngineAdmin($taxonomyengine_globals);
}
add_action( 'init', 'taxonomy_engine_init', 5 );

// Shortcodes
function shortcodes($atts) {
	// require(plugin_basename("templates/debicheck-form-shortcode.php"));
}

// add_shortcode( 'debicheck-form', 'shortcodes' );