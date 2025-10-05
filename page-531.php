<?php get_header(); ?>
<?php $homeId = 1976; ?>

<main role="main" class="content">

    <div class="about-bg" data-type="background" data-speed="5" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">главная</a></li>


                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="rowFlex jc-sb-md aic-md">
                <div class="colFlex col-sm-5">
                    <div class="title wow" data-wow-delay="5s">
                        <div class="title-wrap">
                            <h1><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="colFlex col-md-6 mb-40-64">
                    <div class="title-sm-bolt"><?php the_excerpt(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?php get_template_part('core/inc/components/about-us'); ?>



    <div class="bg-gray pt-48-88">
        <div class="container-fluid">
            <div class="specials__card rowFlex mb-50">
                <div class="specials__card-img colFlex col-md-6">
                    <?php
                    if (CFS()->get('about_us_b_3_title_' . LOCALE) != '') {
                        $about_us_b_3_title = CFS()->get('about_us_b_3_title_' . LOCALE);
                    } else {
                        $about_us_b_3_title = CFS()->get('about_us_b_3_title_ru');
                    }

                    if (CFS()->get('about_us_b_3_desc_' . LOCALE) != '') {
                        $about_us_b_3_desc = CFS()->get('about_us_b_3_desc_' . LOCALE);
                    } else {
                        $about_us_b_3_desc = CFS()->get('about_us_b_3_desc_ru');
                    }
                    ?>
                    <img src="<?php echo CFS()->get('about_us_b_3_img'); ?>" alt="<?php echo $about_us_b_3_title; ?>">
                </div>
                <div class="specials__card-text colFlex col-md-6">
                    <div class="specials__card-text-title subtitle"><?php echo $about_us_b_3_title; ?></div>
                    <div class="specials__card-text-decr decr">
                        <?php echo $about_us_b_3_desc; ?>
                    </div>
                </div>
            </div>
            <div class="colFlex col-md-6 mb-50 shift-md-left-6">
                <div class="price-block price-block--page">
                    <div class="price-block-item">
                        <a href="#" class="price-block-item-icon">
                            <?php echo file_get_contents(get_template_directory() . '/core/images/svg/safe_2.svg'); ?>
                        </a>
                        <div class="price-block-item-text">
                            <div class="title-sm"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Безопасность';
                                } else if (LOCALE == 'ua') {
                                    echo 'Безпечність';
                                }
                                ?></div>
                            <div class="decr"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Совершенно все услуги безболезненны и безопасны для вашего здоровья и ваших близких, так же соблюдается 100% конфиденциальность';
                                } else if (LOCALE == 'ua') {
                                    echo 'Цілком всі послуги безболісні і безпечні для вашого здоров\'я і ваших близьких, так само дотримується 100% конфіденційність';
                                }
                                ?></div>
                        </div>
                    </div>
                    <div class="price-block-item">
                        <a href="#" class="price-block-item-icon">
                            <?php echo file_get_contents(get_template_directory() . '/core/images/svg/reliability_2.svg'); ?>
                        </a>
                        <div class="price-block-item-text">
                            <div class="title-sm"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Надежность';
                                } else if (LOCALE == 'ua') {
                                    echo 'Надійність';
                                }
                                ?></div>
                            <div class="decr"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Вы можете быть уверены в том, что получите точный и достоверный результат вовремя';
                                } else if (LOCALE == 'ua') {
                                    echo 'Ви можете бути впевнені в тому, що отримаєте точний і достовірний результат вчасно';
                                }
                                ?></div>
                        </div>
                    </div>
                    <div class="price-block-item">
                        <a href="#" class="price-block-item-icon">
                            <svg class="svg-sprite-icon icon-sale">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#sale"></use>
                            </svg>
                        </a>
                        <div class="price-block-item-text">
                            <div class="title-sm"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Акции, спец. предложения';
                                } else if (LOCALE == 'ua') {
                                    echo 'Акції, спец. пропозиції';
                                }
                                ?></div>
                            <div class="decr"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Быстрое и качественное оформление результатов анализов поможет вам сэкономить массу времени';
                                } else if (LOCALE == 'ua') {
                                    echo 'Швидке і якісне оформлення результатів аналізів допоможе вам заощадити масу часу';
                                }
                                ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="specials__card rowFlex mb-50">
                <div class="specials__card-img colFlex col-md-6">
                    <?php
                    if (CFS()->get('about_us_b_4_title_' . LOCALE) != '') {
                        $about_us_b_4_title = CFS()->get('about_us_b_4_title_' . LOCALE);
                    } else {
                        $about_us_b_4_title = CFS()->get('about_us_b_4_title_ru');
                    }

                    if (CFS()->get('about_us_b_4_desc_' . LOCALE) != '') {
                        $about_us_b_4_desc = CFS()->get('about_us_b_4_desc_' . LOCALE);
                    } else {
                        $about_us_b_4_desc = CFS()->get('about_us_b_4_desc_ru');
                    }
                    ?>
                    <img src="<?php echo CFS()->get('about_us_b_4_img'); ?>" alt="<?php echo $about_us_b_4_title ?>">
                </div>
                <div class="specials__card-text colFlex col-md-6">
                    <div class="specials__card-text-title subtitle"><?php echo $about_us_b_4_title ?></div>
                    <div class="specials__card-text-decr decr">
                        <?php echo $about_us_b_4_desc; ?>
                    </div>
                </div>
            </div>
            <div class="specials__card rowFlex mb-50">
                <?php
                if (CFS()->get('about_us_b_5_title_' . LOCALE) != '') {
                    $about_us_b_5_title = CFS()->get('about_us_b_5_title_' . LOCALE);
                } else {
                    $about_us_b_5_title = CFS()->get('about_us_b_5_title_ru');
                }

                if (CFS()->get('about_us_b_5_desc_' . LOCALE) != '') {
                    $about_us_b_5_desc = CFS()->get('about_us_b_5_desc_' . LOCALE);
                } else {
                    $about_us_b_5_desc = CFS()->get('about_us_b_5_desc_ru');
                }
                ?>
                <div class="specials__card-img colFlex col-md-6">
                    <img src="<?php echo CFS()->get('about_us_b_5_img'); ?>" alt="<?php echo $about_us_b_5_title ?>">
                </div>
                <div class="specials__card-text colFlex col-md-6">
                    <div class="specials__card-text-title subtitle"><?php echo $about_us_b_5_title ?></div>
                    <div class="specials__card-text-decr decr">
                        <?php echo $about_us_b_5_desc; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php get_footer(); ?>
