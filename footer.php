<?php
if (is_home() || is_front_page()) {
    ?>
    <div class="bg-gray text-right up-content">
        <button class="btn-ul">
            <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d)">
                    <circle cx="36" cy="36" r="24" fill="#F4F4F4" />
                </g>
                <path d="M36 43L36 29" stroke="#90A8BE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M30 35L36 29L42 35" stroke="#90A8BE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <defs>
                    <filter id="filter0_d" x="0" y="0" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                        <feOffset />
                        <feGaussianBlur stdDeviation="6" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0.439216 0 0 0 0 0.494118 0 0 0 0 0.596078 0 0 0 0.4 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                    </filter>
                </defs>
            </svg>
        </button>
    </div>
<?php } ?>
<?php
$contacts = pods('header_contacts');
?>
<div class="overlay_new_sc" style="display:none;"></div>
<div class="show_mobiles_modal_tel" style="display:none;">
    <span class="closed_modals_telephones"></span>
    <ul>
        <?php if ( $contacts->field( 'header_phone_2' ) ): ?>
            <li>
                <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_2' )) ?>" class="">
                    <?php echo $contacts->field( 'header_phone_2' ); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ( $contacts->field( 'header_phone_3' ) ): ?>
            <li>
                <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_3' )) ?>" class="">
                    <?php echo $contacts->field( 'header_phone_3' ); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ( $contacts->field( 'header_phone_4' ) ): ?>
            <li>
                <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_4' )) ?>" class="">
                    <?php echo $contacts->field( 'header_phone_4' ); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ( $contacts->field( 'header_phone_5' ) ): ?>
            <li>
                <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_5' )) ?>" class="">
                    <?php echo $contacts->field( 'header_phone_5' ); ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<?php if(false){ //отключено ?>
    <div class="call-back-tooltip">
        <div class="call-back-tooltip__popap">
            <div class="call-back-list">
                <a href="<?php echo $contacts->field('header_viber'); ?>" class="call-back-item" target="_blank">
                    <div class="call-back-item__img">
                        <img src="<?php echo get_template_directory_uri() . '/core/' ?>/images/general/call-back-icon/viber.svg" alt="viber">
                    </div>
                    <div class="call-back-item__text"><?= 'Viber' ?></div>
                </a>
                <a href="<?php echo $contacts->field('header_telegram'); ?>" class="call-back-item" target="_blank">
                    <div class="call-back-item__img">
                        <img src="<?php echo get_template_directory_uri() . '/core/' ?>/images/general/call-back-icon/telegram.svg" alt="telegram">
                    </div>
                    <div class="call-back-item__text"><?= 'Telegram' ?></div>
                </a>
                <div class="call-back-item js__trigger-jivosite">
                    <div class="call-back-item__img">
                        <img src="<?php echo get_template_directory_uri() . '/core/' ?>/images/general/call-back-icon/chat.svg" alt="telegram">
                    </div>
                    <div class="call-back-item__text"><?php _e('Online чат', 'mz') ?></div>
                </div>
                <div class="call-back-item trigger_tel_sections">
                    <div class="call-back-item__img">
                        <img src="<?php echo get_template_directory_uri() . '/core/' ?>/images/general/call-back-icon/call.svg" alt="telegram">
                    </div>
                    <div class="call-back-item__text"><?php _e('Перезвонить', 'mz') ?></div>
                </div>
            </div>
            <svg width="27" height="10" viewBox="0 0 27 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.5 10L0.942631 0.25L26.0574 0.25L13.5 10Z" fill="#fff" />
            </svg>
        </div>
        <div class="call-back-tooltip__btn">
            <svg class="default-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 12V3C17 2.73478 16.8946 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V17L6 13H16C16.2652 13 16.5196 12.8946 16.7071 12.7071C16.8946 12.5196 17 12.2652 17 12ZM21 6H19V15H6V17C6 17.2652 6.10536 17.5196 6.29289 17.7071C6.48043 17.8946 6.73478 18 7 18H18L22 22V7C22 6.73478 21.8946 6.48043 21.7071 6.29289C21.5196 6.10536 21.2652 6 21 6Z" fill="white" />
            </svg>
            <svg width="24" height="24" class="close-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_231:380)">
                    <path d="M0 0L24 24" stroke="white" stroke-linecap="round" />
                    <path d="M24 0L2.41708e-05 24" stroke="white" stroke-linecap="round" />
                </g>
                <defs>
                    <clipPath id="clip0_231:380">
                        <rect width="24" height="24" fill="white" />
                    </clipPath>
                </defs>
            </svg>

        </div>
    </div>
<?php } ?>

