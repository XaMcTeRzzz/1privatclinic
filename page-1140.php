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
                    ?></a></li>
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
            <li class="breadcrumb-item">
                <span>
                    <?php
                    if (LOCALE == 'ru') {
                        echo 'Все врачи';
                    } else if (LOCALE == 'ua') {
                        echo 'Всі лікарі';
                    } else {
                        echo 'All doctors';
                    }
                    ?>
                </span>
            </li>
        </ol>
        <div class="nav-title">
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?= the_title();?></h1>
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
            </div>        <button class="link-back js__list-doctor-mob-trigger">направления</button>
            <div class="list-doctor-mob">
                <button class="list-doctor-mob__cross"><svg class="svg-sprite-icon icon-crossM">
                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                    </svg> </button>

                <ul class="list-doctors">
                    <?php
                    $specializations = get_categories(['taxonomy' => 'specializations', 'hide_empty' => 0]);

                    if ($specializations) {
                        foreach ($specializations as $specialization) {
                            ?>
                            <li class="list-doctors__item">
                                <a href="/doc/<?php echo $specialization->slug; ?>" class="list-doctors__item-link
                                <?php if (stristr($_SERVER['REQUEST_URI'], $specialization->slug)) echo 'active'; ?>">
                                    <?php echo strip_tags(apply_filters('the_content', $specialization->name)); ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>

            </div>
        </div>

        <div class="rowFlex sb-lg">
            <div class="colFlex col-sm-4 col-lg-3">

                <ul class="list-doctors">
                    <?php
                    $specializations = get_categories(['taxonomy' => 'specializations', 'hide_empty' => 0]);

                    if ($specializations) {
                        foreach ($specializations as $specialization) {
                            if(!get_term_meta($specialization->term_id, 'spec_visible_on_site')[0]) continue;
                            ?>
                            <li class="list-doctors__item">
                                <a href="/doc/<?php echo $specialization->slug; ?>" class="list-doctors__item-link
                                <?php if (stristr($_SERVER['REQUEST_URI'], $specialization->slug)) echo 'active'; ?>">
                                    <?php echo strip_tags(apply_filters('the_content', $specialization->name)); ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="colFlex col-sm-8">
                <div class="rowFlex">

                    <?php
                    $array_doc_name = [];
                    $args = array(
                        'post_type' => 'doctor'
                    );
                    $query = new WP_Query( $args );
                    if( $query->have_posts() ){ while( $query->have_posts() ){ $query->the_post(); ?>
                        <div class="col-md-6 colFlex">
                            <div class="schedule-card">
                                <div class="schedule-card__top">
                                    <div class="schedule-card__img">
                                        <?php
                                        $doctor_photo = get_the_post_thumbnail_url();
                                        if (!$doctor_photo || empty($doctor_photo) || $doctor_photo == '') {
                                            $doctor_photo = get_template_directory_uri() . '/core/images/no_photo.png';
                                        }
                                        ?>
                                        <img src="<?php echo $doctor_photo; ?>" alt="<?php the_title(); ?>">
                                    </div>
                                    <div class="schedule-card__text">

                                        <?php
                                        $array_doc_name[] = get_the_title();
                                        $doctor_name = get_the_title();
                                        $doctor_name_array = explode(" ", $doctor_name, 2);
                                        $doctor_name = '<div class="small-title">' . $doctor_name_array[0] . '</div>';
                                        $doctor_name .= '<div class="small-title">' . $doctor_name_array[1] . '</div>';
                                        echo $doctor_name;
                                        ?>

                                        <div class="small-decr"><?php the_excerpt(); ?></div>
                                    </div>
                                </div>
                                <div class="schedule-card__bottom">
                                    <a href="<?php the_permalink(); ?>" class="link-bubbles"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'подробнее';
                                        } else if (LOCALE == 'ua') {
                                            echo 'докладніше';
                                        } else {
                                            echo 'more';
                                        }
                                        ?></a>
                                    <a href="/schedule/?doctor_id=<?= get_the_ID() ?>" class="btn-t btn"><?php _e( 'записаться на приём', 'mz' ) ?></a>
                                </div>
                            </div>
                        </div>
                    <?php } /* конец while */ ?>
                    <?php } /* конец if */ ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-gray">

        <div class="container-fluid all-text">
            <?php

            if (get_term_meta(get_queried_object()->term_id, 'spec_seo_text_title_' . LOCALE)[0] != "" && get_term_meta(get_queried_object()->term_id, 'spec_seo_text_desc_' . LOCALE)[0] != "") {
                ?>
                <h4><?php echo get_term_meta(get_queried_object()->term_id, 'spec_seo_text_title_' . LOCALE)[0]; ?></h4>

                <div class="all-text-column">
                    <?php echo apply_filters('the_content', get_term_meta(get_queried_object()->term_id, 'spec_seo_text_desc_' . LOCALE)[0]); ?>
                </div>

            <?php } ?>
        </div>

    </div>

</main>


<div class="modal-with-footer" id="sign-up-modal">
    <div class="modal modal-xl">
        <div class="modal__title"><?php _e( "Запись на прием", 'mz' ) ?></div>
        <div class="modal__subtitle">
            <?php $category = strip_tags( apply_filters( 'the_content', $title ) ); ?>
            <?= $category ?>
        </div>
        <form class="form-default js__form-sing-up">
            <input type="hidden" name="action" value="send_mail_two">
            <input type="hidden" name="category" value="<?= $category ?>">
            <input type="hidden" name="sign_up" value="sign_up">
            <div class="select-wrap w-100 input-form">
                <input type="hidden" class="js__chek-select" name="select-selected" value="">
                <select name="doctor" id="signUpSelect">
                    <option data-placeholder="true"><?php _e( 'Выберите специалиста', 'mz' ) ?></option>
                    <?php foreach ($array_doc_name as $item){ ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="input-form"><?php _e( 'Имя', 'mz' ) ?>*
                <input type="text" name="name" required="">
            </label>

            <label class="input-form"><?php _e( 'Телефон', 'mz' ) ?>*
                <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
            </label>

            <div class="text-center">
                <button type="submit" class="btn w-100"><?php _e( 'записаться на приём', 'mz' ) ?></button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <?php $contacts = pods( 'header_contacts' ); ?>
        <div class="modal-footer__top">
            <svg width="14" height="20" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                      fill="#707E98">
                </path>
            </svg>
            <?php echo $contacts->field( 'header_address_' . LOCALE ); ?>
        </div>
        <div class="modal-footer__row">
            <div class="modal-footer__column">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.31375 2.68804C10.8288 1.68297 13.7583 1.75246 16.2063 2.91984C15.5087 2.81358 14.7992 2.8937 14.1088 3.01074C12.2335 3.36585 10.4514 4.25054 9.05848 5.56487C7.72285 6.88122 6.78689 8.6278 6.52254 10.4964C6.34769 11.8205 6.50977 13.2092 7.10232 14.4144C7.71294 15.6788 8.78777 16.7159 10.0832 17.2511C11.3315 17.7808 12.7796 17.7749 14.044 17.3022C15.9412 16.6041 17.3043 14.7191 17.4602 12.7052C17.5583 11.3852 17.2381 9.98113 16.3537 8.96878C15.5094 7.97783 14.2746 7.432 13.0389 7.1213C12.9726 5.89936 13.5468 4.69219 14.4573 3.8975C14.963 3.44033 15.5905 3.14893 16.2394 2.96245L16.2887 2.94539C18.1463 3.83858 19.7247 5.31166 20.7304 7.12008C21.5921 8.65973 22.0414 10.4339 21.9969 12.2012C21.9885 14.4866 21.1365 16.7493 19.6761 18.4967C18.2951 20.1632 16.3636 21.3619 14.2584 21.8419C12.1476 22.3302 9.8767 22.1196 7.90125 21.2201C5.9683 20.3545 4.3307 18.8497 3.28894 16.9987C2.42234 15.4605 1.9639 13.687 2.00195 11.9176C2.00608 9.71299 2.78684 7.5254 4.15002 5.80145C5.23889 4.4249 6.68341 3.33036 8.31375 2.68804Z" fill="#707E98"></path>
                    <path d="M14.1088 3.00968C14.7992 2.89264 15.5087 2.81258 16.2063 2.91883L16.3064 2.93583L16.2394 2.96133C15.5905 3.14792 14.963 3.43927 14.4573 3.89649C13.5468 4.69113 12.9726 5.89835 13.0389 7.1203C14.2745 7.43094 15.5094 7.97672 16.3537 8.96771C17.238 9.98007 17.5582 11.3842 17.4602 12.7041C17.3043 14.718 15.9412 16.603 14.044 17.3011C12.7796 17.7739 11.3315 17.7797 10.0832 17.2501C8.78771 16.7148 7.71293 15.6778 7.10232 14.4133C6.50977 13.2082 6.34768 11.8194 6.52259 10.4954C6.78689 8.62674 7.72284 6.88016 9.05852 5.56381C10.4514 4.24947 12.2335 3.36479 14.1088 3.00968Z" fill="white"></path>
                </svg>
                <div class="modal-footer__text">
                    <a href="tel:<?php echo $contacts->field( 'header_phone' ); ?>" class="">
                        <?php echo $contacts->field( 'header_phone' ); ?>
                    </a>
                </div>
            </div>
            <div class="modal-footer__column">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0001 3C12.6515 3 13.1844 3.55677 13.1844 4.23692V8.83518C13.1844 9.51564 12.6515 10.0723 12.0001 10.0723C11.3487 10.0723 10.8159 9.51564 10.8159 8.83518V4.23692C10.8159 3.55677 11.3487 3 12.0001 3Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.05778 9.78417C3.25904 9.1371 3.93042 8.77977 4.54991 8.98998L8.73671 10.411C9.35628 10.6212 9.69832 11.3225 9.49707 11.9696C9.29581 12.6166 8.62429 12.974 8.00487 12.7637L3.81799 11.3428C3.19857 11.1325 2.85639 10.4312 3.05778 9.78417Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.47345 20.764C5.94654 20.3642 5.8287 19.5867 6.21151 19.0364L8.7991 15.3163C9.18184 14.7658 9.92624 14.6426 10.4532 15.0426C10.9802 15.4426 11.098 16.2199 10.7152 16.7703L8.12758 20.4903C7.74477 21.0409 7.00044 21.164 6.47345 20.764Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5269 20.7641C16.9998 21.1639 16.2556 21.0408 15.8726 20.4904L13.2851 16.7704C12.9021 16.2198 13.02 15.4425 13.547 15.0425C14.0739 14.6427 14.8183 14.7659 15.2012 15.3161L17.7887 19.0362C18.1716 19.5866 18.0536 20.3641 17.5269 20.7641Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.942 9.78416C21.1433 10.4312 20.8012 11.1326 20.1816 11.3428L15.9948 12.7637C15.3753 12.974 14.704 12.6166 14.5026 11.9696C14.3013 11.3226 14.6433 10.6212 15.2629 10.4109L19.4497 8.98997C20.0691 8.77976 20.7406 9.13717 20.942 9.78416Z" fill="#707E98"></path>
                </svg>
                <div class="modal-footer__text">
                    <a href="tel:<?php echo $contacts->field( 'header_phone_2' ); ?>" class="">
                        <?php echo $contacts->field( 'header_phone_2' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
