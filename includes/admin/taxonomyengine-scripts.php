<?php
class TaxonomyEngineScripts {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'admin_footer', array( $this, 'print_scripts' ) );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        if (get_option('taxonomyengine_developer_mode')) {
            wp_enqueue_script( 'taxonomyengine', plugins_url( '../../dist/taxonomyengine.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        } else {
            wp_enqueue_script( 'taxonomyengine', plugins_url( '../../dist/taxonomyengine.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        }
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles() {
        if (get_option('taxonomyengine_developer_mode')) {
            wp_enqueue_style( 'taxonomyengine', plugins_url( '../../dist/taxonomyengine.css', __FILE__ ), array(), '1.0.0' );
        } else {
            wp_enqueue_style( 'taxonomyengine', plugins_url( '../../dist/taxonomyengine.min.css', __FILE__ ), array(), '1.0.0' );
        }
    }

    /**
     * Print scripts
     */
    public function print_scripts() {
        $id = get_the_ID();
        $_wpnonce = wp_create_nonce( 'wp_rest' );
        ?>
        <script type="text/javascript">
            var _wpnonce = "<?= $_wpnonce; ?>";
        </script>
        <?php
    }
}