<footer class="footer">
    <div class="container-fluid">
        <div class="footer-grid">
            <div class="footer-grid-item">
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(47);?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'Врачи';
                            } else if (LOCALE == 'ua') {
                                echo 'Лікарі';
                            } else {
                                echo 'Doctors';
                            }
                            ?></a>
                    </li>

                    <?php
                    $specializations = get_categories(['taxonomy' => 'specializations', 'hide_empty' => 0]);

                    if ($specializations) {
                        foreach ($specializations as $specialization) {
                            if(!get_term_meta($specialization->term_id, 'spec_visible_on_site')[0]) continue;
                            ?>
                            <li class="list-nav__item">
                                <a class="list-nav__item-link" href="<?= get_term_link( $specialization->term_id, 'specializations' ); ?>">
                                    <?= $specialization->name ?>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="footer-grid-item">
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?= get_post_type_archive_link( 'analysis' )?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'Анализы';
                            } else if (LOCALE == 'ua') {
                                echo 'Аналізи';
                            } else {
                                echo 'Analyzes';
                            }
                            ?></a>
                    </li>
                    <?php
                    $analysis = get_posts(['post_type' => 'analysis', 'numberposts' => -1,   'orderby' => array( 'title' => 'ASC' )]);

                    if ($analysis) {
                        foreach ($analysis as $analys) {
                            ?>
                            <li class="list-nav__item">

                                <a class="list-nav__item-link" href="<?php the_permalink($analys->ID); ?>">
                                    <?php echo $analys->post_title; ?>
                                </a>

                            </li>
                            <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <div class="footer-grid-item">
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?= get_post_type_archive_link( 'services' )?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'Услуги';
                            } else if (LOCALE == 'ua') {
                                echo 'Послуги';
                            } else {
                                echo 'Services';
                            }
                            ?></a>
                    </li>
                    <?php
                    $services = get_posts(['post_type' => 'services', 'numberposts' => -1]);
                    if ($services) {
                        foreach ($services as $service) {
                            if ($service->ID != 1099) {
                                ?>
                                <li class="list-nav__item">
                                    <a class="list-nav__item-link" href="<?php the_permalink($service->ID); ?>">
                                        <?php echo $service->post_title; ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
<!--                <ul class="list-nav">-->
<!--                    <li class="list-nav__item">-->
<!--                        <a href="--><?php //the_permalink(1099);?><!--" class="list-title">--><?php
//                            if (LOCALE == 'ru') {
//                                echo 'Цены';
//                            } else if (LOCALE == 'ua') {
//                                echo 'Ціни';
//                            } else {
//                                echo 'Prices';
//                            }
//                            ?><!--</a>-->
<!--                    </li>-->
<!--                    <li class="list-nav__item">-->
<!--                        <a href="--><?php //the_permalink(1099);?><!--" class="list-nav__item-link">--><?php
//                            if (LOCALE == 'ru') {
//                                echo 'Стоимость услуг';
//                            } else if (LOCALE == 'ua') {
//                                echo 'Вартість послуг';
//                            } else {
//                                echo 'Service cost';
//                            }
//                            ?><!--</a>-->
<!--                    </li>-->
<!--                    <li class="list-nav__item">-->
<!--                        <a href="--><?php //= get_post_type_archive_link( 'specials' )?><!--" class="list-nav__item-link">--><?php
//                            if (LOCALE == 'ru') {
//                                echo 'Акции, спец. предложения';
//                            } else if (LOCALE == 'ua') {
//                                echo 'Акції, спец. пропозиції';
//                            } else {
//                                echo 'Promotions, special offers';
//                            }
//                            ?>
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
            </div>
            <div class="footer-grid-item">
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(526);?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'О Клинике';
                            } else if (LOCALE == 'ua') {
                                echo 'Про клініку';
                            } else {
                                echo 'About the center';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(531)?>" class="list-nav__item-link"><?php
                            if (LOCALE == 'ru') {
                                echo 'О нас';
                            } else if (LOCALE == 'ua') {
                                echo 'Про нас';
                            } else {
                                echo 'About us';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?= get_post_type_archive_link( 'equipment' )?>" class="list-nav__item-link"><?php
                            if (LOCALE == 'ru') {
                                echo 'Оборудование';
                            } else if (LOCALE == 'ua') {
                                echo 'Обладнання';
                            } else {
                                echo 'Equipment';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?= get_post_type_archive_link( 'reviews' )?>" class="list-nav__item-link"><?php
                            if (LOCALE == 'ru') {
                                echo 'Отзывы';
                            } else if (LOCALE == 'ua') {
                                echo 'Відгуки';
                            } else {
                                echo 'Reviews';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?= get_post_type_archive_link( 'jobs' )?>" class="list-nav__item-link"><?php
                            if (LOCALE == 'ru') {
                                echo 'Вакансии';
                            } else if (LOCALE == 'ua') {
                                echo 'Вакансії';
                            } else {
                                echo 'Jobs';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(639)?>" class="list-nav__item-link"><?php
                            if (LOCALE == 'ru') {
                                echo 'Лаборатория';
                            } else if (LOCALE == 'ua') {
                                echo 'Лабораторія';
                            } else {
                                echo 'Laboratory';
                            }
                            ?></a>
                    </li>
                </ul>
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?php echo get_the_permalink(323) ?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'Блог';
                            } else if (LOCALE == 'ua') {
                                echo 'Блог';
                            } else {
                                echo 'Blog';
                            }
                            ?></a>
                    </li>

                    <?php
                    $blog_menu = get_categories(['taxonomy' => 'blog', 'hide_empty' => 0]);
                    if ($blog_menu) {
                        foreach ($blog_menu as $menu) {
                            ?>
                            <li class="list-nav__item">
                                <a class="list-nav__item-link" href="<?= esc_url(get_category_link($menu->term_id)); ?>">
                                    <?= esc_html($menu->name); ?>
                                </a>
                            </li>
                        <?php }
                    }
                    ?>
                </ul>
                <ul class="list-nav">
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(693)?>" class="list-title"><?php
                            if (LOCALE == 'ru') {
                                echo 'Контакты';
                            } else if (LOCALE == 'ua') {
                                echo 'Контакти';
                            } else {
                                echo 'Contacts';
                            }
                            ?></a>
                    </li>
                    <li class="list-nav__item">
                        <a href="<?php the_permalink(714)?>" class="list-nav__item-link"><?php
                            echo get_the_title(714);
                            ?></a>
                    </li>
                </ul>
            </div>
            <div class="footer-grid-item footer-grid-item-mob">

                <div class="footer-list-shared">
                    <span class="footer-list-shared-span"><?php
                        if (LOCALE == 'ru') {
                            echo 'Мы в соцсетях';
                        } else if (LOCALE == 'ua') {
                            echo 'Ми в соцмережах';
                        }
                        ?></span>
                    <div class="list-shared">
                        <?php
                        $contacts = pods('header_contacts');
                        ?>
                        <?php if($contacts->field('header_facebook')){ ?>
                            <a target="_blank" href="<?php echo $contacts->field('header_facebook'); ?>" class="list-shared__item__link">
                                <svg class="svg-sprite-icon icon-fb">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#fb"></use>
                                </svg>
                            </a>
                        <?php } ?>
                        <?php if($contacts->field('header_instagram')){ ?>
                            <a target="_blank" href="<?php echo $contacts->field('header_instagram'); ?>" class="list-shared__item__link">
                                <svg class="svg-sprite-icon icon-instagram" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5981 2H16.9981C20.1981 2 22.7981 4.6 22.7981 7.8V16.2C22.7981 17.7383 22.187 19.2135 21.0993 20.3012C20.0116 21.3889 18.5364 22 16.9981 22H8.5981C5.3981 22 2.7981 19.4 2.7981 16.2V7.8C2.7981 6.26174 3.40917 4.78649 4.49688 3.69878C5.58459 2.61107 7.05984 2 8.5981 2ZM18.0481 5.5C18.3796 5.5 18.6976 5.6317 18.932 5.86612C19.1664 6.10054 19.2981 6.41848 19.2981 6.75C19.2981 7.08152 19.1664 7.39946 18.932 7.63388C18.6976 7.8683 18.3796 8 18.0481 8C17.7166 8 17.3986 7.8683 17.1642 7.63388C16.9298 7.39946 16.7981 7.08152 16.7981 6.75C16.7981 6.41848 16.9298 6.10054 17.1642 5.86612C17.3986 5.6317 17.7166 5.5 18.0481 5.5ZM12.7981 7C14.1242 7 15.3959 7.52678 16.3336 8.46447C17.2713 9.40215 17.7981 10.6739 17.7981 12C17.7981 13.3261 17.2713 14.5979 16.3336 15.5355C15.3959 16.4732 14.1242 17 12.7981 17C11.472 17 10.2002 16.4732 9.26256 15.5355C8.32488 14.5979 7.7981 13.3261 7.7981 12C7.7981 10.6739 8.32488 9.40215 9.26256 8.46447C10.2002 7.52678 11.472 7 12.7981 7ZM12.7981 9C12.0024 9 11.2394 9.31607 10.6768 9.87868C10.1142 10.4413 9.7981 11.2044 9.7981 12C9.7981 12.7956 10.1142 13.5587 10.6768 14.1213C11.2394 14.6839 12.0024 15 12.7981 15C13.5937 15 14.3568 14.6839 14.9194 14.1213C15.482 13.5587 15.7981 12.7956 15.7981 12C15.7981 11.2044 15.482 10.4413 14.9194 9.87868C14.3568 9.31607 13.5937 9 12.7981 9Z" fill="#707E98" />
                                    <circle cx="18.2981" cy="6.5" r="1.5" fill="#25282B" />
                                    <circle cx="12.7981" cy="12" r="5" fill="#25282B" />
                                    <circle cx="12.7981" cy="12" r="3" fill="#707E98" />
                                </svg>
                            </a>
                        <?php } ?>
                        <?php if($contacts->field('header_youtube')){ ?>
                            <a target="_blank" href="<?php echo $contacts->field('header_youtube'); ?>" class="list-shared__item__link">
                                <svg class="svg-sprite-icon icon-youtube" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 20H7C4 20 2 18 2 15V9C2 6 4 4 7 4H17C20 4 22 6 22 9V15C22 18 20 20 17 20Z" fill="#707E98"/>
                                    <path d="M11.4 9.5L13.9 11C14.8 11.6 14.8 12.5 13.9 13.1L11.4 14.6C10.4 15.2 9.59998 14.7 9.59998 13.6V10.6C9.59998 9.3 10.4 8.9 11.4 9.5Z" stroke="#25282B" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php } ?>



                        <?php if(false){ ?>
                            <a target="_blank" href="<?php echo $contacts->field('header_telegram'); ?>" class="list-shared__item__link">
                                <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.8472 18.987L13.5151 23.6404C13.9878 23.6404 14.1949 23.4372 14.441 23.1911L16.66 21.0695L21.2582 24.4374C22.1021 24.9063 22.6959 24.6601 22.9225 23.6599L25.9424 9.51216C26.2119 8.26969 25.4931 7.7813 24.6727 8.08996L6.92837 14.8845C5.71729 15.3533 5.73682 16.0293 6.72132 16.334L11.257 17.7445L21.7934 11.1493C22.2896 10.8211 22.7389 11.0008 22.3677 11.3329L13.8472 18.987Z" fill="#707E98" />
                                </svg>
                            </a>
                            <a target="_blank" href="<?php echo $contacts->field('header_viber'); ?>" class="list-shared__item__link">
                                <svg width="20" height="23" viewBox="0 0 20 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.2196 0H7.77609C3.48883 0 0 3.48958 0 7.77778V11.1111C0 14.1233 1.73573 16.8576 4.44348 18.1424V21.8533C4.44348 22.1745 4.84704 22.3438 5.07702 22.1137L8.30115 18.8889H12.2239C16.5112 18.8889 20 15.3993 20 11.1111V7.77778C20 3.48958 16.5112 0 12.2196 0ZM10.7399 5.55556C10.6314 5.55556 10.5186 5.56424 10.4101 5.57292C10.2061 5.59462 10.0239 5.44705 10.0022 5.2474C9.98047 5.0434 10.128 4.86111 10.3276 4.83941C10.4621 4.82639 10.601 4.81771 10.7399 4.81771C12.7837 4.81771 14.4413 6.48004 14.4413 8.51997C14.4413 8.65885 14.4326 8.7934 14.4196 8.93229C14.3979 9.13194 14.2113 9.28385 14.0117 9.26215C13.8121 9.24045 13.6646 9.05382 13.6863 8.85417C13.6993 8.74566 13.7036 8.63281 13.7036 8.52431C13.7036 6.88368 12.3714 5.55556 10.7399 5.55556ZM12.9616 8.51997C12.9616 8.72396 12.7924 8.88889 12.5928 8.88889C12.3931 8.88889 12.2239 8.71962 12.2239 8.51997C12.2239 7.70399 11.56 7.03993 10.7442 7.03993C10.5402 7.03993 10.3754 6.875 10.3754 6.67101C10.3754 6.46701 10.5402 6.30208 10.7442 6.30208C11.9636 6.29774 12.9616 7.29167 12.9616 8.51997ZM15.5869 13.954C15.4784 14.4314 15.2397 14.8655 14.8926 15.2127C14.4196 15.6858 13.7774 15.9288 13.0093 15.9288C12.8054 15.9288 12.5884 15.9115 12.3671 15.8767C10.5967 15.599 8.13192 14.7309 6.52636 13.1293L6.50466 13.1076C4.90345 11.5017 4.03558 9.03646 3.75787 7.26562C3.59297 6.21094 3.82296 5.33854 4.42178 4.73958C4.76893 4.39236 5.20286 4.15365 5.68019 4.04514C5.72792 4.03212 5.78 4.03212 5.82773 4.0408L7.63289 4.375C7.78043 4.40104 7.89759 4.51823 7.92797 4.6658L8.45303 7.28299C8.47906 7.40451 8.44001 7.53038 8.35322 7.61719L7.29442 8.67622C8.17097 10.5469 9.16468 11.5451 10.9568 12.3481L12.02 11.2847C12.1067 11.1979 12.2326 11.1589 12.3541 11.1849L14.975 11.7101C15.1226 11.7405 15.2397 11.8576 15.2658 12.0052L15.5999 13.8108C15.5999 13.8542 15.5999 13.9063 15.5869 13.954ZM15.7865 9.71788C15.7388 9.91753 15.5261 10.0434 15.3265 9.99132C15.1356 9.93924 15.0184 9.73958 15.0662 9.54861C15.1443 9.21441 15.1833 8.86719 15.1833 8.52431C15.1833 6.07205 13.1916 4.07986 10.7399 4.07986C10.627 4.07986 10.5099 4.0842 10.397 4.09288C10.1931 4.1059 10.0152 3.95399 9.99783 3.75C9.98047 3.54601 10.1367 3.36806 10.3406 3.35069C10.4708 3.34201 10.6053 3.33767 10.7399 3.33767C13.5995 3.33767 15.9254 5.66406 15.9254 8.52431C15.9254 8.92361 15.8776 9.32726 15.7865 9.71788Z" fill="#707E98" />
                                </svg>

                            </a>
                        <?php } ?>
                    </div>
                </div>


                <span class="link"><?php
                    if (LOCALE == 'ru') {
                        //echo 'Лицензия МОЗ Украины АГ №600177 от 24.05.2012';
                    } else if (LOCALE == 'ua') {
                        //echo 'Ліцензія МОЗ України АГ №600177 від 24.05.2012';
                    }
                    ?> </span>

                <a href="<?php the_permalink(1011)?>" class="link-bold"><?php echo get_the_title(1011); ?></a>
                <p>
                    <?php
                    if (LOCALE == 'ru') {
                        echo 'МЕДІСТАР-А';
                    } else if (LOCALE == 'ua') {
                        echo 'МЕДІСТАР-А';
                    }
                    ?> © <?php echo date('Y') ?>.
                </p>

                <a href="https://www.koda-ltd.com/" class="copy" target="_blank">created by Koda <?php echo date('Y') ?></a>
                <a href="https://compas.agency/" class="copy" target="_blank"><?php
                    if (LOCALE == 'ru') {
                    echo 'продвижение сайта Compas Agency';
                    } else if (LOCALE == 'ua') {
                    echo 'просування сайту Compas Agency';
                    }
                    ?></a>
            </div>
        </div>
    </div>

</footer>


<?php get_template_part('core/inc/call_back') ?>
<?php get_template_part('core/inc/check_up_modal') ?>
<?php get_template_part('core/cabinet/view/modals/modals') ?>

<div class="modal" id="modal-done">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/heart-done.svg" alt="heart-done.svg">
    </div>
    <div class="modal__text">
        Ваш запрос в обработке. <br>
        Наши менеджеры перезвонят вам в течении 30 мин.
    </div>
</div>

<div class="modal" id="modal-error">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/heart-error.svg" alt="heart-error.svg">
    </div>
    <div class="modal__text">
        Что-то пошло не так((( <br>
        Проверьте, что вы заполнили <br> все поля и повторите, пожалуйста, действие
    </div>
</div>

<div class="modal" id="modal-done-review">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/heart-done.svg" alt="heart-done.svg">
    </div>
    <div class="modal__text">
        Ваш отзыв успешно отправлен в обработку
    </div>
</div>

<div class="modal" id="modal-error-review">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/heart-error.svg" alt="heart-error.svg">
    </div>
    <div class="modal__text">
        Что-то пошло не так((( <br>
        Проверьте, что вы заполнили <br> все обязательные поля <br> и повторите, пожалуйста, действие
    </div>
</div>

<div class="modal" id="modal-error-size-file">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/heart-error.svg" alt="heart-error.svg">
    </div>
    <div class="modal__text">
        Файл превышает 5 мб(((
    </div>
</div>

<div class="modal modal-lg" id="schedule-modal" style="display: none;">
    <form class="form-modal" id="form-send-request">
        <div class="modal__img">
            <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-1.svg" alt="v-1.svg">
        </div>

        <div class="modal__subtitle">
            <a href="#" class="link" id="link-to-doctor" onclick="iAmFirstButton();"><?php _e('Я впервые', 'mz') ?>!</a>
        </div>

        <label class="input-form">Телефон*
            <input type="tel" name="PhoneNumber" placeholder="+38 (___) __ __ ___" required="">
        </label>

        <label class="input-form">Дата рождения*
            <input type="date" name="birthDate" value="" required="">
        </label>

        <label class="input-form">Email
            <input type="text" name="Email">
        </label>

        <label class="textarea-form">Комментарий
            <textarea name="Comment"></textarea>
        </label>
        <span class="modal__text-small">* поля обязательные для заполнения</span>

        <input type="hidden" name="SpecialityId" value="">
        <input type="hidden" name="PhysicianId" value="">
        <input type="hidden" name="EmpId" value="">
        <input type="hidden" name="EventId" value="">
        <!--возможно будет захардкодено в бэкенде. надо смотреть какие данные приходят с апи-->
        <input type="hidden" name="EventDuration" value="">
        <!--возможно будет захардкодено в бэкенде. надо смотреть какие данные приходят с апи-->
        <input type="hidden" name="SelectedDateTime" value="">
        <input type="hidden" name="ReservationType" value="">
        <!--mobile or desktop «W» «M»-->

        <span class="error-msg" style="color:#FF0000;margin-bottom: 10px;display: inline-block;"></span>

        <div class="indicator preloader-modal-send" style="display: none;margin:0px auto 10px auto; text-align: center;">
            <svg width="16px" height="12px">
                <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
            </svg>
        </div>

        <button class="btn" id="send-reserv-button">отправить</button>
    </form>
</div>

<div class="modal modal-lg" id="feedBack-modal">
    <form class="form-default">
        <div class="med-call-pop-der">Написать отзыв:</div>
        <label class="input-form">Имя*
            <input type="text" name="name" required="">
        </label>

        <label class="input-form">Телефон*
            <input type="tel" name="schedule-data" placeholder="+38 (___) __ __ ___" required="">
        </label>

        <label class="input-form">Email
            <input type="email" name="schedule-email" placeholder="test_test@mail.com" required="">
        </label>

        <label class="textarea-form">Отзыв
            <textarea></textarea>
        </label>
        <div class="text-center">
            <button type="submit" class="btn">отправить</button>
        </div>
    </form>
</div>


<div class="modal" id="schedule-modal-2" style="display: none;">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-2.svg" alt="v-2.svg">
    </div>
    <div class="modal__text">
        Вы записались на приём к врачу.
    </div>
</div>

<div class="modal" id="schedule-modal-3">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-3.svg" alt="v-3.svg">
    </div>
    <div class="modal__text">
        Что-то пошло не так((( <br>
        Повторите, пожалуйста, действие
    </div>
</div>

<div class="modal" id="test-covid-success">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-1.svg" alt="v-1.svg">
    </div>
    <div class="modal__text">

        <?php
        if (LOCALE == 'ru') {
            echo 'Спасибо за ваше обращение!';
        } else if (LOCALE == 'ua') {
            echo 'Дякую за ваше звернення!';
        }
        ?>
        <br>
        <?php
        if (LOCALE == 'ru') {
            echo 'Для уточнения информации мы вам перезвоним.';
        } else if (LOCALE == 'ua') {
            echo 'Для уточнення інформації ми вам зателефонуємо.';
        }
        ?>



    </div>
</div>


<div class="modal" id="schedule-modal-4" style="display: none;">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-4.svg" alt="v-4.svg">
    </div>
    <form class="form-modal" id="send-sms-form">
        <label class="input-form">Введите код для подтверждения*
            <input type="text" name="SMSkod" placeholder="код __________" required="">
        </label>
	    <input type="hidden" name="modalDocName" value="">
	    <input type="hidden" name="modalDocProf" value="">
	    <input type="hidden" name="modalDocDateTime" value="">

	    <input type="hidden" name="cancel_speciality_id" value="">
	    <input type="hidden" name="cancel_api_id" value="">
	    <input type="hidden" name="cancel_emp_id" value="">
	    <input type="hidden" name="cancel_appointment_id" value="">
	    <input type="hidden" name="cancel_appointment_date" value="">

        <span class="error-msg-sms" style="color:#FF0000;margin-bottom: 10px;display: inline-block;"></span>
	    <div class="indicator preloader-modal-send" style="display: none;margin:0px auto 10px auto; text-align: center;">
		    <svg width="16px" height="12px">
			    <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
			    <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
		    </svg>
	    </div>

        <button class="btn" id="send-sms-button">отправить</button>
    </form>
</div>

<div class="modal" id="schedule-modal-5" style="display: none;">
    <div class="modal__img">
        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-5.svg" alt="v-5.svg">
    </div>
    <ul class="dock-list">
        <li class="dock-list__item">
            <b id="modal-doc-name"></b>
        </li>
        <li class="dock-list__item" id="modal-doc-prof"></li>
    </ul>
    <ul class="dock-list-data">
        <li id="modal-doc-date-time"></li>
    </ul>
</div>

<div class="modal modal-lg" id="covid-test-modal" style="display: none;">
    <form class="form-modal" id="form-send-request2">
        <div class="modal__img">
            <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/v-1.svg" alt="v-1.svg">
        </div>

        <label class="input-form">Телефон*
            <input type="tel" name="PhoneNumber" placeholder="+38 (___) __ __ ___" required="" id="covid-test-phone">
        </label>

        <label class="input-form">Дата прохождения теста*
            <input type="date" name="birthDate" id="covid-test-date" value="" required="">
        </label>

        <label class="input-form">Email
            <input type="text" name="Email" id="covid-test-email">
        </label>

        <label class="textarea-form">Комментарий
            <textarea name="Comment" id="covid-test-comment"></textarea>
        </label>
        <span class="modal__text-small" style="margin-bottom: 0 !important;">* поля обязательные для заполнения</span>


        <span class="error-msg" id="covid-test-error-msg" style="color:#FF0000;margin-bottom: 10px;display: inline-block;"></span>

        <div class="indicator preloader-modal-send" style="display: none;margin:0px auto 10px auto; text-align: center;">
            <svg width="16px" height="12px">
                <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
            </svg>
        </div>

        <button class="btn" type="button" id="send-covid-test">отправить запрос</button>
    </form>
</div>

<div class="modal modal-lg" id="check-city-modal">
    <div class="med-call-pop-der"><?php
        if ( LOCALE == 'ru' ) {
            echo 'Ваш город Хмельницкий?';
        } else if ( LOCALE == 'ua' ) {
            echo 'Ваше місто Хмельницький?';
        } else {
            echo 'Your city is Poltava?';
        }
        ?></div>
    <div class="text-center">
        <button class="btn js__medChangeCityByIp-trigger"><?php
            if ( LOCALE == 'ru' ) {
                echo 'Нет';
            } else if ( LOCALE == 'ua' ) {
                echo 'Ні';
            } else {
                echo 'No';
            }
            ?></button>
        <button class="btn change-city" data-gd="pl"><?php
            if ( LOCALE == 'ru' ) {
                echo 'Да';
            } else if ( LOCALE == 'ua' ) {
                echo 'Так';
            } else {
                echo 'Yes';
            }
            ?></button>
    </div>
</div>

<?php wp_footer(); ?>
<script>
    $('#ajaxsearchlite1 .orig').focus(function() {
        $('#ajaxsearchlite1').addClass('active');
    });

    $('#ajaxsearchlite1 .orig').focusout(function() {
        $('#ajaxsearchlite1').removeClass('active');
    });

    function iAmFirstButton() {
        if (document.location.href.indexOf('schedule') == -1) {
            $.fancybox.close();
            $.fancybox.open({
                src: '#sign-up-modal',
                type: 'inline'
            });
        }
    }
</script>

<?php
global $wp;
if (!in_array($wp->request, ['cabinet', 'cabinet/appointments', 'cabinet/analysis', 'cabinet/patient'])):
	?>



<?php
endif;
wp_reset_query();
?>
<!-- jivosite -->
<!--<script src="//code-ya.jivosite.com/widget/cAs8jCS22k" async></script>-->
<!-- jivosite end -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        /**
         * Simulate a click event.
         * @public
         * @param {Element} elem  the element to simulate a click on
         */
        var simulateClick = function(elem) {
            // Create our event (with options)
            var evt = new MouseEvent('click', {
                bubbles: true,
                cancelable: true,
                view: window
            });
            // If cancelled, don't dispatch our event
            var canceled = !elem.dispatchEvent(evt);
        };

        setTimeout(() => {
            var someLink = document.querySelector('#bingc-phone-button');

            $('.js__trigger-binotel').click(function() {
                simulateClick(someLink);
            });
        }, 2000)

        $('.js__trigger-jivosite').click(function() {
            jivo_api.open();
            $('.call-back-tooltip__btn').trigger('click');
        });

        $(document).click(function(e) {
            var $tgt = $(e.target);
            let lengthTargetEl = $tgt.closest(".call-back-tooltip__popap, .call-back-tooltip__btn").length;
            if (!lengthTargetEl) {
                $('.call-back-tooltip__popap').removeClass('open');
                $('.call-back-tooltip__btn').removeClass('active');
            }
        });


        $('.call-back-tooltip__btn').click(function() {
            $(this).toggleClass('active')
            $('.call-back-tooltip__popap').toggleClass('open');
        });
        $('.trigger_tel_sections').click(function() {
            $('.call-back-tooltip__popap.open').removeClass('open');
            $('.call-back-tooltip__btn.active').removeClass('active');
            $('.overlay_new_sc').fadeIn(100, function() {
                $('.show_mobiles_modal_tel').fadeIn(100);
            })
        });
        $('.closed_modals_telephones, .overlay_new_sc').click(function() {
            $('.show_mobiles_modal_tel').fadeOut(100, function() {
                $('.overlay_new_sc').fadeOut(100);
            })
        });
        $('.current_select_obl').click(function() {
            $('.slide_change_select').slideToggle(100);
        });
    });

</script>

<?php if (is_home() || is_front_page()): ?>

    <!-- <script>
        // Insert the <script> tag targeting the iframe API

        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);



        // Get the video ID passed to the data-video attribute
        const bgVideoID = document.querySelector('.js-background-video').getAttribute('data-video');



        // Set the player options
        const playerOptions = {
            // Autoplay + mute has to be activated (value = 1) if you want to autoplay it everywhere
            // Chrome/Safari/Mobile
            autoplay: 1,
            mute: 1,
            autohide: 1,
            modestbranding: 1,
            rel: 0,
            showinfo: 0,
            controls: 0,
            disablekb: 1,
            enablejsapi: 1,
            iv_load_policy: 3,
            // For looping video you have to have loop to 1
            // And playlist value equal to your currently playing video
            loop: 1,
            playlist: bgVideoID,

        }

        // Get the video overlay, to mask it when the video is loaded
        const videoOverlay = document.querySelector('.js-video-overlay');

        // This function creates an <iframe> (and YouTube player)
        // after the API code downloads.
        let ytPlayer;

        function onYouTubeIframeAPIReady() {
            ytPlayer = new YT.Player('yt-player', {
                width: '1920',
                height: '720',
                videoId: bgVideoID,
                playerVars: playerOptions,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        // The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.playVideo();

            // Get the duration of the currently playing video
            const videoDuration = event.target.getDuration();

            // When the video is playing, compare the total duration
            // To the current passed time if it's below 2 and above 0,
            // Return to the first frame (0) of the video
            // This is needed to avoid the buffering at the end of the video
            // Which displays a black screen + the YouTube loader
            setInterval(function() {
                const videoCurrentTime = event.target.getCurrentTime();
                const timeDifference = videoDuration - videoCurrentTime;

                if (2 > timeDifference > 0) {
                    event.target.seekTo(0);
                }
            }, 1000);
        }

        // When the player is ready and when the video starts playing
        // The state changes to PLAYING and we can remove our overlay
        // This is needed to mask the preloading
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING) {
                videoOverlay.classList.add('video-block__video-overlay--fadeOut');
            }
        }

    </script> -->
<?php endif; ?>

<div style="display:none;">
    <?php echo get_num_queries(); ?> запросов в <?php timer_stop(1); ?> секунд.
</div>
<!-- <script type="text/javascript">
(function(d, w, s) {
    var widgetHash = 'qobf998TjK34ZWrPMS7N', bch = d.createElement(s); bch.type = 'text/javascript'; bch.async = true;
    bch.src = '//widgets.binotel.com/chat/widgets/' + widgetHash + '.js';
    var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(bch, sn);
})(document, window, 'script');
</script> -->
<script type="text/javascript">
  (function(d, w, s) {
    var widgetHash = 'n7frpo7tawcs4b8mb4td', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
    gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
    var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
  })(document, window, 'script');
</script> 
</body>

</html>
