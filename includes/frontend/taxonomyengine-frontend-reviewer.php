<?php

class TaxonomyEngineFrontendReviewer {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_footer', array( $this, 'print_scripts' ) );
        add_filter( 'the_content', array( $this, 'append_reviewer_content') );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        if (self::_show_content()) {
            wp_enqueue_script( 'taxonomyengine-frontend-reviewer', plugins_url( 'js/main.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0.0', true );
        }
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles() {
        if (self::_show_content()) {
            wp_enqueue_style( 'taxonomyengine-frontend-reviewer', plugins_url( 'css/taxonomyengine-frontend-reviewer.style', dirname( __FILE__ ) ), array(), '1.0.0' );
        }
    }

    /**
     * Print scripts
     */
    public function print_scripts() {
        if (self::_show_content()) {
            $terms = get_terms("taxonomyengine", [
                // 'taxonomy' => "taxonomyengine",
                'hide_empty' => false,
            ]);
            $taxonomyengine_taxonomies = $terms; 
            ?>
            <script type="text/javascript">
                var taxonomyengine_taxonomies = <?php echo json_encode($taxonomyengine_taxonomies); ?>;
            </script>
            <?php
        }
    }

    private function _show_content() {
        // Only show on individual post pages
        if (!is_single()) {
            return false;
        }
        // Only show if user is logged in
        if (!is_user_logged_in()) {
            return false;
        }
        // Only show if post matches post type
        if (!in_array(get_post_type(), get_option('taxonomyengine_post_types'))) {
            return false;
        }
        return true;
    }

    public function append_reviewer_content( $content ) {
        if (self::_show_content()) {
            ob_start();
            require_once(plugin_dir_path( dirname( __FILE__ ) ).'../templates/frontend/reviewer_post.php');
            $new_content .= ob_get_clean();
            return $content . $new_content;
        } else {
            return $content;
        }
    }
}
