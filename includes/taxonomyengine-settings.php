<?php

class TaxonomyEngineSettings {
    private $options = [
        "taxonomyengine_post_types",
        "taxonomyengine_article_strategy",
        "taxonomyengine_percentage_pass",
        "taxonomyengine_pass_score"
    ];

    const TAXONOMYENGINE_ARTICLE_SELECTION_STRATEGIES = [
        "taxonomyengine-article-strategy-random" => "Random",
        "taxonomyengine-article-strategy-latest" => "Latest",
        "taxonomyengine-article-strategy-popular" => "Popular",
    ];

    const TAXONOMYENGINE_TAGS_PASS = [
        "taxonomyengine-tags-pass-none" => "None",
        "taxonomyengine-tags-pass-all" => "All",
        "taxonomyengine-tags-pass-custom" => "Custom",
    ];
    
    function __construct($taxonomyengine_globals) {
        $this->taxonomyengine_globals = &$taxonomyengine_globals;
        add_action('admin_menu', [ $this, 'settings_page' ]);
        add_action('admin_init', [ $this, 'register_settings' ]);
    }

    function settings_page() {
        add_submenu_page(
            'taxonomyengine',
			'TaxonomyEngine Settings',
			'Settings',
			'manage_options',
			'taxonomyengine',
			[ $this, 'taxonomyengine_settings' ]
		);
    }

    function taxonomyengine_settings() {
		require_once plugin_dir_path( dirname( __FILE__ ) ).'templates/admin/settings.php';
    }

    public function register_settings() {
        foreach($this->options as $option) {
            register_setting( 'taxonomyengine-settings-group', $option );
        }
    }

    public function get_article_strategies() {
        return self::TAXONOMYENGINE_ARTICLE_SELECTION_STRATEGIES;
    }

    public function get_author_list($search = "") {
        $users = get_users(array( 'search' => $search, 'role__in' => array( 'author', 'editor', 'administrator' ) ) );
        $user_list = [];
        foreach($users as $user) {
            $user_list[$user->ID] = $user->display_name;
        }
        return $user_list;
    }

}