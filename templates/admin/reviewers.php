<div class="wrap">
    <form method="post" action="options.php">
        <?php settings_fields( 'taxonomyengine-settings-group' ); ?>
        <?php do_settings_sections( 'taxonomyengine-settings-group' ); ?>
        <h2><?php _e( 'TaxonomyEngine Settings', 'taxonomyengine' ); ?></h2>
        <?php settings_errors(); ?>
        <hr>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th><?= _e("Reviewer", "taxonomyengine") ?></th>
                    <th><?= _e("Weight", "taxonomyengine") ?></th>
                    <th><?= _e("# Articles Reviewed", "taxonomyengine") ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $reviewers = TaxonomyEngineSettings::get_reviewer_list();
                foreach($reviewers as $reviewer) { ?>
                <tr>
                    <td>
                        <?= $reviewer ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?=	submit_button(); ?>
    </form>
</div>