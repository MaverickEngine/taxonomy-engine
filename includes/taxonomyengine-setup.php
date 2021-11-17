<?php
class TaxonomyEngineSetup {
    function __construct() {
        add_action( "init", array( $this, "taxonomy_setup" ), 10 );
        add_action( "init", array( $this, "db_setup" ), 10 );
        add_action( "admin_init", array( $this, "ensure_roles" ), 10 );
    }

    function taxonomy_setup() {
        register_taxonomy( "taxonomyengine", ["post"], [
            "hierarchical" => true,
            "label" => "TaxonomyEngine",
            "show_ui" => true,
            "show_admin_column" => true,
            'show_in_rest' => true,
            "query_var" => true,
            "rewrite" => array( "slug" => "taxonomyengine" ),
            "public" => true,
            "show_in_menu" => true,
            "show_admin_column" => true,
        ]);
    }

    function ensure_roles() {
        add_role( TAXONOMYENGINE_REVIEWER_ROLE, __(TAXONOMYENGINE_REVIEWER_ROLE_NAME));
    }

    function db_setup() {
        $taxonomyengine_db_version = get_option("taxonomyengine_db_version", 0 );
        if ($taxonomyengine_db_version === TAXONOMYENGINE_DB_VERSION) {
            return;
        }
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $charset_collate = $wpdb->get_charset_collate();
        $reviews_table_name = $wpdb->prefix . "taxonomyengine_reviews";
        $reviews_sql = "CREATE TABLE $reviews_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id mediumint(9) NOT NULL,
            user_id mediumint(9) NOT NULL,
            review_start datetime DEFAULT now() NOT NULL,
            review_end datetime DEFAULT NULL,
            UNIQUE KEY id (id),
            KEY post_id (post_id),
            KEY user_id (user_id),
            KEY review_end (review_end)
        ) $charset_collate;";
        dbDelta( $reviews_sql );
        
        $reviews_taxonomy_table_name = $wpdb->prefix . "taxonomyengine_reviews_taxonomy";
        $reviews_taxonomy_sql = "CREATE TABLE $reviews_taxonomy_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            taxonomyengine_review_id mediumint(9) NOT NULL,
            taxonomy_id mediumint(9) NOT NULL,
            UNIQUE KEY id (id),
            KEY taxonomyengine_review_id (taxonomyengine_review_id)
        ) $charset_collate;";
        $result = dbDelta( $reviews_taxonomy_sql );
        update_option( "taxonomyengine_db_version", TAXONOMYENGINE_DB_VERSION );
    }
}