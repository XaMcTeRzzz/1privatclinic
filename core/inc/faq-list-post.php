<?php
$cur_terms = get_the_terms(get_the_ID(), 'specializations');
$term_post_id = 'api_services_taxonomy_' . $cur_terms[0]->term_id;

$fagList = get_field('fag_doctor', $term_post_id);
$fagDoctorTitle = get_field('fag_doctor_title', $term_post_id);
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
<!--    <a class="btn btn-t" data-fancybox="" data-src="#ask-question" href="javascript:;">--><?php //_e('задать вопрос специалисту' , 'mz') ?><!--</a>-->
    <a class="btn" data-fancybox="" data-src="#sign-up-modal" href="javascript:;"><?php _e('записаться на приём', 'mz') ?></a>
</div>


