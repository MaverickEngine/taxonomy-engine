<?php

class TaxonomyEngineDB {
    public function __construct() {
        global $wpdb;
        $this->taxonomy_tablename = $wpdb->prefix . "taxonomyengine_reviews_taxonomy";
        $this->reviews_tablename = $wpdb->prefix . "taxonomyengine_reviews";
    }

    public function get_or_create_review($user_id, $post_id) {
        global $wpdb;
        $result = $wpdb->get_row("SELECT * FROM {$this->reviews_tablename} WHERE post_id = $post_id AND user_id = $user_id");
        if (!$result) {
            $wpdb->insert($this->reviews_tablename, [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'review_start' => current_time('mysql'),
            ]);
            $review_id = $wpdb->insert_id;
            return (object) [
                'id' => $review_id,
                'post_id' => $post_id,
                'user_id' => $user_id,
                'review_start' => current_time('mysql'),
                'user_taxonomy' => []
            ];
        } else {
            $review_id = $result->id;
            return (object) [
                'id' => $review_id,
                'post_id' => $post_id,
                'user_id' => $user_id,
                'review_start' => $result->review_start,
                'user_taxonomy' => $this->get_user_taxonomy($review_id)
            ];
        }
    }

    public function get_user_taxonomy($review_id) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM {$this->taxonomy_tablename} WHERE taxonomyengine_review_id = $review_id");
        return $result;
    }

    public function get_user_post_taxonomy($user_id, $post_id) {
        global $wpdb;
        $sql = "SELECT {$this->taxonomy_tablename}.* FROM {$this->taxonomy_tablename} 
        JOIN {$this->reviews_tablename} ON {$this->reviews_tablename}.id = {$this->taxonomy_tablename}.taxonomyengine_review_id 
        WHERE {$this->reviews_tablename}.user_id = $user_id AND {$this->reviews_tablename}.post_id = $post_id";
        $result = $wpdb->get_results($sql);
        return $result;
    }

    public function insert_taxonomy($review_id, $taxonomy_id) {
        global $wpdb;
        $wpdb->insert($this->taxonomy_tablename, [
            'taxonomyengine_review_id' => $review_id,
            'taxonomy_id' => $taxonomy_id,
        ]);
    }

    public function delete_taxonomy($review_id, $taxonomy_id) {
        global $wpdb;
        $wpdb->delete($this->taxonomy_tablename, [
            'taxonomyengine_review_id' => $review_id,
            'taxonomy_id' => $taxonomy_id,
        ]);
    }
}