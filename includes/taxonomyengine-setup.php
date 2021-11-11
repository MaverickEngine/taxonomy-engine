<?php
class TaxonomyEngineSetup {
    function __construct() {
        add_action( "init", array( $this, "taxonomy_setup" ), 10 );
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
}