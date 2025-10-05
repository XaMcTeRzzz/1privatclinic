<?php
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$fagList = get_field('fag_doctor', $term);
$fagDoctorTitle = get_field('fag_doctor_title', $term);
?>


<?php if (!empty($fagList)): ?>
    <div class="subtitle "><?= $fagDoctorTitle ?></div>
    <div class="product-accordion ">
        <?php foreach ($fagList as $item): ?>
            <div class="product-accordion-item">
                <div class="product-accordion-title"><?= $item['title'] ?><span class="close"></span></div>
                <div class="product-accordion-decr all-text"><?= $item['content'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    <div class="mb-40-64"></div>
    <div class="row-btn mb-88-40 justify-center">
        <?php if(is_post_type_archive('doctor')):?>
            <a class="btn btn-t" data-fancybox="" data-src="#call-back" href="javascript:;"><?php _e('перезвоните мне', 'mz') ?></a>
        <?php endif;?>
<!--        <a class="btn btn-t" data-fancybox="" data-src="#ask-question" href="javascript:;">--><?php //_e('задать вопрос специалисту' , 'mz') ?><!--</a>-->
        <a class="btn" data-fancybox="" data-src="#sign-up-modal" href="javascript:;"><?php _e('записаться на приём', 'mz') ?></a>
    </div>


