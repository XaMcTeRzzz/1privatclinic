<?php
if ( get_term_meta( get_queried_object()->term_id, 'spec_seo_text_title_' . LOCALE )[0] != "" && get_term_meta( get_queried_object()->term_id, 'spec_seo_text_desc_' . LOCALE )[0] != "" ) {
	?>
    <div class="container-fluid all-text">
        <h4><?php echo get_term_meta( get_queried_object()->term_id, 'spec_seo_text_title_' . LOCALE )[0]; ?></h4>

        <div class="all-text-column">
			<?php echo apply_filters( 'the_content', get_term_meta( get_queried_object()->term_id, 'spec_seo_text_desc_' . LOCALE )[0] ); ?>
        </div>
    </div>
<?php } ?>

