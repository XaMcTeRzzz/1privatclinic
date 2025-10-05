<?php
// Ищем страницу для отображения в выпадающем меню справа
$page = CFS()->get('menu_page_item', 1025)[0];
$menu_page_title = strip_tags(apply_filters('the_content', get_the_title($page)));
$menu_page_desc = strip_tags(apply_filters('the_content', get_the_excerpt($page)));
if ($menu_page_desc == '') {
    $menu_page_desc = strip_tags(apply_filters('the_content', get_the_content($page)));
}
if (strlen($menu_page_desc) > 136) {
    $menu_page_desc = mb_strimwidth($menu_page_desc, 0, 136) . "...";
}
$menu_page_img = get_the_post_thumbnail_url($page);
$menu_page_url = get_post_permalink($page);

$test = false;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:image"
          content="<?php echo get_template_directory_uri() . '/core/' ?>images/general/logo-xs.jpg"/>

    <?php if (is_paged()) { ?>
        <meta name="robots" content="noindex, follow"/>
    <?php } ?>

    <?php wp_head(); ?>

    <style>
        #bingc-phone-button svg.bingc-phone-button-circle circle.bingc-phone-button-circle-inside {
            fill: #95c53d !important;
        }

        #bingc-phone-button:hover svg.bingc-phone-button-circle circle.bingc-phone-button-circle-inside {
            fill: #95c53d !important;
        }

        #bingc-phone-button div.bingc-phone-button-tooltip {
            background: #95c53d !important;
        }

        #bingc-phone-button div.bingc-phone-button-tooltip svg.bingc-phone-button-arrow polyline {
            fill: #95c53d !important;
        }

        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form a.bingc-passive-phone-form-button {
            background: #95c53d !important;
        }

        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form a.bingc-passive-phone-form-button:hover {
            background: #99c744 !important;
        }

        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form div.bingc-passive-get-phone-form-date-selection div.bingc-passive-date-selection-select-hour,
        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form div.bingc-passive-get-phone-form-date-selection div.bingc-passive-date-selection-select-minutes {
            background: #95c53d !important;
        }

        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form div.bingc-passive-get-phone-form-date-selection div.bingc-passive-date-selection-select-hour:hover,
        #bingc-passive div.bingc-passive-overlay div.bingc-passive-content div.bingc-passive-get-phone-form form.bingc-passive-get-phone-form div.bingc-passive-get-phone-form-date-selection div.bingc-passive-date-selection-select-minutes:hover {
            background: #99c744 !important;
        }

        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form a.bingc-active-phone-form-button {
            background: #95c53d !important;
        }

        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form a.bingc-active-phone-form-button:hover {
            background: #99c744 !important;
        }

        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form div.bingc-active-get-phone-form-date-selection div.bingc-active-date-selection-select-hour,
        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form div.bingc-active-get-phone-form-date-selection div.bingc-active-date-selection-select-minutes {
            background: #95c53d !important;
        }

        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form div.bingc-active-get-phone-form-date-selection div.bingc-active-date-selection-select-hour:hover,
        #bingc-active div.bingc-active-overlay div.bingc-active-content div.bingc-active-get-phone-form form.bingc-active-get-phone-form div.bingc-active-get-phone-form-date-selection div.bingc-active-date-selection-select-minutes:hover {
            background: #99c744 !important;
        }

    </style>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WNKWCLGC');</script>
    <!-- End Google Tag Manager -->

    <!--    Ringostat-->
    <script type="text/javascript">
        (function (d, s, u, e, p) {
            p = d.getElementsByTagName(s)[0], e = d.createElement(s), e.async = 1, e.src = u, p.parentNode.insertBefore(e, p);
        })(document, 'script', 'https://script.ringostat.com/v4/f6/f641ca0832df3e29e4482153d199f28eeec288d6.js');
        var pw = function () {
            if (typeof (ringostatAnalytics) === "undefined") {
                setTimeout(pw, 100);
            } else {
                ringostatAnalytics.sendHit('pageview');
            }
        };
        pw();
    </script>
    <!--    End Ringostat-->
</head>

<body <?php if (isset($class)) {
    body_class($class);
} ?>>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WNKWCLGC"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!--    --><?php //body_class( $class ) ?>


