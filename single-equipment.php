<?php get_header(); ?>

<main role="main" class="content">

    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><?php
                    if (LOCALE == 'ru') {
                        echo 'Главная';
                    } else if (LOCALE == 'ua') {
                        echo 'Головна';
                    } else {
                        echo 'Home';
                    }
                    ?></a>
            </li>
            <li class="breadcrumb-item"><a href="/<?php echo LOCALE; ?>/oborudovanie"><?php
                    if (LOCALE == 'ru') {
                        echo 'Оборудование';
                    } else if (LOCALE == 'ua') {
                        echo 'Обладнання';
                    } else {
                        echo 'Equipment';
                    }
                    ?></a>
            </li>
            <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
        </ol>
        <div class="rowFlex mb-20-40">
            <div class="colFlex col-md-6">
                <div class="title wow" data-wow-delay="5s">
                    <div class="title-wrap">
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>
            <div class="colFlex col-md-6">
                <?php
                $equipment_subtitle = CFS()->get('equipment_subtitle_' . LOCALE);
                if ($equipment_subtitle == '') {
                    $equipment_subtitle = CFS()->get('equipment_subtitle_ru');
                }
                ?>
                <div class="title-sm"><?php echo $equipment_subtitle ?></div>
            </div>


        </div>
        <div class="specials">
            <div class="specials__card rowFlexPad jcc mb-65-85">
                <div class="specials__card-img colPadDef colPad-md-6">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </div>
                <div class="specials__card-text colPadDef colPad-md-6">
                    <div class="specials__card-text-decr decr">
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" style="color: white" class="btn mt-1 get-covid-test"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Записаться на тест';
                                } else if (LOCALE == 'ua') {
                                    echo 'Записатися на тестування';
                                } else {
                                    echo 'Sign up for testing';
                                }
                                ?></a><br><br>
                        <?php } ?>
                        <?php the_post(); the_content(); ?>
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" style="color: white" class="btn mt-1 get-covid-test"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Записаться на тест';
                                } else if (LOCALE == 'ua') {
                                    echo 'Записатися на тестування';
                                } else {
                                    echo 'Sign up for testing';
                                }
                                ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="specials__card rowFlexPad jcc mb-65-85">

                <div class="specials__card-img colPadDef colPad-md-6">
                    <?php
                    $slider_imgs = get_post_meta(get_the_ID(), 'equipment_accordion_slider');
                    if ($slider_imgs) {
                    ?>
                    <div class="page-slider">
                        <!-- Swiper -->
                        <div class="js__page-slider swiper-container">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($slider_imgs as $img) {
                                ?>
                                <div class="swiper-slide">
                                    <div class="page-slide__item">
                                        <img src="<?php echo $img['guid']; ?>" alt="<?php the_title(); ?>">
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- nav-slider -->
                            <div class="nav-slider nav-slider--sm">
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
                    <?php } ?>
                </div>
                <div class="specials__card-text colPadDef colPad-md-6">
                    <?php
                    $equipment_block_title = CFS()->get('equipment_block_title_' . LOCALE);
                    if ($equipment_block_title == '') {
                        $equipment_block_title = CFS()->get('equipment_block_title_ru');
                    }
                    ?>
                    <a href="https://medzdrav.com.ua/ua/">medzdrav.com.ua</a>
                    <div class="specials__card-text-title subtitle"><?php echo $equipment_block_title; ?></div>
                    <div class="specials__card-text-decr decr">
                        <?php echo apply_filters('the_content', CFS()->get('equipment_block_desc')); ?>
                    </div>
                </div>

                <?php
                $accordion = CFS()->get('equipment_accordion');
                if ($accordion) {
                ?>
                <div class="specials__card-accordion colPadDef colPad-lg-8">
                    <div class="product-accordion">
                        <?php
                        foreach ($accordion as $item) {
                        ?>
                        <div class="product-accordion-item">
                            <div class="product-accordion-title">
                                <?php
                                $equipment_accordion_title = $item['equipment_accordion_title_' . LOCALE];
                                if ($equipment_accordion_title == '') {
                                    $equipment_accordion_title = $item['equipment_accordion_title_ru'];
                                }
                                ?>
                                <?php echo $equipment_accordion_title; ?>
                                <span class="close"></span>
                            </div>
                            <div class="product-accordion-decr all-text">
                                <?php echo apply_filters('the_content', $item['equipment_accordion_text']); ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
