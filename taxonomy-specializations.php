<?php get_header(); ?>


<main role="main" class="content">
    <?php get_template_part( 'core/inc/doc-banner' ) ?>

    <div class="container-fluid mb-88-40">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><?php
                    if ( LOCALE == 'ru' ) {
                        echo 'Главная';
                    } else if ( LOCALE == 'ua' ) {
                        echo 'Головна';
                    } else {
                        echo 'Home';
                    }
                    ?></a></li>
            <li class="breadcrumb-item"><a href="/doc"><?php
                    if ( LOCALE == 'ru' ) {
                        echo 'Врачи';
                    } else if ( LOCALE == 'ua' ) {
                        echo 'Лікарі';
                    } else {
                        echo 'Doctors';
                    }
                    ?></a>
            </li>
            <li class="breadcrumb-item">
                <span>
                    <?php
                    $title = single_cat_title( '', false );
                    echo strip_tags( apply_filters( 'the_content', $title ) );
                    ?>
                </span>
            </li>
        </ol>
        <div class="nav-title">
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?= strip_tags( apply_filters( 'the_content', $title ) ); ?></h1>
                </div>
                <div class="title-decor">
                    <svg width="53" height="14" viewBox="0 0 53 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 7H21L25.5 2.5L29.5 11.5L33.5 7.5H53" stroke="#95C53D" stroke-width="2" />
                    </svg>
                </div>
            </div>
            <button class="link-back js__list-doctor-mob-trigger">направления</button>
            <div class="list-doctor-mob">
                <button class="list-doctor-mob__cross">
                    <svg class="svg-sprite-icon icon-crossM">
                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                    </svg>
                </button>

                <ul class="list-doctors">
                    <?php
                    $specializations = get_categories( [ 'taxonomy' => 'specializations', 'hide_empty' => 0 ] );

                    if ( $specializations ) {
                        foreach ( $specializations as $specialization ) {
                            ?>
                    <li class="list-doctors__item">
                        <a href="/doc/<?php echo $specialization->slug; ?>" class="list-doctors__item-link
                                <?php if ( stristr( $_SERVER['REQUEST_URI'], $specialization->slug ) ) {
                                    echo 'active';
                                } ?>">
                            <?php echo strip_tags( apply_filters( 'the_content', $specialization->name ) ); ?></a>
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
                    $specializations = get_categories( [ 'taxonomy' => 'specializations', 'hide_empty' => 0 ] );

                    if ( $specializations ) {
                        foreach ( $specializations as $specialization ) {
                            if(!get_term_meta($specialization->term_id, 'spec_visible_on_site')[0]) continue;
                            ?>
                    <li class="list-doctors__item">
                        <a href="<?php echo get_term_link($specialization->term_id, 'specializations') ?>" class="list-doctors__item-link
                                <?php if ( stristr( $_SERVER['REQUEST_URI'], $specialization->slug ) ) {
                                    echo 'active';
                                } ?>">
                            <?php echo strip_tags( apply_filters( 'the_content', $specialization->name ) ); ?></a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                </ul>


            </div>
            <div class="colFlex col-sm-8">
                <div class="rowFlex">

                    <?php if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post(); ?>
                    <div class="col-md-6 colFlex">
                        <div class="schedule-card">
                            <div class="schedule-card__top">
                                <div class="schedule-card__img">
                                    <?php
                                            $doctor_photo = get_the_post_thumbnail_url();
                                            if ( ! $doctor_photo || empty( $doctor_photo ) || $doctor_photo == '' ) {
                                                $doctor_photo = get_template_directory_uri() . '/core/images/no_photo.png';
                                            }
                                            ?>
                                    <img src="<?php echo $doctor_photo; ?>" alt="<?php the_title(); ?>">
                                </div>
                                <div class="schedule-card__text">

                                    <?php
                                            $doctor_name       = get_the_title();
                                            $doctor_name_array = explode( " ", $doctor_name, 2 );
                                            $doctor_name       = '<div class="small-title">' . $doctor_name_array[0] . '</div>';
                                            $doctor_name       .= '<div class="small-title">' . $doctor_name_array[1] . '</div>';
                                            echo $doctor_name;
                                            ?>

                                    <div class="small-decr"><?php the_excerpt(); ?></div>
                                </div>
                            </div>
                            <div class="schedule-card__bottom">
                                <a href="<?php the_permalink(); ?>" class="link-bubbles"><?php
                                            if ( LOCALE == 'ru' ) {
                                                echo 'подробнее';
                                            } else if ( LOCALE == 'ua' ) {
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

                </div>


                <?php get_template_part( 'core/inc/list-price' ) ?>

                <div class="mb-88-40">
                    <?php get_template_part( 'core/inc/service_about' ) ?>
                </div>

<!--                --><?php //get_template_part( 'core/inc/faq-list' ) ?>
                <div class="mb-48-30"></div>

            </div>
        </div>
    </div>


    <div class="bg-gray pt-64-40 pb-64-40">
        <div class="container-fluid">
            <div id="comments" class="comments-area">
                <div class="title"><?php _e( 'Отзывы и вопросы', 'mz' ) ?></div>
                <div class="rowFlex jc-sb-md">
                    <div class="colFlex col-md-8">
                        <?php
                        global $withcomments;
                        $withcomments = 1;

                        $countComment = [];
                        if ( have_posts() ) {
                            global $post;
                            while ( have_posts() ) {
                                the_post();
                                $countComment[] = $post->comment_count;
                                $allIdPost[]    = get_the_ID();
                                if ( comments_open() || get_comments_number() ) {
                                    comments_template( '/comments_all.php' );
                                }
                            }
                            wp_reset_query();
                        }
                        $countComment = (int)array_sum( $countComment );
                        if (!$countComment) {
                                if ( LOCALE == 'ru' ) {
                                    echo 'Пока что нет отзывов';
                                } else if ( LOCALE == 'ua' ) {
                                    echo 'Поки що немає відгуків';
                                }
                        }
                        ?>
                    </div>
                    <div class="colFlex col-md-3 d-none d-md-block">
                        <div class="sandbar-sticky">
                            <?php
                            $query = new WP_Query( 'post_type=reviews' );
                            if ( $query->have_posts() ) {
                                while ( $query->have_posts() ) {
                                    $query->the_post();
                                    $defaults = [
                                        'fields'               => [
                                            'author' => '
                                <label class="input-form">
                                    ' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '
                                    <input  class="review-name author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' .
                                                        $aria_req .
                                                        $html_req . ' />
                                </label>',
                                            'email'  => '
                                <label class="input-form">
                                    ' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '
                                    <input  class="review-name email" name="email" type="email"  placeholder="yourmail@mail.com" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' .
                                                        $aria_req . $html_req . ' />
                                </label>',
                                        ],
                                        'comment_field'        => '
                                <label class="textarea-form">
                                    ' . _x( 'Comment', 'noun' ) . '
                                    <textarea  class="review-review comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
                                </label>',
                                        'comment_notes_before' => '',
                                        'id_form'              => '',
                                        'id_submit'            => '',
                                        'class_form'           => 'form-default commentform',
                                        'title_reply'          => __('Написать отзыв или задать вопрос', 'mz'),
                                        'title_reply_to'       => '',
                                        'class_submit'         => 'btn',
                                        'name_submit'          => 'submit',
                                        'label_submit'         => __( 'отправить', 'mz'),
                                        'submit_button'        => '<button name="%1$s" type="submit"  class="%3$s %2$s"/>%4$s</button>',
                                        'submit_field'         => '<p class="text-center">%1$s %2$s</p>',
                                        'format'               => 'html5',
                                    ];
                                    comment_form( $defaults );
                                }
                                wp_reset_postdata(); // сбрасываем переменную $post
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_template_part( 'core/inc/seo-block' ) ?>
    <div class="bg-gray">
        <?php get_template_part( 'core/inc/have_questions' ) ?>
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
                    <?php if ( have_posts() ): ?>
                    <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <option value="<?php the_title(); ?>"><?php the_title(); ?></option>
                    <?php endwhile; ?>
                    <?php endif; ?>
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
                <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z" fill="#707E98">
                </path>
            </svg>
            <?php echo $contacts->field( 'header_address_' . LOCALE ); ?>
        </div>
        <div class="modal-footer__row">
            <div class="modal-footer__column">
                <div class="modal-footer__text">
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone' )) ?>" class="">
                        <?php echo $contacts->field( 'header_phone' ); ?>
                    </a>
                </div>
            </div>
            <div class="modal-footer__column">
                <div class="modal-footer__text">
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone' )) ?>" class="">
                        <?php echo $contacts->field( 'header_phone_2' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl" id="ask-question">
<!--    <div class="modal__title mb-30">--><?php //_e( 'Задать вопрос специалисту', 'mz' ) ?><!--</div>-->
    <form class="form-default js__ask_question">
        <input type="hidden" name="action" value="send_mail_two">
        <input type="hidden" name="ask_question" value="ask_question">
        <div class="select-wrap input-form w-100">
            <input type="hidden" class="js__chek-select" name="select-selected" value="">
            <select name="doctor" id="askQuestionSelect">
                <option data-placeholder="true"><?php _e( 'Выберите специалиста', 'mz' ) ?></option>
                <?php if ( have_posts() ): ?>
                <?php while ( have_posts() ) : ?>
                <?php the_post(); ?>
                <option value="<?php the_title(); ?>"><?php the_title(); ?></option>
                <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>


        <label class="input-form"><?php _e( 'Имя', 'mz' ) ?>*
            <input type="text" name="name" required="">
        </label>

        <label class="input-form"><?php _e( 'Телефон', 'mz' ) ?>*
            <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
        </label>

        <label class="textarea-form"><?php _e( 'Ваш вопрос', 'mz' ) ?>
            <textarea name="ask_text"></textarea>
        </label>
        <div class="text-center">
            <button type="submit" class="btn w-100"><?php _e( 'задать вопрос', 'mz' ) ?></button>
        </div>
    </form>
</div>

<?php get_footer(); ?>