<div class="wrapper">

    <header class="header">
        <div class="nav-top">
            <div class="container-fluid">
                <div class="nav-top-row">


                    <div class="nav-top__left">
                        <?php
                        $contacts = pods('header_contacts');
                        ?>
                        <div class="nav-top__cont__left-bottom">
                            <ul class="list-clock js__appendToJs__cloneClock">
                                <li class="list-clock__item cont-header title-desc">
                                    <?php _e('Call-центр', 'mz') ?>:
                                </li>
                                <li class="list-clock__item cont-header desc-desc">
                                    <a href="tel:<?php echo $contacts->field('header_phone'); ?>"><?php echo $contacts->field('header_phone'); ?></a>
                                </li>
                            </ul>
                            <?php if($contacts->field('header_telegram_bot')): ?>
                                <ul class="list-clock js__appendToJs__cloneClock">
                                    <li class="list-clock__item cont-header title-desc">
                                        <?php _e('Написати у Telegram', 'mz') ?>:
                                    </li>
                                    <li class="list-clock__item cont-header desc-desc">
                                        <a href="https://t.me/<?php echo $contacts->field('header_telegram_bot'); ?>" target="_blank">@<?php echo $contacts->field('header_telegram_bot'); ?></a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="nav-top__center">
                        <div class="nav-top__center__logo">
                            <a href="<?php echo get_home_url(); ?>">
                                <img class="no-lazy"
                                     src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/logo-xs.svg"
                                     alt="logo" width="375" height="46">
                            </a>
                        </div>
                    </div>
                    <div class="nav-top__right">
                        <div class="nav-top__cont__right-bottom">
                            <div class="nav-top__cont__left-bottom-row">
                                <span class="cont-header nav-top__cont__left-top-lock js__appendToJs__cloneClock">
                                    <span><?php echo $contacts->field('header_address_' . LOCALE); ?></span>
                                </span>
                            </div>
                        </div>
                        <div class="nav-top__cont__right-bottom">
                            <div class="list-shared">
                                <?php if ($contacts->field('header_facebook')) { ?>
                                    <a target="_blank" href="<?php echo $contacts->field('header_facebook'); ?>"
                                       class="list-shared__item__link">
                                        <svg class="svg-sprite-icon icon-fb">
                                            <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#fb"></use>
                                        </svg>
                                    </a>
                                <?php } ?>
                                <?php if ($contacts->field('header_instagram')) { ?>
                                    <a target="_blank" href="<?php echo $contacts->field('header_instagram'); ?>"
                                       class="list-shared__item__link">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" class="svg-sprite-icon icon-instagram">
                                            <path d="M8.59785 2H16.9979C20.1979 2 22.7979 4.6 22.7979 7.8V16.2C22.7979 17.7383 22.1868 19.2135 21.0991 20.3012C20.0114 21.3889 18.5361 22 16.9979 22H8.59785C5.39785 22 2.79785 19.4 2.79785 16.2V7.8C2.79785 6.26174 3.40892 4.78649 4.49663 3.69878C5.58434 2.61107 7.0596 2 8.59785 2ZM18.0479 5.5C18.3794 5.5 18.6973 5.6317 18.9317 5.86612C19.1662 6.10054 19.2979 6.41848 19.2979 6.75C19.2979 7.08152 19.1662 7.39946 18.9317 7.63388C18.6973 7.8683 18.3794 8 18.0479 8C17.7163 8 17.3984 7.8683 17.164 7.63388C16.9295 7.39946 16.7979 7.08152 16.7979 6.75C16.7979 6.41848 16.9295 6.10054 17.164 5.86612C17.3984 5.6317 17.7163 5.5 18.0479 5.5ZM12.7979 7C14.1239 7 15.3957 7.52678 16.3334 8.46447C17.2711 9.40215 17.7979 10.6739 17.7979 12C17.7979 13.3261 17.2711 14.5979 16.3334 15.5355C15.3957 16.4732 14.1239 17 12.7979 17C11.4718 17 10.2 16.4732 9.26232 15.5355C8.32464 14.5979 7.79785 13.3261 7.79785 12C7.79785 10.6739 8.32464 9.40215 9.26232 8.46447C10.2 7.52678 11.4718 7 12.7979 7ZM12.7979 9C12.0022 9 11.2391 9.31607 10.6765 9.87868C10.1139 10.4413 9.79785 11.2044 9.79785 12C9.79785 12.7956 10.1139 13.5587 10.6765 14.1213C11.2391 14.6839 12.0022 15 12.7979 15C13.5935 15 14.3566 14.6839 14.9192 14.1213C15.4818 13.5587 15.7979 12.7956 15.7979 12C15.7979 11.2044 15.4818 10.4413 14.9192 9.87868C14.3566 9.31607 13.5935 9 12.7979 9Z"
                                                  fill="#707E98"/>
                                            <circle cx="18.2979" cy="6.5" r="1.5" fill="white"/>
                                            <circle cx="12.7979" cy="12" r="5" fill="white"/>
                                            <circle cx="12.7979" cy="12" r="3" fill="#707E98"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                                <?php if ($contacts->field('header_youtube')) { ?>
                                    <a target="_blank" href="<?php echo $contacts->field('header_youtube'); ?>"
                                       class="list-shared__item__link">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" class="svg-sprite-icon icon-youtube">
                                            <path d="M17 20H7C4 20 2 18 2 15V9C2 6 4 4 7 4H17C20 4 22 6 22 9V15C22 18 20 20 17 20Z"
                                                  fill="#707E98"/>
                                            <path d="M11.4 9.5L13.9 11C14.8 11.6 14.8 12.5 13.9 13.1L11.4 14.6C10.4 15.2 9.59998 14.7 9.59998 13.6V10.6C9.59998 9.3 10.4 8.9 11.4 9.5Z"
                                                  stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                                <?php if (false) { //скрыто ?>
                                    <a target="_blank" href="<?php echo $contacts->field('header_telegram'); ?>"
                                       class="list-shared__item__link">
                                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.84717 10.987L7.5151 15.6404C7.98781 15.6404 8.19487 15.4372 8.441 15.1911L10.66 13.0695L15.2582 16.4374C16.1021 16.9063 16.6959 16.6601 16.9225 15.6599L19.9424 1.51216C20.2119 0.269692 19.4931 -0.218701 18.6727 0.0899632L0.928373 6.88448C-0.28271 7.35334 -0.263176 8.02927 0.721317 8.33403L5.25702 9.74451L15.7934 3.14925C16.2896 2.82105 16.7389 3.00078 16.3677 3.33289L7.84717 10.987Z"
                                                  fill="#707E98"/>
                                        </svg>
                                    </a>
                                    <a target="_blank" href="<?php echo $contacts->field('header_viber'); ?>"
                                       class="list-shared__item__link">
                                        <svg width="20" height="23" viewBox="0 0 20 23" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.2196 0H7.77609C3.48883 0 0 3.48958 0 7.77778V11.1111C0 14.1233 1.73573 16.8576 4.44348 18.1424V21.8533C4.44348 22.1745 4.84704 22.3438 5.07702 22.1137L8.30115 18.8889H12.2239C16.5112 18.8889 20 15.3993 20 11.1111V7.77778C20 3.48958 16.5112 0 12.2196 0ZM10.7399 5.55556C10.6314 5.55556 10.5186 5.56424 10.4101 5.57292C10.2061 5.59462 10.0239 5.44705 10.0022 5.2474C9.98047 5.0434 10.128 4.86111 10.3276 4.83941C10.4621 4.82639 10.601 4.81771 10.7399 4.81771C12.7837 4.81771 14.4413 6.48004 14.4413 8.51997C14.4413 8.65885 14.4326 8.7934 14.4196 8.93229C14.3979 9.13194 14.2113 9.28385 14.0117 9.26215C13.8121 9.24045 13.6646 9.05382 13.6863 8.85417C13.6993 8.74566 13.7036 8.63281 13.7036 8.52431C13.7036 6.88368 12.3714 5.55556 10.7399 5.55556ZM12.9616 8.51997C12.9616 8.72396 12.7924 8.88889 12.5928 8.88889C12.3931 8.88889 12.2239 8.71962 12.2239 8.51997C12.2239 7.70399 11.56 7.03993 10.7442 7.03993C10.5402 7.03993 10.3754 6.875 10.3754 6.67101C10.3754 6.46701 10.5402 6.30208 10.7442 6.30208C11.9636 6.29774 12.9616 7.29167 12.9616 8.51997ZM15.5869 13.954C15.4784 14.4314 15.2397 14.8655 14.8926 15.2127C14.4196 15.6858 13.7774 15.9288 13.0093 15.9288C12.8054 15.9288 12.5884 15.9115 12.3671 15.8767C10.5967 15.599 8.13192 14.7309 6.52636 13.1293L6.50466 13.1076C4.90345 11.5017 4.03558 9.03646 3.75787 7.26562C3.59297 6.21094 3.82296 5.33854 4.42178 4.73958C4.76893 4.39236 5.20286 4.15365 5.68019 4.04514C5.72792 4.03212 5.78 4.03212 5.82773 4.0408L7.63289 4.375C7.78043 4.40104 7.89759 4.51823 7.92797 4.6658L8.45303 7.28299C8.47906 7.40451 8.44001 7.53038 8.35322 7.61719L7.29442 8.67622C8.17097 10.5469 9.16468 11.5451 10.9568 12.3481L12.02 11.2847C12.1067 11.1979 12.2326 11.1589 12.3541 11.1849L14.975 11.7101C15.1226 11.7405 15.2397 11.8576 15.2658 12.0052L15.5999 13.8108C15.5999 13.8542 15.5999 13.9063 15.5869 13.954ZM15.7865 9.71788C15.7388 9.91753 15.5261 10.0434 15.3265 9.99132C15.1356 9.93924 15.0184 9.73958 15.0662 9.54861C15.1443 9.21441 15.1833 8.86719 15.1833 8.52431C15.1833 6.07205 13.1916 4.07986 10.7399 4.07986C10.627 4.07986 10.5099 4.0842 10.397 4.09288C10.1931 4.1059 10.0152 3.95399 9.99783 3.75C9.98047 3.54601 10.1367 3.36806 10.3406 3.35069C10.4708 3.34201 10.6053 3.33767 10.7399 3.33767C13.5995 3.33767 15.9254 5.66406 15.9254 8.52431C15.9254 8.92361 15.8776 9.32726 15.7865 9.71788Z"
                                                  fill="#707E98"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <button class="cont-trigger js__cont-trigger">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.25 0C20.972 0 24 3.06413 24 6.83046C24 10.5968 20.972 13.6609 17.25 13.6609C13.528 13.6609 10.5 10.5967 10.5 6.83046C10.5 3.06417 13.528 0 17.25 0ZM16.6239 6.83046C16.6239 7.05678 16.7432 7.26592 16.9369 7.37906L19.2599 8.73609C19.3584 8.7937 19.4661 8.82111 19.5723 8.82111C19.7886 8.82111 19.9991 8.7075 20.115 8.50423C20.2879 8.20121 20.1853 7.81377 19.8859 7.63888L17.876 6.46472V2.7592C17.876 2.40935 17.5957 2.12571 17.25 2.12571C16.9042 2.12571 16.6239 2.40935 16.6239 2.7592V6.83046Z"
                                  fill="#D5E8B1"/>
                            <path d="M19.8333 17.5578C18.375 17.5578 16.975 17.3236 15.6683 16.8902C15.26 16.7614 14.805 16.8551 14.4783 17.183L11.9117 19.7599C8.61 18.0732 5.90333 15.3558 4.22333 12.041L6.79 9.46414C7.11667 9.13618 7.21 8.67937 7.08167 8.26941C6.65 6.95756 6.41667 5.55199 6.41667 4.08787C6.41667 3.77722 6.29375 3.47929 6.07496 3.25963C5.85616 3.03997 5.55942 2.91656 5.25 2.91656H1.16667C0.857247 2.91656 0.560501 3.03997 0.341709 3.25963C0.122916 3.47929 0 3.77722 0 4.08787C0 9.36889 2.08958 14.4336 5.80905 18.1679C9.52852 21.9021 14.5732 24 19.8333 24C20.1428 24 20.4395 23.8766 20.6583 23.6569C20.8771 23.4373 21 23.1393 21 22.8287V18.7291C21 18.4185 20.8771 18.1206 20.6583 17.9009C20.4395 17.6812 20.1428 17.5578 19.8333 17.5578Z"
                                  fill="#707E98"/>
                        </svg>
                    </button>
                    <a href="#" class="hc-nav-trigger hc-nav-1 js__burger"><span></span></a>

                    <div class="nav-top__pop js__cloneClock">

                        <ul class="list-clock js__appendToJs__cloneClock">
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99994 0C15.514 0 20 4.48597 20 10C20 15.514 15.514 20 9.99994 20C4.48591 20 2.10789e-06 15.514 2.10789e-06 10C2.10789e-06 4.48604 4.48591 0 9.99994 0V0ZM9.07248 10C9.07248 10.3313 9.24926 10.6375 9.53621 10.8032L12.9776 12.7899C13.1236 12.8742 13.2831 12.9144 13.4404 12.9144C13.761 12.9144 14.0728 12.748 14.2445 12.4505C14.5006 12.0068 14.3486 11.4396 13.905 11.1836L10.9274 9.46455V4.03956C10.9274 3.52736 10.5121 3.11211 9.99994 3.11211C9.48774 3.11211 9.07248 3.52736 9.07248 4.03956V10Z"
                                          fill="#707E98"/>
                                </svg>
                            </li>
                            <li class="list-clock__item cont-header">
                                <?php _e('Запись по телефону', 'mz') ?>
                            </li>
                            <li class="list-clock__item cont-header">
                                <a href="tel:<?php echo $contacts->field('header_phone'); ?>"><?php echo $contacts->field('header_phone'); ?></a>
                            </li>
                        </ul>
                        <ul class="list-clock js__appendToJs__cloneClock">
                            <li>
                                <svg width="14" height="20" viewBox="0 0 14 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                                    <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                                          fill="#707E98"></path>
                                </svg>
                            </li>
                            <li class="list-clock__item cont-header"><?php echo $contacts->field('header_address_' . LOCALE); ?></li>
                        </ul>
                    </div>
                    <div class="nav-top__pop js__popRegion">
                        <button class="nav-top__pop-cross js__cont-trigger-region">
                            <svg class="svg-sprite-icon icon-crossM">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="nav-top__pop js__popCity">
                        <button class="nav-top__pop-cross js__cont-trigger-city">
                            <svg class="svg-sprite-icon icon-crossM">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                            </svg>
                        </button>

                    </div>
                    <div class="nav-top__pop js__appendToJs__cloneClock">
                        <button class="nav-top__pop-cross  js__cont-trigger">
                            <svg class="svg-sprite-icon icon-crossM">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                            </svg>
                        </button>
                    </div>

                    <div class="nav-top__pop js__medPop">
                        <button class="nav-top__pop-cross  js__medPop-trigger">
                            <svg class="svg-sprite-icon icon-crossM">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                            </svg>
                        </button>
                        <form class="med-call-pop">
                            <div class="med-call-pop-img">
                                <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/callMed.svg"
                                     alt="med">
                            </div>
                            <div class="med-call-pop-der">
                                Наши менеджеры перезвонят вам
                                в течении 30 мин.
                            </div>

                            <label class="input-form"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Имя*';
                                } else if (LOCALE == 'ua') {
                                    echo 'Iм\'я*';
                                } else {
                                    echo 'Name*';
                                }
                                ?>
                                <input type="text" name="name" class="feedback-name" required>
                                <span class="error-label" style="display: none">поле заполнено некорректно</span>
                            </label>

                            <label class="input-form"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Телефон*';
                                } else if (LOCALE == 'ua') {
                                    echo 'Телефон*';
                                } else {
                                    echo 'Phone*';
                                }
                                ?>
                                <input type="tel" name="name" class="feedback-phone" required
                                       placeholder="+38 (___) __ __ ___">
                                <span class="error-label" style="display: none">поле заполнено некорректно</span>
                            </label>
                            <input type="hidden" class="feedback-subject" value="Заказ обратного звонка">
                            <input type="hidden" class="feedback-type" value="1">
                            <button type="button" class="btn btn--sm send-email"><?php
                                if (LOCALE == 'ru') {
                                    echo 'заказать звонок';
                                } else if (LOCALE == 'ua') {
                                    echo 'замовити дзвінок';
                                } else {
                                    echo 'request a call';
                                }
                                ?></button>


                        </form>
                    </div>
                </div>
            </div>

        </div>
        <?php if ($test): ?>
            <div class="nav-bottom">
                <div class="container-fluid">
                    <div class="nav-bottom-row">
                        <div class="nav-bottom__logo">
                            <a href="<?php echo get_home_url(); ?>"><img
                                        src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/logo-sm.svg"
                                        alt="logo"></a>
                        </div>
                        <nav class="nav-bottom__nav" id="main-nav">
                            <ul class="nav-bottom__nav-list__parent">
                                <li class="nav-bottom__nav-list__parent__item-bottom custom-content"
                                    data-nav-custom-content>
                                    <div class="list-lang 222">
                                        <?php
                                        if (function_exists('wpm_language_switcher')) {
                                            //wpm_language_switcher ();
                                        }
                                        ?>
                                    </div>
                                    <div class="list-shared">
                                        <?php if ($contacts->field('header_facebook')) { ?>
                                            <a href="<?php echo $contacts->field('header_facebook'); ?>"
                                               class="list-shared__item__link">
                                                <svg class="svg-sprite-icon icon-fb">
                                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#fb"></use>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if ($contacts->field('header_instagram')) { ?>
                                            <a href="<?php echo $contacts->field('header_instagram'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.59785 2H16.9979C20.1979 2 22.7979 4.6 22.7979 7.8V16.2C22.7979 17.7383 22.1868 19.2135 21.0991 20.3012C20.0114 21.3889 18.5361 22 16.9979 22H8.59785C5.39785 22 2.79785 19.4 2.79785 16.2V7.8C2.79785 6.26174 3.40892 4.78649 4.49663 3.69878C5.58434 2.61107 7.0596 2 8.59785 2ZM18.0479 5.5C18.3794 5.5 18.6973 5.6317 18.9317 5.86612C19.1662 6.10054 19.2979 6.41848 19.2979 6.75C19.2979 7.08152 19.1662 7.39946 18.9317 7.63388C18.6973 7.8683 18.3794 8 18.0479 8C17.7163 8 17.3984 7.8683 17.164 7.63388C16.9295 7.39946 16.7979 7.08152 16.7979 6.75C16.7979 6.41848 16.9295 6.10054 17.164 5.86612C17.3984 5.6317 17.7163 5.5 18.0479 5.5ZM12.7979 7C14.1239 7 15.3957 7.52678 16.3334 8.46447C17.2711 9.40215 17.7979 10.6739 17.7979 12C17.7979 13.3261 17.2711 14.5979 16.3334 15.5355C15.3957 16.4732 14.1239 17 12.7979 17C11.4718 17 10.2 16.4732 9.26232 15.5355C8.32464 14.5979 7.79785 13.3261 7.79785 12C7.79785 10.6739 8.32464 9.40215 9.26232 8.46447C10.2 7.52678 11.4718 7 12.7979 7ZM12.7979 9C12.0022 9 11.2391 9.31607 10.6765 9.87868C10.1139 10.4413 9.79785 11.2044 9.79785 12C9.79785 12.7956 10.1139 13.5587 10.6765 14.1213C11.2391 14.6839 12.0022 15 12.7979 15C13.5935 15 14.3566 14.6839 14.9192 14.1213C15.4818 13.5587 15.7979 12.7956 15.7979 12C15.7979 11.2044 15.4818 10.4413 14.9192 9.87868C14.3566 9.31607 13.5935 9 12.7979 9Z"
                                                          fill="#707E98"/>
                                                    <circle cx="18.2979" cy="6.5" r="1.5" fill="white"/>
                                                    <circle cx="12.7979" cy="12" r="5" fill="white"/>
                                                    <circle cx="12.7979" cy="12" r="3" fill="#707E98"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if ($contacts->field('header_youtube')) { ?>
                                            <a href="<?php echo $contacts->field('header_youtube'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17 20H7C4 20 2 18 2 15V9C2 6 4 4 7 4H17C20 4 22 6 22 9V15C22 18 20 20 17 20Z"
                                                          fill="#707E98"/>
                                                    <path d="M11.4 9.5L13.9 11C14.8 11.6 14.8 12.5 13.9 13.1L11.4 14.6C10.4 15.2 9.59998 14.7 9.59998 13.6V10.6C9.59998 9.3 10.4 8.9 11.4 9.5Z"
                                                          stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if (false) { ?>
                                            <a target="_blank" href="<?php echo $contacts->field('header_telegram'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.8472 18.987L13.5151 23.6404C13.9878 23.6404 14.1949 23.4372 14.441 23.1911L16.66 21.0695L21.2582 24.4374C22.1021 24.9063 22.6959 24.6601 22.9225 23.6599L25.9424 9.51216C26.2119 8.26969 25.4931 7.7813 24.6727 8.08996L6.92837 14.8845C5.71729 15.3533 5.73682 16.0293 6.72132 16.334L11.257 17.7445L21.7934 11.1493C22.2896 10.8211 22.7389 11.0008 22.3677 11.3329L13.8472 18.987Z"
                                                          fill="#707E98"/>
                                                </svg>
                                            </a>
                                            <a target="_blank" href="<?php echo $contacts->field('header_viber'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.2196 5H13.7761C9.48883 5 6 8.48958 6 12.7778V16.1111C6 19.1233 7.73573 21.8576 10.4435 23.1424V26.8533C10.4435 27.1745 10.847 27.3438 11.077 27.1137L14.3012 23.8889H18.2239C22.5112 23.8889 26 20.3993 26 16.1111V12.7778C26 8.48958 22.5112 5 18.2196 5ZM16.7399 10.5556C16.6314 10.5556 16.5186 10.5642 16.4101 10.5729C16.2061 10.5946 16.0239 10.447 16.0022 10.2474C15.9805 10.0434 16.128 9.86111 16.3276 9.83941C16.4621 9.82639 16.601 9.81771 16.7399 9.81771C18.7837 9.81771 20.4413 11.48 20.4413 13.52C20.4413 13.6589 20.4326 13.7934 20.4196 13.9323C20.3979 14.1319 20.2113 14.2839 20.0117 14.2622C19.8121 14.2405 19.6646 14.0538 19.6863 13.8542C19.6993 13.7457 19.7036 13.6328 19.7036 13.5243C19.7036 11.8837 18.3714 10.5556 16.7399 10.5556ZM18.9616 13.52C18.9616 13.724 18.7924 13.8889 18.5928 13.8889C18.3931 13.8889 18.2239 13.7196 18.2239 13.52C18.2239 12.704 17.56 12.0399 16.7442 12.0399C16.5402 12.0399 16.3754 11.875 16.3754 11.671C16.3754 11.467 16.5402 11.3021 16.7442 11.3021C17.9636 11.2977 18.9616 12.2917 18.9616 13.52ZM21.5869 18.954C21.4784 19.4314 21.2397 19.8655 20.8926 20.2127C20.4196 20.6858 19.7774 20.9288 19.0093 20.9288C18.8054 20.9288 18.5884 20.9115 18.3671 20.8767C16.5967 20.599 14.1319 19.7309 12.5264 18.1293L12.5047 18.1076C10.9034 16.5017 10.0356 14.0365 9.75787 12.2656C9.59297 11.2109 9.82296 10.3385 10.4218 9.73958C10.7689 9.39236 11.2029 9.15365 11.6802 9.04514C11.7279 9.03212 11.78 9.03212 11.8277 9.0408L13.6329 9.375C13.7804 9.40104 13.8976 9.51823 13.928 9.6658L14.453 12.283C14.4791 12.4045 14.44 12.5304 14.3532 12.6172L13.2944 13.6762C14.171 15.5469 15.1647 16.5451 16.9568 17.3481L18.02 16.2847C18.1067 16.1979 18.2326 16.1589 18.3541 16.1849L20.975 16.7101C21.1226 16.7405 21.2397 16.8576 21.2658 17.0052L21.5999 18.8108C21.5999 18.8542 21.5999 18.9063 21.5869 18.954ZM21.7865 14.7179C21.7388 14.9175 21.5261 15.0434 21.3265 14.9913C21.1356 14.9392 21.0184 14.7396 21.0662 14.5486C21.1443 14.2144 21.1833 13.8672 21.1833 13.5243C21.1833 11.072 19.1916 9.07986 16.7399 9.07986C16.627 9.07986 16.5099 9.0842 16.397 9.09288C16.1931 9.1059 16.0152 8.95399 15.9978 8.75C15.9805 8.54601 16.1367 8.36806 16.3406 8.35069C16.4708 8.34201 16.6053 8.33767 16.7399 8.33767C19.5995 8.33767 21.9254 10.6641 21.9254 13.5243C21.9254 13.9236 21.8776 14.3273 21.7865 14.7179Z"
                                                          fill="#707E98"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="list-address">
                                        <svg width="14" height="20" viewBox="0 0 14 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                                            <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                                                  fill="#707E98"></path>
                                        </svg>
                                        <span class="cont-header"><?php echo $contacts->field('header_address_' . LOCALE); ?></span>
                                    </div>
                                    <div class="list-telegram">
                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.9434 1.45975L16.9243 15.0342C16.7018 15.9968 16.1009 16.2303 15.2627 15.7774L10.6637 12.543L8.44574 14.5813C8.20095 14.8148 7.99325 15.013 7.51851 15.013L7.84489 10.5471L16.368 3.20079C16.7389 2.88939 16.2864 2.71245 15.7968 3.02386L5.26349 9.35107L0.723777 7.99928C-0.262794 7.70203 -0.285048 7.05798 0.931477 6.60503L18.6675 0.0796524C19.4909 -0.203444 20.2104 0.270743 19.9434 1.45975Z"
                                                  fill="#707E98"/>
                                        </svg>
                                        <span class="cont-header"><a
                                                    href="<?php echo $contacts->field('header_telegram'); ?>"
                                                    class="list-shared__item__link">Чат-бот</a></span>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="nav-bottom">
                <div class="container-fluid">
                    <div class="nav-bottom-row">
                        <div class="nav-bottom__logo">
                            <a href="<?php echo get_home_url(); ?>"><img
                                        src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/logo-sm.svg"
                                        alt="logo"></a>
                        </div>
                        <nav class="nav-bottom__nav" id="main-nav">
                            <ul class="nav-bottom__nav-list__parent">
                                <li class="nav-bottom__nav-list__parent__item">
                                    <a class="link__parent first <?php if (stristr($_SERVER['REQUEST_URI'], '/doc')) {
                                        echo 'active';
                                    } ?>" href="<?php the_permalink(47); ?>">
                                        <?php
                                        if (LOCALE == 'ru') {
                                            echo 'Врачи';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Лікарі';
                                        } else {
                                            echo 'Doctors';
                                        }
                                        ?></a>
                                    <?php
                                    $specializations = get_categories(['taxonomy' => 'specializations', 'hide_empty' => 0]);
                                    foreach ($specializations as $key => $item) {
                                        if (!get_term_meta($item->term_id, 'spec_visible_on_site')[0]) unset($specializations[$key]);
                                    }
                                    sort($specializations);
                                    $specializations_chunk_11 = array_chunk($specializations, 11);
                                    ?>

                                    <ul class="nav-bottom__nav-list__children <?php if (count($specializations) < 6) {
                                        echo 'columns-one';
                                    } ?>">
                                        <?php

                                        if ($specializations) {
                                            /* меню для pc */
                                            echo '<li class="pc-menu-child">';
                                            foreach ($specializations_chunk_11 as $specialization) {
                                                echo '<ul>';
                                                foreach ($specialization as $item) {
                                                    if (!get_term_meta($item->term_id, 'spec_visible_on_site')[0]) continue;
                                                    ?>
                                                    <li class="nav-bottom__nav-list__children-item">
                                                        <a class="link__children"
                                                           href="<?= get_term_link($item->term_id, 'specializations'); ?>">
                                                            <?= $item->name ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                echo '</ul>';
                                            }
                                            echo '</li>';

                                            /* меню для mobile */
                                            foreach ($specializations as $specialization) {
                                                if (!get_term_meta($specialization->term_id, 'spec_visible_on_site')[0]) continue;
                                                ?>
                                                <li class="nav-bottom__nav-list__children-item  mob-menu-child">
                                                    <a class="link__children"
                                                       href="<?= get_term_link($specialization->term_id, 'specializations'); ?>">
                                                        <?= $specialization->name ?>
                                                    </a>
                                                </li>
                                                <?php
                                            }

                                        }
                                        ?>
                                        <li class="nav-bottom__nav-list__children-item-fixed">
                                            <a href="<?php the_permalink(1140); ?>"
                                               class="nav-bottom__nav-list__children-item-all-link">
                                                <?php
                                                if (LOCALE == 'ru') {
                                                    echo 'Все врачи';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Всі лікарі';
                                                } else {
                                                    echo 'All doctors';
                                                }
                                                ?>
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 12H19" stroke="#707E98" stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M13 6L19 12L13 18" stroke="#707E98" stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                

<!--                                <li class="nav-bottom__nav-list__parent__item">-->
<!--                                    <a class="link__parent --><?php //if (stristr($_SERVER['REQUEST_URI'], '/uslugi') && !stristr($_SERVER['REQUEST_URI'], 'uslugi/vartist-posluh') && !stristr($_SERVER['REQUEST_URI'], 'uslugi/korporativnym-klientam')) {
//                                        echo 'active';
//                                    } ?><!--" href="--><?php //= get_post_type_archive_link('services') ?><!--">--><?php
//                                        if (LOCALE == 'ru') {
//                                            echo 'услуги';
//                                        } else if (LOCALE == 'ua') {
//                                            echo 'послуги';
//                                        } else {
//                                            echo 'services';
//                                        }
//                                        ?>
<!--                                    </a>-->
<!--                                    --><?php
//
//                                    // создаем экземпляр
//                                    $services_query = new WP_Query;
//
//                                    // делаем запрос
//                                    $services = $services_query->query(array(
//                                        'post_type' => 'services',
//                                        'numberposts' => -1,
//                                        'post__not_in' => array(4022)
//                                    ));
//                                    $services_array_chunk_6 = array_chunk($services, 6, true);
//
//                                    ?>
<!--                                    <ul class="nav-bottom__nav-list__children --><?php //if (count($services) < 6) {
//                                        echo 'columns-one';
//                                    } ?><!--">-->
<!--                                        --><?php
//
//                                        if ($services) {
//                                            /* меню для pc */
//                                            echo '<li class="pc-menu-child">';
//                                            foreach ($services_array_chunk_6 as $service) {
//                                                echo '<ul>';
//                                                foreach ($service as $item) {
//                                                    ?>
<!--                                                    <li class="nav-bottom__nav-list__children-item">-->
<!--                                                        <a class="link__children"-->
<!--                                                           href="--><?php //the_permalink($item->ID); ?><!--">-->
<!--                                                            --><?php //echo $item->post_title; ?>
<!--                                                        </a>-->
<!--                                                    </li>-->
<!--                                                    --><?php
//                                                }
//                                                echo '</ul>';
//                                            }
//                                            echo '</li>';
//                                            /* меню для mobile */
//                                            foreach ($services as $service) {
//                                                ?>
<!--                                                <li class="nav-bottom__nav-list__children-item mob-menu-child">-->
<!--                                                    <a class="link__children"-->
<!--                                                       href="--><?php //the_permalink($service->ID); ?><!--">-->
<!--                                                        --><?php //echo $service->post_title; ?>
<!--                                                    </a>-->
<!--                                                </li>-->
<!--                                                --><?php
//
//                                            }
//                                        }
//                                        wp_reset_postdata();
//                                        ?>
<!--                                        <li class="nav-bottom__nav-list__children-item-fixed">-->
<!--                                            <a href="--><?php //= get_post_type_archive_link('services') ?><!--"-->
<!--                                               class="nav-bottom__nav-list__children-item-all-link">-->
<!--                                                --><?php
//                                                if (LOCALE == 'ru') {
//                                                    echo 'Все услуги';
//                                                } else if (LOCALE == 'ua') {
//                                                    echo 'Всі послуги';
//                                                } else {
//                                                    echo 'All services';
//                                                }
//                                                ?>
<!--                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"-->
<!--                                                     xmlns="http://www.w3.org/2000/svg">-->
<!--                                                    <path d="M5 12H19" stroke="#707E98" stroke-width="2"-->
<!--                                                          stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                    <path d="M13 6L19 12L13 18" stroke="#707E98" stroke-width="2"-->
<!--                                                          stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->

                                <li class="nav-bottom__nav-list__parent__item">
                                    <a class="link__parent
                                <?php if (stristr($_SERVER['REQUEST_URI'], '/vartist-posluh') || stristr($_SERVER['REQUEST_URI'], '/vartist-posluh') || stristr($_SERVER['REQUEST_URI'], '/price')) {
                                        echo 'active';
                                    } ?>" href="
                                <?php the_permalink(758); ?>"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Цены';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Ціни';
                                        } else {
                                            echo 'Prices';
                                        }
                                        ?></a>
                                </li>

                                <li class="nav-bottom__nav-list__parent__item"><a
                                            class="link__parent <?php if (stristr($_SERVER['REQUEST_URI'], '/specials')) {
                                                echo 'active';
                                            } ?>" href="<?= get_post_type_archive_link('specials') ?>"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Акции';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Акції';
                                        }
                                        ?>
                                    </a>
                                </li>
                                <!--
                                <li class="nav-bottom__nav-list__parent__item"><a class="link__parent <?php if (stristr($_SERVER['REQUEST_URI'], '/stranica-chekapy')) {
                                    echo 'active';
                                } ?>" href="<?php the_permalink(1974) ?>"><?php
                                if (LOCALE == 'ru') {
                                    echo 'чекап';
                                } else if (LOCALE == 'ua') {
                                    echo 'чекап';
                                }
                                ?></a>
                                </li>
