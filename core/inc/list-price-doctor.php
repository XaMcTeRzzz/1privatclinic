<?php
$cur_terms = get_the_terms(get_the_ID(), 'specializations');
$term_post_id = 'api_services_taxonomy_' . $cur_terms[0]->term_id;

if(get_field( "price_doctor_title", get_the_ID())) {
    $price_doctor_title = esc_html(get_field( "price_doctor_title", get_the_ID()));
    $price_doctor_subtitle = esc_html(get_field( "price_doctor_subtitle", get_the_ID()));
    $service_arr = get_field( "services_api", get_the_ID());
} else {
    $price_doctor_title = esc_html(get_field('price_doctor_title', $term_post_id));
    $price_doctor_subtitle = esc_html(get_field('price_doctor_subtitle', $term_post_id));
    $service_arr = get_field('services_api', $term_post_id);
}

$linkPrice =  add_query_arg('usluga', get_field('price_doctor_tag', $term_post_id),get_permalink(1099));

?>



<?php if (!empty($service_arr)): ?>
    <div class="bg-gray pt-64-40 pb-64-40">
        <div class="container-fluid">
            <div class="rowFlex jcc">
                <div class="colFlex col-sm-8">
                    <div class="subtitle mb-40-20"><?= $price_doctor_title ?></div>
                    <div class="prise-block mb-48-30">
                        <div class="prise-block__title"><?= $price_doctor_subtitle ?></div>
                        <div class="prise-block__row">

                            <?php
                            foreach ($service_arr as $item):?>
                                <?php if(is_array($item['service_api'])): ?>
                                <?php foreach ($item['service_api'] as $service):
                                    $serviceID = $service->ID;
                                    $servicePrice = get_field('price_services', $serviceID);
                                    ?>
                                    <div class="prise-block-item">
                                        <div class="prise-block-item__title"><?= $service->post_title ?></div>
                                        <div class="prise-block-item__content prise-block-item__cine"><?= $servicePrice ?> грн</div>
                                    </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href='<?= $linkPrice ?>' class="link-bubbles"><?php _e('посмотреть больше', 'mz') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


