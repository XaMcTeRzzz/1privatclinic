<?php get_header(); ?>

<?php
$doctors = CFS()->get('services_add_doctors');
if ($doctors && !empty($doctors)) {
    $arrDoctors = [];
    $arrDoctors[] = [
        'text' => '',
        'placeholder' => 'true'
    ];
    foreach ($doctors as $doctor) {
        $doctor_data = get_post($doctor);
        $arrDoctors[] = [
            'value' => esc_html($doctor_data->post_title),
            'text' => esc_html($doctor_data->post_title)
        ];
    }
    $selectValue = wp_json_encode($arrDoctors, JSON_UNESCAPED_UNICODE);

}
?>

    <main role="main" class="content">
        <section class="">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><?php _e('Главная') ?></a></li>
                    <li class="breadcrumb-item"><a href="/<?php echo LOCALE; ?>/specials"><?php _e('Акции, спец. предложения') ?></a></li>
                    <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                </ol>
                <div class="rowFlexPad colPadDef jcc">
                    <div class="colPad-md-6 colPadDef mb-20-40">
                        <div class="title wow" data-wow-delay="5s">
                            <div class="title-wrap">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                        <div class="special-card__cost-row special-card__cost-row--big mb-48-30">
                            <div class="special-card__new-price"><?php the_field('new_price') ?></div>
                            <div class="special-card__old-price"><?php the_field('old_price') ?></div>
                        </div>
                        <div class="title-sm mb-20-40">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="row-link">
                            <a class="btn btn-t mr-30" data-fancybox="" data-src="#call-back" href="javascript:;"><?php _e('перезвоните мне', 'mz') ?></a>
                            <?php if (!empty($selectValue)): ?>
                                <a class="btn js__setToSelectDoctors"
                                   data-fancybox=""
                                   data-src="#sign-up-modal-doctors"
                                   data-doctors-json='<?php echo $selectValue ?>'
                                   href="javascript:;">
                                    <?php _e('записаться на приём', 'mz') ?>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="colPad-md-6 colPadDef mb-20-40">
                        <div class="page-slider">
                            <!-- Swiper -->

                            <div class="js__page-slider swiper-container">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <div class="page-slide__item">
                                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                        </div>
                                    </div>

                                    <?php
                                    $images = get_post_meta(get_the_ID(), 'special_additional_images');
                                    if ($images) {
                                        foreach ($images as $image) {
                                            ?>
                                            <div class="swiper-slide">
                                                <div class="page-slide__item">
                                                    <img src="<?php echo $image['guid']; ?>" alt="<?php the_title(); ?>">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                                <!-- nav-slider -->
                                <div class="nav-slider nav-slider--sm ">
                                    <!-- Add Arrows -->
                                    <div class="swiper-button-next">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 1L1 7L7 13" stroke="#90A8BE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    <!-- Add Pagination -->
                                    <div class="swiper-pagination"></div>

                                    <!-- Add Arrows -->
                                    <div class="swiper-button-prev">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 13L7 7L0.999999 1" stroke="#90A8BE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="colPad-md-8 colPadDef mx-auto">
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" class="btn mt-1 get-covid-test"><?php _e('Записаться на тест') ?></a>
                            <br>
                            <br>
                        <?php } ?>


                        <?php get_template_part('core/inc/list-price-spec'); ?>
                        <div class="decr mb-48-64">
                            <?php the_post();
                            the_content(); ?>
                        </div>
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" class="btn mt-1 get-covid-test"><?php _e('Записаться на тест') ?></a>
                        <?php } ?>
                        <div class="product-accordion mb-20-40">

                            <?php
                            $accordion = CFS()->get('special_accordion_blocks');
                            if ($accordion) {
                                foreach ($accordion as $accordion_item) {
                                    ?>

                                    <div class="product-accordion-item">
                                        <div class="product-accordion-title">
                                            <?php
                                            $special_accordion_block_title = $accordion_item['special_accordion_block_title_' . LOCALE];
                                            if ($special_accordion_block_title == '') {
                                                $special_accordion_block_title = $accordion_item['special_accordion_block_title_ru'];
                                            }
                                            ?>
                                            <?php echo $special_accordion_block_title; ?>
                                            <span class="close"></span>
                                        </div>
                                        <div class="product-accordion-decr all-text">
                                            <?php
                                            $special_accordion_block_desc = $accordion_item['special_accordion_block_desc_' . LOCALE];
                                            if ($special_accordion_block_desc == '') {
                                                $special_accordion_block_desc = $accordion_item['special_accordion_block_desc_ru'];
                                            }
                                            ?>
                                            <?php echo $special_accordion_block_desc; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>

                        </div>

                    </div>
                </div>


            </div>
            <div class="bg-gray doc-wrap">
                <div class="container-fluid">
                    <?php
                    if ($doctors && !empty($doctors)) {
                        ?>
                        <div class="title-sm color-gray-200"><?php _e('Врачи') ?>
                        </div>

                        <div class="doc-slider">
                            <!-- Swiper -->
                            <div class="swiper-container js__doc-slider">
                                <!-- Add Arrows -->
                                <div class="doc-nav ">
                                    <div class="swiper-button-next">
                                        <button class="arrow-cast-left"></button>
                                    </div>
                                    <div class="swiper-button-prev">
                                        <button class="arrow-cast-right"></button>
                                    </div>
                                </div>

                                <div class="swiper-wrapper">
                                    <?php
                                    foreach ($doctors as $doctor) {
                                        $doctor_data = get_post($doctor);
                                        ?>
                                        <div class="swiper-slide col-md-4">
                                            <div class="schedule-card schedule-card--lg">
                                                <div class="schedule-card__top">
                                                    <div class="schedule-card__img">
                                                        <img src="<?php echo get_the_post_thumbnail_url($doctor_data->ID); ?>" alt="">
                                                    </div>
                                                    <div class="schedule-card__text">
                                                        <?php
                                                        $doctor_name = strip_tags(apply_filters('the_content', $doctor_data->post_title));
                                                        $doctor_name_array = explode(" ", $doctor_name, 2);
                                                        $doctor_name = '<div class="small-title">' . $doctor_name_array[0] . '</div>';
                                                        $doctor_name .= '<div class="small-title">' . $doctor_name_array[1] . '</div>';
                                                        echo $doctor_name;
                                                        ?>
                                                        <div class="small-decr"><?php echo strip_tags(apply_filters('the_content', $doctor_data->post_excerpt)); ?></div>
                                                    </div>
                                                </div>
                                                <div class="schedule-card__bottom">
                                                    <a href="<?php echo $doctor_data->guid; ?>" class="link-bubbles"><?php _e('подробнее') ?></a>
                                                    <button class="btn-t btn">
                                                        <?php _e('записаться на приём') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <p class="gray-thin"><?php _e('Если заметили несоответствие цен на услуги — сообщите нам', 'mz') ?>:
                        <a class="anim-link" href="mailto:nazzdorovie@ukr.net">nazzdorovie@ukr.net</a></p>
                </div>
            </div>
        </section>
    </main>

    <?php get_template_part('core/inc/modal-doctors') ?>
    <?php get_footer(); ?>