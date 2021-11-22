<div class="wrap">
    <h2><?php _e( 'TaxonomyEngine Reports', 'taxonomyengine-report' ); ?></h2>
    <?php settings_errors(); ?>
    <div class="card">
        <div class="card-header">
            <h3><?php _e( 'Velocity', 'taxonomyengine-report' ); ?></h3>
        </div>
        <div class="card-body">
            <p><?php _e( 'Reviews completed per day', 'taxonomyengine-report' ); ?></p>
            <canvas id="review_end_histogram" width="400" height="400"></canvas>
        </div>
    </div>
</div>