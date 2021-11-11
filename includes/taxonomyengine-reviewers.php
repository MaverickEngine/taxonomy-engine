<?php

class TaxonomyEngineReviewers {
    private $options = [];
    
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'reviewers_page' ]);
        add_action('admin_init', [ $this, 'register_settings' ]);
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

    public function register_settings() {
        foreach($this->options as $option) {
            register_setting( 'taxonomyengine-reviewers-group', $option );
        }
    }

    public function get_reviewer_list() {
        $users = get_users(array( 'role__in' => array( 'taxonomyengine-reveiwer' ) ) );
        $user_list = [];
        foreach($users as $user) {
            $user_list[$user->ID] = $user->display_name;
        }
        return $user_list;
    }
}