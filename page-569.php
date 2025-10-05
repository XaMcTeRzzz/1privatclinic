<?php get_header(); ?>

<main role="main" class="content">

    <div>
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

                <li class="breadcrumb-item"><span><?php
                        if (LOCALE == 'ru') {
                            echo 'Руководство';
                        } else if (LOCALE == 'ua') {
                            echo 'Керівництво';
                        } else {
                            echo 'Executives';
                        }
                        ?></span></li>
            </ol>
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?php
                    if (LOCALE == 'ru') {
                        echo 'Руководство';
                    } else if (LOCALE == 'ua') {
                        echo 'Керівництво';
                    } else {
                        echo 'Executives';
                    }
                    ?></h1>
                </div>
                <div class="title-decor">
                    <svg width="70" height="20" viewBox="0 0 70 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="strokeGradient" x1="0" y1="0" x2="70" y2="0" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#04B8FE"></stop>
                                <stop offset="100%" stop-color="#00DBA1"></stop>
                            </linearGradient>
                        </defs>

                        <path d="M0 10H28L33 5L38 14L43 9H70" stroke="url(#strokeGradient)" stroke-width="2"></path>

                        <path d="M0 8H28L33 3L38 12L43 7H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.6"></path>
                        <path d="M0 12H28L33 7L38 16L43 11H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.4"></path>
                    </svg>
                </div>
            </div>
            <div class="guide">
                <div class="rowFlexPad">
                    <div class="colPadDef colPad-sm-2 as-fe">
                        <div class="swiper-container gallery-top guide-left js__guide-left">
                            <div class="swiper-wrapper">
                                <?php
                                $slider_blocks = CFS()->get('guide_blocks');
                                if ($slider_blocks) {
                                    foreach ($slider_blocks as $block) {
                                ?>
                                <div class="swiper-slide">
                                    <div class="guide-left__item">
                                        <div class="guide-left__item-img">
                                            <img src="<?php echo $block['guide_img'] ?>" alt="<?php echo $block['guide_fio_' . LOCALE] ?>">
                                        </div>
                                        <div class="guide-left__item-text">
                                            <?php
                                            $name = $block['guide_fio_' . LOCALE];
                                            if ($name == '') {
                                                $name = $block['guide_fio_ru'];
                                            }
                                            $name_array = explode(" ", $name, 2);
                                            $name = ' <div class="guide-left__item-text-title">' . $name_array[0] . '</div>';
                                            $name .= '<div class="guide-left__item-text-title">' . $name_array[1] . '</div>';
                                            echo $name;
                                            ?>
                                            <?php
                                            $position = $block['guide_position_' . LOCALE];
                                            if ($position == '') {
                                                $position = $block['guide_position_ru'];
                                            }
                                            ?>
                                            <div class="guide-left__item-text-decr"><?php echo $position ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="colPadDef colPad-sm-10 colPad-lg-8">
                        <div class="swiper-container guide-right js__guide-right">
                            <div class="swiper-wrapper">

                                <?php
                                if ($slider_blocks) {
                                    foreach ($slider_blocks as $block) {

                                ?>
                                <div class="swiper-slide">
                                    <div class="guide-right__item">
                                        <div class="guide-right__item-img">
                                            <img src="<?php echo $block['guide_img'] ?>" alt="<?php echo $block['guide_fio_' . LOCALE] ?>">
                                        </div>
                                        <div class="guide-right__item-text">
                                            <?php
                                            $name = $block['guide_fio_' . LOCALE];
                                            if ($name == '') {
                                                $name = $block['guide_fio_ru'];
                                            }
                                            $name_array = explode(" ", $name, 2);
                                            $name = ' <div class="guide-right__item-text-title">' . $name_array[0] . '</div>';
                                            $name .= '<div class="guide-right__item-text-title">' . $name_array[1] . '</div>';
                                            echo $name;
                                            ?>
                                            <?php
                                            $position = $block['guide_position_' . LOCALE];
                                            if ($position == '') {
                                                $position = $block['guide_position_ru'];
                                            }
                                            ?>
                                            <div class="guide-right__item-text-decr"><?php echo $position ?></div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-nav-block">
                                                <div class="swiper-button-next">

                                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7 1L1 7L7 13" stroke="#999999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="swiper-button-prev">
                                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 13L7 7L0.999999 1" stroke="#999999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>






</main>

<?php get_footer(); ?>
