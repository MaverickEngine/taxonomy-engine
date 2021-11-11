<?php

class TaxonomyEngineReviewers {
    private $options = [];
    
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'reviewers_page' ]);
        add_action('admin_init', [ $this, 'save_changes' ]);
    }

    function reviewers_page() {
        add_submenu_page(
            'taxonomyengine',
			'TaxonomyEngine Reviewers',
			'Reviewers',
			'manage_options',
			'taxonomyengine_reviewers',
			[ $this, 'taxonomyengine_reviewers' ]
		);
    }

    function taxonomyengine_reviewers() {
		require_once plugin_dir_path( dirname( __FILE__ ) ).'templates/admin/reviewers.php';
    }

    public function save_changes() {
        $reviewer_weights = $_POST["taxonomyengine_reviewer_weight"];
        if (isset($reviewer_weights)) {
            foreach ($reviewer_weights as $reviewer_id => $weight) {
                $this->set_reviewer_weight($reviewer_id, $weight);
            }
        }
    }

    protected function set_reviewer_weight($user_id, $weight) {
        update_user_meta( $user_id, "taxonomyengine_reviewer_weight", $weight );
    }

    public function get_reviewer_list() {
        $users = get_users(array( 'role__in' => array( TAXONOMYENGINE_REVIEWER_ROLE ) ) );
        $user_list = [];
        foreach($users as $user) {
            $user_list[$user->ID] = [ "name" => $user->display_name, "taxonomyengine_reviewer_weight" => get_user_meta( $user->ID, 'taxonomyengine_reviewer_weight', true ) ];
        }
        return $user_list;
    }
}