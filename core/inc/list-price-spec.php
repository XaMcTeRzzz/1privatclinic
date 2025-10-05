<?php

$price_doctor_subtitle = esc_html(get_field('spec_services_title'));
$service_arr = get_field('spec_services');

?>



<?php if (!empty($service_arr)): ?>


    <div class="subtitle mb-40-20"><?php _e('Прайс') ?></div>
    <div class="prise-block mb-48-30">
        <div class="prise-block__title"><?= $price_doctor_subtitle ?></div>
        <div class="prise-block__row">

            <?php foreach ($service_arr as $item): ?>

                <?php foreach ($item['services'] as $service):

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
    <div class="text-center">
        <a href='<?php the_permalink(1099); ?>' class="link-bubbles"><?php _e('посмотреть больше', 'mz') ?></a>
    </div>
    <div class="mb-48-30"></div>
<?php endif; ?>


