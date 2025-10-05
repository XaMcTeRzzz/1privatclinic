<?php
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$doc_banner_text = get_field('banner_doctor_title', $term);
$doc_banner_img = get_field('banner_doctor_img', $term);
$doc_banner_link = get_field('banner_doctor_link', $term);
$schedule_link = get_permalink(1009);
?>
<?php if($doc_banner_img):?>
    <div class="doc-banner">
        <div class="doc-banner__img">
            <img src='<?= $doc_banner_img ?>' alt="<?php esc_html_e($doc_banner_text) ?>">
        </div>
        <div class="container-fluid">
            <div class="doc-banner__text"><?php esc_html_e($doc_banner_text) ?></div>
            <div class="row-link">
				<?php if(strlen($doc_banner_link) > 1): ?>
                    <a class="btn btn-t" href="<?php echo $doc_banner_link?>" target="_blank"> <?php _e("подробнее о акции", 'mz') ?></a>
				<?php endif; ?>
                <a class="btn" data-fancybox="" data-src="#sign-up-modal" href="javascript:;"><?php  _e("записаться на приём" , 'mz') ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>