-->
                                <li class="nav-bottom__nav-list__parent__item"><a
                                            class="link__parent text-no-wrap  <?php if (stristr($_SERVER['REQUEST_URI'], '/about-the-center') ||
                                                stristr($_SERVER['REQUEST_URI'], '/about-us') ||
                                                stristr($_SERVER['REQUEST_URI'], '/komanda/rukovodstvo') ||
                                                stristr($_SERVER['REQUEST_URI'], '/oborudovanie') ||
                                                stristr($_SERVER['REQUEST_URI'], '/otzyvy') ||
                                                stristr($_SERVER['REQUEST_URI'], '/vakansii') ||
                                                stristr($_SERVER['REQUEST_URI'], '/laboratoriya')) {
                                                echo 'active';
                                            } ?>" href="<?php the_permalink(526); ?>"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'О центре';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Про центр';
                                        } else {
                                            echo 'about the center';
                                        }
                                        ?></a>
                                    <ul class="nav-bottom__nav-list__children columns-one">
                                        <li class="nav-bottom__nav-list__children-item">
                                            <a class="link__children" href="<?php the_permalink(531) ?>"><?php
                                                if (LOCALE == 'ru') {
                                                    echo 'О нас';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Про нас';
                                                } else {
                                                    echo 'About us';
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <!--                                     <li class="nav-bottom__nav-list__children-item">
                                        <a class="link__children" href="<?php //the_permalink(569)?>"><?php
                                        //if ( LOCALE == 'ru' ) {
                                        //    echo 'Руководство';
                                        //} else if ( LOCALE == 'ua' ) {
                                        //    echo 'Керівництво';
                                        //} else {
                                        //    echo 'Executives';
                                        //}
                                        ?>
                                        </a>
                                    </li> -->
                                        <?php
                                        $medical_workers = get_post(4493);
                                        if ($medical_workers && $medical_workers->post_status == 'publish') {
                                            ?>
                                            <li class="nav-bottom__nav-list__children-item">
                                                <a class="link__children" href="<?php the_permalink(4493) ?>"><?php
                                                    if (LOCALE == 'ru') {
                                                        echo 'Медицинские работники';
                                                    } else if (LOCALE == 'ua') {
                                                        echo 'Медичні працівники';
                                                    } else {
                                                        echo 'Medical workers';
                                                    }
                                                    ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li class="nav-bottom__nav-list__children-item">
                                            <a class="link__children"
                                               href="<?= get_post_type_archive_link('equipment') ?>"><?php
                                                if (LOCALE == 'ru') {
                                                    echo 'Оборудование';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Обладнання';
                                                } else {
                                                    echo 'Equipment';
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <li class="nav-bottom__nav-list__children-item">
                                            <a class="link__children"
                                               href="<?= get_post_type_archive_link('reviews') ?>"><?php
                                                if (LOCALE == 'ru') {
                                                    echo 'Отзывы';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Відгуки';
                                                } else {
                                                    echo 'Reviews';
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <li class="nav-bottom__nav-list__children-item">
                                            <a class="link__children"
                                               href="<?= get_post_type_archive_link('jobs') ?>"><?php
                                                if (LOCALE == 'ru') {
                                                    echo 'Вакансии';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Вакансії';
                                                } else {
                                                    echo 'Jobs';
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <li class="nav-bottom__nav-list__children-item">
                                            <a class="link__children" href="<?php the_permalink(639) ?>">
                                                <?php
                                                if (LOCALE == 'ru') {
                                                    echo 'Лаборатория';
                                                } else if (LOCALE == 'ua') {
                                                    echo 'Лабораторія';
                                                } else {
                                                    echo 'Laboratory';
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <!--
                                        <li class="nav-bottom__nav-list__children-item-img">
                                            <a class="link__children-img" href="<?php the_permalink($page); ?>">
                                                <img src="<?php echo $menu_page_img; ?>" alt="">
                                                <div class="link__children-img-text">
                                                    <p><b><?php echo $menu_page_title; ?></b></p>
                                                    <p><?php echo $menu_page_desc; ?></p>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);" class="btn mt-1 get-covid-test"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Записаться на тест';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Записатися на тестування';
                                        } else {
                                            echo 'Sign up for testing';
                                        }
                                        ?>
                                            </a>
                                        </li>
-->
                                    </ul>

                                <li class="nav-bottom__nav-list__parent__item"><a
                                            class="link__parent <?php if (stristr($_SERVER['REQUEST_URI'], '/category') || stristr($_SERVER['REQUEST_URI'], '/article') || stristr($_SERVER['REQUEST_URI'], '/news-info')) {
                                                echo 'active';
                                            } ?>" href="<?= get_the_permalink(323) ?>"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Новости';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Новини';
                                        } else {
                                            echo 'News';
                                        }
                                        ?></a>
                                    <?php $blog_menu = get_categories(['taxonomy' => 'blog', 'hide_empty' => 0]); ?>
                                    <ul class="nav-bottom__nav-list__children <?php if (count($blog_menu) < 6) {
                                        echo 'columns-one';
                                    } ?>">

                                        <?php
                                        if ($blog_menu) {
                                            foreach ($blog_menu as $menu) {
                                                ?>
                                                <li class="nav-bottom__nav-list__children-item">
                                                    <a class="link__children"
                                                       href="<?= esc_url(get_category_link($menu->term_id)); ?>">
                                                        <?= esc_html($menu->name); ?>
                                                    </a>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <!--
                                        <li class="nav-bottom__nav-list__children-item-img">

                                            <a class="link__children-img" href="<?php the_permalink($page); ?>">
                                                <img src="<?php echo $menu_page_img; ?>" alt="">
                                                <div class="link__children-img-text">
                                                    <p><b><?php echo $menu_page_title; ?></b></p>
                                                    <p><?php echo $menu_page_desc; ?></p>
                                                </div>
                                            </a>

                                            <a href="javascript:void(0);" class="btn mt-1 get-covid-test">
                                                <?php
                                        if (LOCALE == 'ru') {
                                            echo 'Записаться на тест';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Записатися на тестування';
                                        } else {
                                            echo 'Sign up for testing';
                                        }
                                        ?>
                                            </a>
                                        </li>
-->
                                    </ul>
                                </li>
                                <li class="nav-bottom__nav-list__parent__item"><a
                                            class="link__parent <?php if (stristr($_SERVER['REQUEST_URI'], '/contacts') ||
                                                stristr($_SERVER['REQUEST_URI'], '/punkty-zabora-krovi') ||
                                                stristr($_SERVER['REQUEST_URI'], '/informatsionnyj-tsentr') ||
                                                stristr($_SERVER['REQUEST_URI'], '/grafik-raboty')) {
                                                echo 'active';
                                            } ?>" href="<?php the_permalink(693) ?>">
                                        <?php
                                        if (LOCALE == 'ru') {
                                            echo 'Контакты';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Контакти';
                                        } else {
                                            echo 'Contacts';
                                        }
                                        ?></a>
                                </li>
                                <li class="nav-bottom__nav-list__parent__item-bottom custom-content"
                                    data-nav-custom-content>
                                    <div class="list-shared">
                                        <?php if ($contacts->field('header_facebook')) { ?>
                                            <a href="<?php echo $contacts->field('header_facebook'); ?>"
                                               class="list-shared__item__link">
                                                <svg class="svg-sprite-icon icon-fb">
                                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#fb"></use>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if ($contacts->field('header_instagram')) { ?>
                                            <a href="<?php echo $contacts->field('header_instagram'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.59785 2H16.9979C20.1979 2 22.7979 4.6 22.7979 7.8V16.2C22.7979 17.7383 22.1868 19.2135 21.0991 20.3012C20.0114 21.3889 18.5361 22 16.9979 22H8.59785C5.39785 22 2.79785 19.4 2.79785 16.2V7.8C2.79785 6.26174 3.40892 4.78649 4.49663 3.69878C5.58434 2.61107 7.0596 2 8.59785 2ZM18.0479 5.5C18.3794 5.5 18.6973 5.6317 18.9317 5.86612C19.1662 6.10054 19.2979 6.41848 19.2979 6.75C19.2979 7.08152 19.1662 7.39946 18.9317 7.63388C18.6973 7.8683 18.3794 8 18.0479 8C17.7163 8 17.3984 7.8683 17.164 7.63388C16.9295 7.39946 16.7979 7.08152 16.7979 6.75C16.7979 6.41848 16.9295 6.10054 17.164 5.86612C17.3984 5.6317 17.7163 5.5 18.0479 5.5ZM12.7979 7C14.1239 7 15.3957 7.52678 16.3334 8.46447C17.2711 9.40215 17.7979 10.6739 17.7979 12C17.7979 13.3261 17.2711 14.5979 16.3334 15.5355C15.3957 16.4732 14.1239 17 12.7979 17C11.4718 17 10.2 16.4732 9.26232 15.5355C8.32464 14.5979 7.79785 13.3261 7.79785 12C7.79785 10.6739 8.32464 9.40215 9.26232 8.46447C10.2 7.52678 11.4718 7 12.7979 7ZM12.7979 9C12.0022 9 11.2391 9.31607 10.6765 9.87868C10.1139 10.4413 9.79785 11.2044 9.79785 12C9.79785 12.7956 10.1139 13.5587 10.6765 14.1213C11.2391 14.6839 12.0022 15 12.7979 15C13.5935 15 14.3566 14.6839 14.9192 14.1213C15.4818 13.5587 15.7979 12.7956 15.7979 12C15.7979 11.2044 15.4818 10.4413 14.9192 9.87868C14.3566 9.31607 13.5935 9 12.7979 9Z"
                                                          fill="#707E98"/>
                                                    <circle cx="18.2979" cy="6.5" r="1.5" fill="white"/>
                                                    <circle cx="12.7979" cy="12" r="5" fill="white"/>
                                                    <circle cx="12.7979" cy="12" r="3" fill="#707E98"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if ($contacts->field('header_youtube')) { ?>
                                            <a href="<?php echo $contacts->field('header_youtube'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17 20H7C4 20 2 18 2 15V9C2 6 4 4 7 4H17C20 4 22 6 22 9V15C22 18 20 20 17 20Z"
                                                          fill="#707E98"/>
                                                    <path d="M11.4 9.5L13.9 11C14.8 11.6 14.8 12.5 13.9 13.1L11.4 14.6C10.4 15.2 9.59998 14.7 9.59998 13.6V10.6C9.59998 9.3 10.4 8.9 11.4 9.5Z"
                                                          stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                        <?php if (false) { ?>
                                            <a target="_blank" href="<?php echo $contacts->field('header_telegram'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.8472 18.987L13.5151 23.6404C13.9878 23.6404 14.1949 23.4372 14.441 23.1911L16.66 21.0695L21.2582 24.4374C22.1021 24.9063 22.6959 24.6601 22.9225 23.6599L25.9424 9.51216C26.2119 8.26969 25.4931 7.7813 24.6727 8.08996L6.92837 14.8845C5.71729 15.3533 5.73682 16.0293 6.72132 16.334L11.257 17.7445L21.7934 11.1493C22.2896 10.8211 22.7389 11.0008 22.3677 11.3329L13.8472 18.987Z"
                                                          fill="#707E98"/>
                                                </svg>
                                            </a>
                                            <a target="_blank" href="<?php echo $contacts->field('header_viber'); ?>"
                                               class="list-shared__item__link">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.2196 5H13.7761C9.48883 5 6 8.48958 6 12.7778V16.1111C6 19.1233 7.73573 21.8576 10.4435 23.1424V26.8533C10.4435 27.1745 10.847 27.3438 11.077 27.1137L14.3012 23.8889H18.2239C22.5112 23.8889 26 20.3993 26 16.1111V12.7778C26 8.48958 22.5112 5 18.2196 5ZM16.7399 10.5556C16.6314 10.5556 16.5186 10.5642 16.4101 10.5729C16.2061 10.5946 16.0239 10.447 16.0022 10.2474C15.9805 10.0434 16.128 9.86111 16.3276 9.83941C16.4621 9.82639 16.601 9.81771 16.7399 9.81771C18.7837 9.81771 20.4413 11.48 20.4413 13.52C20.4413 13.6589 20.4326 13.7934 20.4196 13.9323C20.3979 14.1319 20.2113 14.2839 20.0117 14.2622C19.8121 14.2405 19.6646 14.0538 19.6863 13.8542C19.6993 13.7457 19.7036 13.6328 19.7036 13.5243C19.7036 11.8837 18.3714 10.5556 16.7399 10.5556ZM18.9616 13.52C18.9616 13.724 18.7924 13.8889 18.5928 13.8889C18.3931 13.8889 18.2239 13.7196 18.2239 13.52C18.2239 12.704 17.56 12.0399 16.7442 12.0399C16.5402 12.0399 16.3754 11.875 16.3754 11.671C16.3754 11.467 16.5402 11.3021 16.7442 11.3021C17.9636 11.2977 18.9616 12.2917 18.9616 13.52ZM21.5869 18.954C21.4784 19.4314 21.2397 19.8655 20.8926 20.2127C20.4196 20.6858 19.7774 20.9288 19.0093 20.9288C18.8054 20.9288 18.5884 20.9115 18.3671 20.8767C16.5967 20.599 14.1319 19.7309 12.5264 18.1293L12.5047 18.1076C10.9034 16.5017 10.0356 14.0365 9.75787 12.2656C9.59297 11.2109 9.82296 10.3385 10.4218 9.73958C10.7689 9.39236 11.2029 9.15365 11.6802 9.04514C11.7279 9.03212 11.78 9.03212 11.8277 9.0408L13.6329 9.375C13.7804 9.40104 13.8976 9.51823 13.928 9.6658L14.453 12.283C14.4791 12.4045 14.44 12.5304 14.3532 12.6172L13.2944 13.6762C14.171 15.5469 15.1647 16.5451 16.9568 17.3481L18.02 16.2847C18.1067 16.1979 18.2326 16.1589 18.3541 16.1849L20.975 16.7101C21.1226 16.7405 21.2397 16.8576 21.2658 17.0052L21.5999 18.8108C21.5999 18.8542 21.5999 18.9063 21.5869 18.954ZM21.7865 14.7179C21.7388 14.9175 21.5261 15.0434 21.3265 14.9913C21.1356 14.9392 21.0184 14.7396 21.0662 14.5486C21.1443 14.2144 21.1833 13.8672 21.1833 13.5243C21.1833 11.072 19.1916 9.07986 16.7399 9.07986C16.627 9.07986 16.5099 9.0842 16.397 9.09288C16.1931 9.1059 16.0152 8.95399 15.9978 8.75C15.9805 8.54601 16.1367 8.36806 16.3406 8.35069C16.4708 8.34201 16.6053 8.33767 16.7399 8.33767C19.5995 8.33767 21.9254 10.6641 21.9254 13.5243C21.9254 13.9236 21.8776 14.3273 21.7865 14.7179Z"
                                                          fill="#707E98"/>
                                                </svg>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="list-address">
                                        <svg width="14" height="20" viewBox="0 0 14 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                                            <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                                                  fill="#707E98"></path>
                                        </svg>
                                        <span class="cont-header"><?php echo $contacts->field('header_address_' . LOCALE); ?></span>
                                    </div>
                                    <div class="list-telegram">
                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.9434 1.45975L16.9243 15.0342C16.7018 15.9968 16.1009 16.2303 15.2627 15.7774L10.6637 12.543L8.44574 14.5813C8.20095 14.8148 7.99325 15.013 7.51851 15.013L7.84489 10.5471L16.368 3.20079C16.7389 2.88939 16.2864 2.71245 15.7968 3.02386L5.26349 9.35107L0.723777 7.99928C-0.262794 7.70203 -0.285048 7.05798 0.931477 6.60503L18.6675 0.0796524C19.4909 -0.203444 20.2104 0.270743 19.9434 1.45975Z"
                                                  fill="#707E98"/>
                                        </svg>
                                        <span class="cont-header"><a
                                                    href="<?php echo $contacts->field('header_telegram'); ?>"
                                                    class="list-shared__item__link">Чат-бот</a></span>
                                    </div>
                                </li>

                            </ul>

                        </nav>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </header>
