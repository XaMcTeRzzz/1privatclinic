<?php get_header(); ?>
<?php
$homeId = 1976;
$chekUpPage = 1974;
?>


<main role="main" class="content">
    <?php

    $videId = get_src_iframe_id(get_field('home_video', $homeId, false));

    if (LOCALE == 'ru'):
        $imgSrcs = get_field('home_photos_ru', $homeId);
        $imgSrcsMobile = get_field('home_photos_ru_mobile', $homeId);
    else:
        $imgSrcs = get_field('home_photos_ua', $homeId);
        $imgSrcsMobile = get_field('home_photos_ua_mobile', $homeId);
    endif;
    $linkService = get_field('home_video_link', $homeId);
    $text = get_field('home_video_title', $homeId);

    ?>

    <!-- Swiper -->
    <div class="container">
        <div class="swiper-container banner__slider">
            <div class="swiper-wrapper">
                <?php
                if ($imgSrcs) {
                    // Используем все загруженные фото без ограничений для бесконечного цикла
                    foreach ($imgSrcs as $slide) {
                        ?>
                        <div class="swiper-slide">
                            <div class="banner__slider-item">
                                <?php
                                // Пробуем разные поля для ссылки
                                $image_alt = isset($slide['alt']) ? $slide['alt'] : '';
                                $image_caption = isset($slide['caption']) ? $slide['caption'] : '';
                                $image_description = isset($slide['description']) ? $slide['description'] : '';
                                
                                // Используем первое непустое поле
                                $link_url = '#';
                                if (!empty(trim($image_alt))) {
                                    $link_url = trim($image_alt);
                                } elseif (!empty(trim($image_caption))) {
                                    $link_url = trim($image_caption);
                                } elseif (!empty(trim($image_description))) {
                                    $link_url = trim($image_description);
                                }

                                // ВРЕМЕННАЯ ОТЛАДОЧНАЯ ИНФОРМАЦИЯ
                                echo '<!-- SLIDE DATA: ' . print_r($slide, true) . ' -->';
                                echo '<!-- ALT: ' . htmlspecialchars($image_alt) . ', URL: ' . htmlspecialchars($link_url) . ' -->';

                                // Определяем нужно ли открывать в новой вкладке
                                $is_external = !empty($link_url) && $link_url !== '#' && (strpos($link_url, 'http') === 0) && (strpos($link_url, $_SERVER['HTTP_HOST']) === false);
                                $target_attr = $is_external ? 'target="_blank" rel="noopener noreferrer"' : '';
                                ?>
                                <?php if ($link_url !== '#'): ?>
                                <a href="<?= esc_url($link_url) ?>" class="banner-slide-link">
                                    <img src="<?= $slide['url'] ?>" data-src="" alt="<?= $slide['name'] ?>">
                                </a>
                                <?php else: ?>
                                <img src="<?= $slide['url'] ?>" data-src="" alt="<?= $slide['name'] ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <!-- Кнопки навигации под слайдером -->
        <div class="banner-navigation">
            <div class="swiper-button-prev banner-slider-prev">
                <span>&lt;</span>
            </div>
            <div class="swiper-button-next banner-slider-next">
                <span>&gt;</span>
            </div>
        </div>
    </div>
    <div class="swiper-container banner__slider mobile">
        <div class="swiper-wrapper">
            <?php
            if ($imgSrcsMobile) {
                // Используем все мобильные фото для бесконечного цикла
                foreach ($imgSrcsMobile as $slide) {
                    ?>
                    <div class="swiper-slide">
                        <div class="banner__slider-item">
                            <?php
                            // Пробуем разные поля для ссылки (мобильный)
                            $image_alt = isset($slide['alt']) ? $slide['alt'] : '';
                            $image_caption = isset($slide['caption']) ? $slide['caption'] : '';
                            $image_description = isset($slide['description']) ? $slide['description'] : '';
                            
                            // Используем первое непустое поле
                            $link_url = '#';
                            if (!empty(trim($image_alt))) {
                                $link_url = trim($image_alt);
                            } elseif (!empty(trim($image_caption))) {
                                $link_url = trim($image_caption);
                            } elseif (!empty(trim($image_description))) {
                                $link_url = trim($image_description);
                            }

                            // Определяем нужно ли открывать в новой вкладке
                            $is_external = !empty($link_url) && $link_url !== '#' && (strpos($link_url, 'http') === 0) && (strpos($link_url, $_SERVER['HTTP_HOST']) === false);
                            $target_attr = $is_external ? 'target="_blank" rel="noopener noreferrer"' : '';
                            ?>
                            <?php if ($link_url !== '#'): ?>
                            <a href="<?= esc_url($link_url) ?>" class="banner-slide-link">
                                <img src="<?= $slide['url'] ?>" data-src="" alt="<?= $slide['name'] ?>" height="767"
                                     width="767">
                            </a>
                            <?php else: ?>
                            <img src="<?= $slide['url'] ?>" data-src="" alt="<?= $slide['name'] ?>" height="767"
                                 width="767">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="mb-0-64"></div>

    <div class="mobile-navigation bg-gray-gradient">
        <div class="pt-64-40"></div>
        <div class="container-fluid">
            <div class="rowFlex mobile-navigation-block">
                <div class="col-xxs-6 col-sm-4 colFlex">
                    <div class="mobile-navigation-item">
                        <div class="title">
                            <a href="<?php the_permalink(47); ?>"><?php
                                if (LOCALE == 'ru') {
                                    echo 'врачи';
                                } else if (LOCALE == 'ua') {
                                    echo 'лікарі';
                                } else {
                                    echo 'doctors';
                                }
                                ?></a>
                        </div>
                    </div>
                </div>
<!--                <div class="col-xxs-6 col-sm-4 colFlex">-->
<!--                    <div class="mobile-navigation-item">-->
<!--                        <div class="title">-->
<!--                            <a href="--><?php //= get_post_type_archive_link('services') ?><!--">--><?php
//                                if (LOCALE == 'ru') {
//                                    echo 'услуги';
//                                } else if (LOCALE == 'ua') {
//                                    echo 'послуги';
//                                } else {
//                                    echo 'services';
//                                }
//                                ?><!--</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-xxs-6 col-sm-4 colFlex">
                    <div class="mobile-navigation-item">
                        <div class="title">
                            <a href="<?= get_post_type_archive_link('analysis') ?>"><?php
                                if (LOCALE == 'ru') {
                                    echo 'анализы';
                                } else if (LOCALE == 'ua') {
                                    echo 'аналізи';
                                } else {
                                    echo 'analyzes';
                                }
                                ?></a>
                        </div>
                    </div>
                </div>
<!--                <div class="col-xxs-6 col-sm-4 colFlex">-->
<!--                    <div class="mobile-navigation-item">-->
<!--                        <div class="title">-->
<!--                            <a href="--><?php //the_permalink(1099); ?><!--">--><?php
//                                if (LOCALE == 'ru') {
//                                    echo 'цены';
//                                } else if (LOCALE == 'ua') {
//                                    echo 'ціни';
//                                } else {
//                                    echo 'prices';
//                                }
//                                ?><!--</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
        <div class="pb-8"></div>
    </div>

    <div class="about js__section-scroll" id="section-1">
        <div class="container-fluid">

            <div class="rowFlexPad colPadDef mb-88-40">
                <div class="colPad-md-6 colPadDef mb-30">
                    <div class="video-bottom">
                        <!-- Swiper -->
                        <div class="swiper-container video__slider">
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>

                            <div class="swiper-wrapper">
                                <?php
                                $slides = CFS()->get('home_slider', 883);
                                if ($slides) {
                                    foreach ($slides as $slide) {
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="video__slider-item">
                                                <div class="subtitle"><?php if ($slide['home_slider_title_' . LOCALE] != '') {
                                                        echo $slide['home_slider_title_' . LOCALE];
                                                    } else {
                                                        echo $slide['home_slider_title_ua'];
                                                    } ?></div>
                                                <div class="decr">
                                                    <?php if ($slide['home_slider_desc_' . LOCALE] != '') {
                                                        echo $slide['home_slider_desc_' . LOCALE];
                                                    } else {
                                                        echo $slide['home_slider_desc_ua'];
                                                    } ?>
                                                </div>
                                                <?php if ($slide['home_slider_btn_text_ua']) : ?>
                                                    <a href="<?php if ($slide['home_slider_btn_url_' . LOCALE] != '') {
                                                        echo $slide['home_slider_btn_url_' . LOCALE];
                                                    } else {
                                                        echo $slide['home_slider_btn_url_ua'];
                                                    } ?>" class="btn btn-xl">
                                                        <?php
                                                        if ($slide['home_slider_btn_text_' . LOCALE] == '') {
                                                            _e('посмотреть больше', 'mz');
                                                        }
                                                        ?>
                                                        <?php if ($slide['home_slider_btn_text_' . LOCALE] != '') {
                                                            echo $slide['home_slider_btn_text_' . LOCALE];
                                                        } else {
                                                            echo $slide['home_slider_btn_text_ua'];
                                                        } ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <!-- Add Arrows -->
                            <div class="swiper-button-wrap">
                                <div class="swiper-button-next">
                                    <svg class="svg-sprite-icon icon-arrow">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#arrow"></use>
                                    </svg>
                                </div>
                                <div class="swiper-button-prev">
                                    <svg class="svg-sprite-icon icon-arrow">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#arrow"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="colPad-md-6 colPadDef">
                    <div class="green-card">
                        <div class="green-card__img">
                            <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/b-cross.svg"
                                 alt="b-cross.svg">
                        </div>
                        <div class="green-card__title subtitle"><?php the_field('check_up_title', $homeId); ?></div>
                        <div class="green-card__content decr"><?php the_field('check_up_content', $homeId); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('core/inc/components/about-us'); ?>
    </div>

    <section class="directions js__section-scroll" id="section-2">
        <div class="container-fluid">
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <p><?php _e('Основные направления', 'mz') ?></p>
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
            <div class="rowFlex">
                <div class="col-md-4 colFlex">
                    <div class="directions__item">
                        <div class="directions__item-left">
                            <a class="directions__item-img" href="/doc">
                                <img src="<?php echo get_the_post_thumbnail_url(47); ?>"
                                     alt="<?= get_the_title(47); ?>">
                            </a>
                        </div>
                        <div class="directions__item-right">
                            <div class="directions__item-title">
                                <?php _e('Врачи', 'mz') ?>
                            </div>
                            <div class="directions__item-decr">
                                <?php echo strip_tags(apply_filters('the_content', get_the_excerpt(47))); ?>
                            </div>
                            <a href="/doc" class="link-bubbles"><?php _e('Все врачи', 'mz') ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 colFlex">
                    <div class="directions__item">
                        <div class="directions__item-left">
                            <a class="directions__item-img" href="/uslugi">
                                <img src="<?php echo get_the_post_thumbnail_url(786); ?>"
                                     alt="<?= get_the_title(786); ?>">
                            </a>
                        </div>
                        <div class="directions__item-right">
                            <div class="directions__item-title">
                                <?php _e('Услуги', 'mz') ?>
                            </div>
                            <div class="directions__item-decr">
                                <?php echo strip_tags(apply_filters('the_content', get_the_excerpt(786))); ?>
                            </div>
                            <a href="/uslugi" class="link-bubbles"><?php _e('Все услуги', 'mz') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 colFlex">
                    <div class="directions__item">
                        <div class="directions__item-left">
                            <a class="directions__item-img" href="/analizy">
                                <img src="<?php echo get_the_post_thumbnail_url(772); ?>"
                                     alt="<?= get_the_title(772); ?>">
                            </a>
                        </div>
                        <div class="directions__item-right">
                            <div class="directions__item-title">
                                <?php _e('Анализы', 'mz') ?>
                            </div>
                            <div class="directions__item-decr">
                                <?php echo strip_tags(apply_filters('the_content', get_the_excerpt(772))); ?>
                            </div>
                            <a href="<?= get_post_type_archive_link('analysis') ?>"
                               class="link-bubbles"><?php _e('Все анализы', 'mz') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-btn mb-88-40 justify-center">
                <a class="btn btn-t" data-fancybox="" data-src="#call-back"
                   href="javascript:;"><?php _e('перезвоните мне', 'mz') ?></a>
            </div>
        </div>
    </section>

<!--    <div class="advantages js__section-scroll" id="section-3">-->
<!--        <div class="container-100">-->
<!--            --><?php
//            $specials = get_posts(['post_type' => 'specials', 'numberposts' => 1]);
//
//            if ($specials) {
//                foreach ($specials as $special) {
//                    $linkFormHomeToPage = get_field('from_home_to_page', $special->ID)
//                    ?>
<!--                    <div class="advantages-row">-->
<!--                        <div class="advantages-item-img wow">-->
<!--                            <img class="advantages__img" src="--><?php //echo get_the_post_thumbnail_url($special->ID); ?><!--"-->
<!--                                 alt="--><?php //echo $special->post_title; ?><!--">-->
<!--                        </div>-->
<!--                        <div class="advantages-item-text wow">-->
<!--                            <div class="title">--><?php //echo $special->post_title; ?><!--</div>-->
<!--                            <div class="decr">-->
<!--                                --><?php //echo apply_filters('the_content', $special->post_excerpt); ?>
<!--                            </div>-->
<!--                            --><?php //if ($linkFormHomeToPage): ?>
<!--                                <a href="--><?php //= $linkFormHomeToPage ?><!--" target="_blank"-->
<!--                                   class="link-bubbles">--><?php //_e('подробнее', 'mz') ?><!--</a>-->
<!--                            --><?php //else: ?>
<!--                                <a href="/specials/--><?php //echo $special->post_name; ?><!--"-->
<!--                                   class="link-bubbles">--><?php //_e('подробнее', 'mz') ?><!--</a>-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                    --><?php
//                }
//            }
//            wp_reset_postdata();
//            ?>
<!---->
<!--            --><?php
//            $equipments = get_posts(['post_type' => 'equipment', 'numberposts' => 1]);
//            if ($equipments) {
//                foreach ($equipments as $equipment) {
//                    $linkFormHomeToPage = get_field('from_home_to_page', $equipment->ID)
//                    ?>
<!--                    <div class="advantages-row js__section-scroll">-->
<!--                        <div class="advantages-item-text wow">-->
<!--                            <div class="title">--><?php //echo $equipment->post_title; ?><!--</div>-->
<!--                            <div class="decr">--><?php //echo apply_filters('the_content', $equipment->post_excerpt); ?><!--</div>-->
<!--                            --><?php //if ($linkFormHomeToPage): ?>
<!--                                <a href="--><?php //= $linkFormHomeToPage ?><!--" target="_blank"-->
<!--                                   class="link-bubbles">--><?php //_e('подробнее', 'mz') ?><!--</a>-->
<!--                            --><?php //else: ?>
<!--                                <a href="--><?php //the_permalink($equipment->ID) ?><!--"-->
<!--                                   class="link-bubbles">--><?php //_e('подробнее', 'mz') ?><!--</a>-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->
<!--                        <div class="advantages-item-img wow">-->
<!--                            <img class="advantages__img" src="--><?php //echo get_the_post_thumbnail_url($equipment->ID); ?><!--"-->
<!--                                 alt="--><?php //echo $equipment->post_title; ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    --><?php
//                }
//            }
//            wp_reset_postdata();
//            ?>
<!---->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="special-offers" id="section-4">-->
<!--        --><?php //get_template_part('core/inc/special-section') ?>
<!--        <div class="mb-48-30"></div>-->
<!--        <div class="text-center mb-88-40">-->
<!--            <a href="--><?php //echo get_post_type_archive_link('specials'); ?><!--"-->
<!--               class="link-bubbles">--><?php //_e('посмотреть больше', 'mz') ?><!--</a>-->
<!--        </div>-->
<!--    </div>-->

<!--    <section class="comment js__section-scroll bg-gray pt-48-88" id="section-5">-->
<!--        <div class="container-fluid">-->
<!--            <div class="title wow" data-wow-delay="5s">-->
<!--                <div class="title-wrap">-->
<!--                    --><?php //_e('Отзывы', 'mz') ?>
<!--                </div>-->
<!--                <div class="title-decor">-->
<!--                    <svg width="70" height="20" viewBox="0 0 70 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                        <defs>-->
<!--                            <linearGradient id="strokeGradient" x1="0" y1="0" x2="70" y2="0" gradientUnits="userSpaceOnUse">-->
<!--                                <stop offset="0%" stop-color="#04B8FE"></stop>-->
<!--                                <stop offset="100%" stop-color="#00DBA1"></stop>-->
<!--                            </linearGradient>-->
<!--                        </defs>-->
<!---->
<!--                        <path d="M0 10H28L33 5L38 14L43 9H70" stroke="url(#strokeGradient)" stroke-width="2"></path>-->
<!---->
<!--                        <path d="M0 8H28L33 3L38 12L43 7H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.6"></path>-->
<!--                        <path d="M0 12H28L33 7L38 16L43 11H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.4"></path>-->
<!--                    </svg>-->
<!--                </div>-->
<!--            </div>-->
            <!-- Swiper -->
<!--            <div class="swiper-container comment-slider">-->
<!--                <div class="swiper-wrapper">-->
<!--                    --><?php //if (get_field('home_comment', $homeId)): ?>
<!--                        --><?php //while (the_repeater_field('home_comment', $homeId)): ?>
<!--                            <div class="swiper-slide">-->
<!--                                <div class="comment-item">-->
<!--                                    <div class="decr">-->
<!--                                        --><?php //the_sub_field('comment'); ?>
<!--                                    </div>-->
<!--                                    <div class="text-bold">-->
<!--                                        --><?php //the_sub_field('name'); ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        --><?php //endwhile; ?>
<!--                    --><?php //endif; ?>
<!--                </div>-->
<!--                <div class="comment-bottom">-->
<!--                    <div class="nav-slider">-->
                        <!-- Add Arrows -->
<!--                        <div class="swiper-button-next">-->
<!--                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none"-->
<!--                                 xmlns="http://www.w3.org/2000/svg">-->
<!--                                <path d="M7 1L1 7L7 13" stroke="#90A8BE" stroke-width="2" stroke-linecap="round"-->
<!--                                      stroke-linejoin="round"/>-->
<!--                            </svg>-->
<!--                        </div>-->
<!---->
                        <!-- Add Pagination -->
<!--                        <div class="swiper-pagination"></div>-->
<!---->
                        <!-- Add Arrows -->
<!--                        <div class="swiper-button-prev">-->
<!--                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none"-->
<!--                                 xmlns="http://www.w3.org/2000/svg">-->
<!--                                <path d="M1 13L7 7L0.999999 1" stroke="#90A8BE" stroke-width="2" stroke-linecap="round"-->
<!--                                      stroke-linejoin="round"/>-->
<!--                            </svg>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="mb-48-30"></div>-->
<!--                <div class="text-center mb-88-40">-->
<!--                    <a href='--><?php //echo get_post_type_archive_link('reviews') ?><!--'-->
<!--                       class="link-bubbles">--><?php //_e('все отзывы', 'mz') ?><!--</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

    <div class="about js__section-scroll" id="section-3">
        <div class="container-fluid all-text">
            <h4><?php echo CFS()->get( 'seo3_text_title_ua', 1976 ); ?></h4>

            <div class="all-text-column">
                <?php echo CFS()->get( 'seo3_text_ua', 1976 ); ?>
            </div>
        </div>
    </div>


</main>


<?php get_footer(); ?>
