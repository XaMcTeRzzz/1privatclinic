<?php
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$price_doctor_title = esc_html(get_field('price_doctor_title', $term));
$price_doctor_subtitle = esc_html(get_field('price_doctor_subtitle', $term));
$service_arr = get_field('services_api', $term);


?>



<?php if (!empty($service_arr)): ?>
    <div class="mb-48-30"></div>
    <div class="row-btn mb-88-40 justify-center">
        <a class="btn btn-t" data-fancybox="" data-src="#call-back" href="javascript:;"><?php _e('перезвоните мне', 'mz') ?></a>
<!--        <a class="btn btn-t" data-fancybox="" data-src="#ask-question" href="javascript:;">--><?php //_e('задать вопрос специалисту', 'mz') ?><!--</a>-->
        <a class="btn" data-fancybox="" data-src="#sign-up-modal" href="javascript:;"><?php _e('записаться на приём', 'mz') ?></a>
    </div>

    <div class="subtitle mb-40-20"><?= $price_doctor_title ?></div>
    <?php if (is_array($service_arr[0]['service_api'])): ?>
        <div class="prise-block mb-48-30">
        <div class="prise-block__title"><?= $price_doctor_subtitle ?></div>
        <div class="prise-block__row">

            <?php

            foreach ($service_arr as $item):?>

                <?php foreach ($item['service_api'] as $service):
                    $serviceID = $service->ID;
                    $servicePrice = get_field('price_services', $serviceID);
                    ?>
                    <div class="prise-block-item">
                        <div class="prise-block-item__title"><?= $service->post_title ?></div>
                        <div class="prise-block-item__content prise-block-item__cine"><?= $servicePrice ?> грн</div>
                    </div>
                <?php endforeach; ?>

            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="text-center mb-88-40">
        <?php
            $linkPrice = get_permalink(1099);
            if(is_tax( 'specializations')){
                $specialization = urlencode(get_field('price_doctor_tag', 'specializations_'.$term->term_id));
                $linkPrice =  add_query_arg('usluga', $specialization, get_permalink(1099));
            }
        ?>
        <a href='<?= $linkPrice ?>' class="link-bubbles"><?php _e('посмотреть больше', 'mz') ?></a>
    </div>
<?php endif; ?>


