<?php

class TaxonomyEngineAPI {
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('rest_api_init', [$this, 'register_api_routes' ]);
    }

    function register_api_routes() {
        register_rest_route( 'taxonomyengine/v1', '/taxonomies/(?P<post_id>[0-9]+)', [
            'methods' => 'GET',
            'callback' => [$this, 'get_taxonomies'],
        ]);
        register_rest_route( "taxonomyengine/v1", "/taxonomies/(?P<post_id>[0-9]+)", [
            'methods' => 'POST',
            'callback' => [$this, 'post_post_taxonomy'],
            'permission_callback' => [$this, 'check_post_access']
        ]);
        register_rest_route( 'taxonomyengine/v1', '/next_article', [
            'methods' => 'GET',
            'callback' => [$this, 'get_next_article'],
        ]);
        register_rest_route( 'taxonomyengine/v1', '/next_article/redirect', [
            'methods' => 'GET',
            'callback' => [$this, 'get_next_article_redirect'],
        ]);
    }

    function check_post_access(WP_REST_Request $request) { // TODO: This needs to be changed for crowdsourced submissions, or have another endpoint for that
        return true;
        return current_user_can('edit_posts');
    }

    function get_taxonomies($request) {

        function map_term($term, $selected) {
            $result = new stdClass();
            $result->id = $term->term_id;
            $result->name = $term->name;
            $result->slug = $term->slug;
            $result->description = $term->description;
            if (in_array($term->term_id, $selected)) {
                $result->selected = true;
            }
            $result->children = get_taxonomy_children($term->term_id, $selected);
            return $result;
        }

        function get_taxonomy_children($parent_id, $selected) {
            $children = get_terms([
                'taxonomy' => "taxonomyengine",
                'hide_empty' => false,
                'parent' => $parent_id,
            ]);
            $children_array = [];
            foreach ($children as $child) {
                $children_array[] = map_term($child, $selected);
            }
            return $children_array;
        }

        $terms = get_terms("taxonomyengine", [
            'parent' => 0,
            'hide_empty' => false,
        ]);
        $post_id = $request->get_param('post_id');
        $selected = array_map(function($term) {
            return $term->term_id;
        }, get_the_terms($post_id, "taxonomyengine"));
        $taxonomy = [];
        // array_map(function($term) use (&$taxonomy) {
        //     $taxonomy->{$term->slug} = map_term($term);
        // }, $terms);
        foreach ($terms as $term) {
            $taxonomy[] = map_term($term, $selected);
        }
        return $taxonomy;
    }

    function post_post_taxonomy($request) { // TODO
        $post_id = $request->get_param('post_id');
        $data = json_decode(file_get_contents('php://input'), true);
        $taxonomy = $data["taxonomy"];
        if ($taxonomy["selected"]) {
            wp_set_object_terms( $post_id, $taxonomy["id"], "taxonomyengine", true );
        } else {
            wp_remove_object_terms( $post_id, $taxonomy["id"], "taxonomyengine" );
        }
        return $taxonomy;
    }

    function get_next_article() {
        $stragegy = get_option( "taxonomyengine_article_strategy", "random" );
        switch ($stragegy) {
            case "random":
                return $this->random_post();
            case "newest":
                return $this->newest();
            case "oldest":
                return $this->oldest();
            default:
                return $this->random_post();
        }
    }

    function get_next_article_redirect() {
        $next_article = $this->get_next_article();
        header("Location: " . get_permalink($next_article->ID));
        die();
    }

    function random_post() {
        $posts = get_posts([
            'post_type' => 'post',
            'numberposts' => 1,
            'orderby' => 'rand',
        ]);
        return $posts[0];
    }

    function newest_post() {
        $posts = get_posts([
            'post_type' => 'post',
            'numberposts' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        return $posts[0];
    }

    function oldest_post() {
        $posts = get_posts([
            'post_type' => 'post',
            'numberposts' => 1,
            'orderby' => 'date',
            'order' => 'ASC',
        ]);
        return $posts[0];
    }
}