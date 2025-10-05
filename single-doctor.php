<?php get_header(); ?>


<?php
$get_doctor_id = get_post_meta(get_the_ID(), 'api_doctor_id')[0];

if (function_exists('getEmpIdDoctor')) {
    $get_emp_doctor_id = getEmpIdDoctor($get_doctor_id);
}
?>

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

                <li class="breadcrumb-item"><a href="/doc"><?php
                        if (LOCALE == 'ru') {
                            echo 'Врачи';
                        } else if (LOCALE == 'ua') {
                            echo 'Лікарі';
                        } else {
                            echo 'Doctors';
                        }
                        ?></a>
                </li>
                <?php $category = get_the_terms(get_the_ID(), 'specializations'); ?>
                <li class="breadcrumb-item"><a href="/doc/<?php echo $category[0]->slug; ?>"><?php
                        echo strip_tags(apply_filters('the_content', $category[0]->name));
                        ?></a></li>

                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <a href="javascript:history.back()" class="link-chevron">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 6L9 12L15 18" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php
                if (LOCALE == 'ru') {
                    echo 'назад';
                } else if (LOCALE == 'ua') {
                    echo 'назад';
                } else {
                    echo 'back';
                }
                ?>
            </a>
            <div class="rowFlex jc-sb-md ">
                <div class="colFlex col-lg-3">
                    <div class="card-doc ">
                        <div class="card-doc-img ">
                            <?php
                            $doctor_photo = CFS()->get('doctor_photo');
                            if (!$doctor_photo || empty($doctor_photo) || $doctor_photo == '') {
                                $doctor_photo = get_template_directory_uri() . '/core/images/no_photo.png';
                            }
                            ?>
                            <img src="<?php echo $doctor_photo; ?>" alt="<?php the_title(); ?>">
                        </div>
                        <div class="card-doc-text js__lg-get-calendar">
                            <?php
                            $doctor_name = get_the_title();
                            $doctor_name_array = explode(" ", $doctor_name, 2);
                            $doctor_name = '<div class="card-doc-text-title">' . $doctor_name_array[0] . '</div>';
                            $doctor_name .= '<div class="card-doc-text-title">' . $doctor_name_array[1] . '</div>';
                            echo $doctor_name;
                            ?>
                            <div class="card-doc-text-decr">
                                <?php the_excerpt(); ?>
                            </div>

                            <span class="card-doc-text-experience"><svg class="svg-sprite-icon icon-experience">
                           <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#experience"></use>
                        </svg><?php echo apply_filters('the_content', CFS()->get('experience_years_card')); ?> <?php
                                if (CFS()->get('experience_years_card') && CFS()->get('experience_years_card') != "") {
                                    echo '&nbsp;';
                                    $number = CFS()->get('experience_years_card');
                                    $number = strip_tags(apply_filters('the_content', $number));
                                    $number = trim($number);
                                    if ($number == 1) {
                                        echo 'рік';
                                    } elseif ($number == 2 || $number == 3 || $number == 4) {
                                        echo 'роки';
                                    } elseif ($number >= 5 && $number <= 19) {
                                        echo 'років';
                                    } else {
                                        $number = substr($number, -1);
                                        $number = (int)$number;
                                        if ($number == 0) {
                                            echo 'рік';
                                        } elseif ($number == 1) {
                                            echo 'рік';
                                        } elseif ($number >= 2 && $number <= 4) {
                                            echo 'роки';
                                        } elseif ($number >= 5 && $number <= 9) {
                                            echo 'років';
                                        }
                                    }

                                }
                                ?></span>
                            <div class="card-doc-text-calendar js__lg-append-calendar">


                                <span class="calendarMonth">
                                    <?php
                                    $shedule = CFS()->get('day_of_week_block');
                                    if ($shedule) {
                                        ?>
                                        <svg class="svg-sprite-icon icon-calendarMonth">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#calendarMonth"></use>
                                    </svg>
                                    <?php } ?>
                                </span>

                                <?php
                                if ($shedule) {
                                    echo '<table>';
                                    foreach ($shedule as $item) {
                                        ?>
                                        <tr>
                                            <th><?php echo reset($item['day_of_week']) ?></th>
                                            <td><?php echo $item['shedule']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    echo '</table>';
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="colFlex col-lg-9">

                    <div>
                        <?php the_content(); ?>

                        <?php get_template_part('core/inc/list-price-doctor') ?>


                        <?php
                        $blocks = CFS()->get('block_after_certs');
                        if ($blocks) {
                            ?>
                            <div class="container-fluid">
                                <div class="col-md-8 mx-auto">
                                    <div class="product-accordion">
                                        <?php
                                        foreach ($blocks as $block) {
                                            ?>
                                            <div class="product-accordion-item">
                                                <div class="product-accordion-title">
                                                    <?php
                                                    $block_after_certs_name = $block['block_after_certs_name_' . LOCALE];
                                                    if ($block_after_certs_name == '') {
                                                        $block_after_certs_name = $block['block_after_certs_name_ru'];
                                                    }
                                                    ?>
                                                    <?php echo $block_after_certs_name; ?>
                                                    <span class="close"></span>
                                                </div>
                                                <div class="product-accordion-decr all-text">
                                                    <?php
                                                    $block_text = $block['block_after_certs_text_' . LOCALE];
                                                    if ($block_text == '' || empty($block_text)) {
                                                        $block_text = $block['block_after_certs_text_ru'];
                                                    }
                                                    ?>
                                                    <?php echo apply_filters('the_content', $block_text); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="mb-30"></div>
                        <div class="container-fluid appointment-row">
                            <?php
                            $contacts = pods('header_contacts');
                            ?>
                            <div class="col-md-12 mx-auto">
                                <div class="row-btn justify-center">
                                    <div class="appointment-header" id="appointment-header">
                                        <p>Для запису ви можете зателефонувати за номером <strong><a href="tel:<?php echo $contacts->field('header_phone'); ?>"><?php echo $contacts->field('header_phone'); ?></a></strong> або переглянути розклад лікаря й записатися безпосередньо на сайті.</p>
                                    </div>
                                </div>
                                <div class="row-btn justify-center">
                                    <div id="appointment-container" data-doctor-id="<?php echo CFS()->get('docdream_id'); ?>">
                                        <a id="appointment-call" class="btn"
                                           href="javascript:;"><?php _e('записаться на приём', 'mz') ?></a>
                                    </div>
                                </div>
                                <div id="appointment-block" style="display:none;">

                                </div>
                            </div>
                        </div>

                        <?php
                        $videoLink = CFS()->get('doctor_video');
                        $certs = get_post_meta(get_the_ID(), 'doctor_certifications');
                        if ($certs or $videoLink) {
                            ?>
                            <div class="bg-gray pb-64-40 mb-88-40">
                                <div class="certificate  <?php $videoLink ? 'mb-68-40' : 'mb-30' ?> ">

                                    <!-- Swiper -->
                                    <section class="wow slideInLeft" data-wow-duration="2s" data-wow-delay="5s" data-wow-offset="10" data-wow-iteration="10">
                                    </section>

                                    <div class="swiper-container certificate-slider js__certificate-slider">
                                        <div class="swiper-wrapper <?php  if(count($certs) < 7 ) echo 'mb-0' ?>">

                                            <?php
                                            foreach ($certs as $cert) {
                                                ?>
                                                <div class="swiper-slide">
                                                    <a class="certificate-slider-item" href="<?php echo $cert['guid'] ?>" data-fancybox="gallery" data-caption="сертификаты">
                                                        <img class="no-lazy" src="<?php echo $cert['guid']; ?>" alt="сертификаты">
                                                        <span class="certificate-slider-item-zoom">
                                                    <svg class="svg-sprite-icon icon-zoom">
                                           <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#zoom"></use>
                                        </svg>
                                                </span>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                        <div class="container-fluid">
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
                                <?php get_template_part('core/inc/components/doctor_video'); ?>
                            </div>

                        <?php } ?>


                    </div>

                </div>
            </div>


        </div>




        <div class="mb-88-40"></div>
        <div class="container-fluid mb-40-64">
            <?php if (comments_open() || get_comments_number()) :
                comments_template();
            endif; ?>
        </div>
        <div class="bg-gray">
            <?php get_template_part('core/inc/have_questions') ?>
        </div>
    </main>


    <div class="modal modal-xl" id="sign-up-modal">
        <div class="modal__title"><?php _e("Запись на прием", 'mz') ?></div>
        <form class="form-default js__form-sing-up">
            <input type="hidden" name="action" value="send_mail_two">
            <input type="hidden" name="category" value="<?= $category ?>">
            <input type="hidden" name="sign_up" value="sign_up">
            <input type="hidden" name="doctor" value="<?php the_title(); ?>">
            <input type="hidden" class="js__chek-select" name="select-selected" value="on">

            <label class="input-form"><?php _e('Имя', 'mz') ?>*
                <input type="text" name="name" required="">
            </label>

            <label class="input-form"><?php _e('Телефон', 'mz') ?>*
                <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
            </label>

            <div class="text-center">
                <button type="submit" class="btn w-100"><?php _e('записаться на приём', 'mz') ?></button>
            </div>

        </form>
    </div>
    <div class="modal modal-xl" id="ask-question">
<!--        <div class="modal__title mb-30">--><?php //_e('Задать вопрос специалисту', 'mz') ?><!--</div>-->
        <form class="form-default js__ask_question">
            <input type="hidden" name="action" value="send_mail_two">
            <input type="hidden" name="ask_question" value="ask_question">
            <input type="hidden" class="js__chek-select" name="select-selected" value="on">
            <input type="hidden" name="doctor" value="<?php the_title(); ?>">

            <label class="input-form"><?php _e('Имя', 'mz') ?>*
                <input type="text" name="name" required="">
            </label>

            <label class="input-form"><?php _e('Телефон', 'mz') ?>*
                <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
            </label>

            <label class="textarea-form"><?php _e('Ваш вопрос', 'mz') ?>
                <textarea name="ask_text"></textarea>
            </label>
            <div class="text-center">
                <button type="submit" class="btn w-100"><?php _e('задать вопрос', 'mz') ?></button>
            </div>
        </form>
    </div>


<?php get_footer(); ?>