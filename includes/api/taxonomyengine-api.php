<?php

class TaxonomyEngineAPI {
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('rest_api_init', [$this, 'register_api_routes' ]);
    }

    function register_api_routes() {
        register_rest_route( 'taxonomyengine/v1', '/taxonomies', [
            'methods' => 'GET',
            'callback' => [$this, 'get_taxonomies'],
        ]);
        register_rest_route( "taxonomyengine/v1", "/set_post_taxonomies", [
            'methods' => 'POST',
            'callback' => [$this, 'set_post_taxonomies'],
            'permission_callback' => [$this, 'check_post_access']
        ]);
    }

    function check_post_access(WP_REST_Request $request) { // TODO: This needs to be changed for crowdsourced submissions, or have another endpoint for that
        return current_user_can('edit_posts');
    }

    function get_taxonomies($request) {

        function map_term($term) {
            $result = new stdClass();
            $result->id = $term->term_id;
            $result->name = $term->name;
            $result->slug = $term->slug;
            $result->description = $term->description;
            $result->children = get_taxonomy_children($term->term_id);
            return $result;
        }

        function get_taxonomy_children($parent_id) {
            $children = get_terms([
                'taxonomy' => "taxonomyengine",
                'hide_empty' => false,
                'parent' => $parent_id,
            ]);
            $children_array = [];
            foreach ($children as $child) {
                $children_array[] = map_term($child);
            }
            return $children_array;
        }

        $terms = get_terms("taxonomyengine", [
            'parent' => 0,
            'hide_empty' => false,
        ]);
        $taxonomy = new stdClass();
        // array_map(function($term) use (&$taxonomy) {
        //     $taxonomy->{$term->slug} = map_term($term);
        // }, $terms);
        foreach ($terms as $term) {
            $taxonomy->{$term->slug} = map_term($term);
        }
        return $taxonomy;
    }

    function set_post_taxonomies($request) { // TODO
        // $post_id = $request->get_param('post_id');
        // $taxonomies = $request->get_param('taxonomies');
        // $taxonomies_array = [];
        // foreach ($taxonomies as $taxonomy) {
        //     $taxonomies_array[] = $taxonomy->slug;
        // }
        // wp_set_object_terms($post_id, $taxonomies_array, "taxonomyengine");
        // return $taxonomies_array;
    }
}