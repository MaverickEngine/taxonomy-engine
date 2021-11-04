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
    $revengine_globals = [];
    require_once(plugin_basename('includes/revengine-admin.php' ) );
    $revengine_admin = new RevEngineAdmin($revengine_globals);
    // Modules - these should eventually autoload
    require_once(plugin_basename('modules/content-promoter/content-promoter.php' ) );
    $revengine_content_promoter = new ContentPromoter($revengine_globals);
    require_once(plugin_basename('modules/piano-composer/piano-composer.php' ) );
    $piano_composer = new PianoComposer($revengine_globals);
    require_once(plugin_basename('modules/revengine-tracker/revengine-tracker.php' ) );
    $revengine_tracker = new RevEngineTracker($revengine_globals);
    require_once(plugin_basename('modules/revengine-api/revengine-api.php' ) );
    $revengine_api = new RevEngineAPI($revengine_globals);
    require_once(plugin_basename('modules/revengine-sync/revengine-sync.php' ) );
    $revengine_sync = new RevEngineSync($revengine_globals);
}
add_action( 'init', 'taxonomy_engine_init', 5 );

// Shortcodes
function shortcodes($atts) {
	// require(plugin_basename("templates/debicheck-form-shortcode.php"));
}

// add_shortcode( 'debicheck-form', 'shortcodes' );