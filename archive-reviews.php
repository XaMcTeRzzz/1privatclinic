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

                <li class="breadcrumb-item"><span><?php
                        if (LOCALE == 'ru') {
                            echo 'Отзывы';
                        } else if (LOCALE == 'ua') {
                            echo 'Відгуки';
                        } else {
                            echo 'Reviews';
                        }
                        ?></span></li>
            </ol>
            <div class="nav-title mb-20-40">
                <div class="title wow" data-wow-delay="5s">
                    <div class="title-wrap">
                        <h1><?php
                        if (LOCALE == 'ru') {
                            echo 'Отзывы';
                        } else if (LOCALE == 'ua') {
                            echo 'Відгуки';
                        } else {
                            echo 'Reviews';
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
<!--                <a class="link-back d-md-none" data-fancybox="" data-src="#feedBack-modal" href="javascript:;">--><?php
//                    if (LOCALE == 'ru') {
//                        echo 'написать отзыв';
//                    } else if (LOCALE == 'ua') {
//                        echo 'написати відгук';
//                    } else {
//                        echo 'write a feedback';
//                    }
//                    ?><!--</a>-->
            </div>
            <div class="rowFlex jc-sb-md">
                <div class="colFlex col-md-8">

                    <?php

                    global $withcomments;
                    $withcomments = true;

                    $custom_query = new WP_Query( [
                        'post_type' => array('doctor', 'reviews'),
                        'posts_per_page'=> '-1',
                        'comment_count' => [
                            'value'   => 1,
                            'compare' => '>=',
                        ],
                    ] );

                    while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                            <?php

                            if (comments_open() || get_comments_number()) {
                                comments_template('/comments_all.php');
                            }
                            ?>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata();  ?>

                </div>
                <div class="colFlex col-md-3 d-md-block">
                    <div class="sandbar-sticky">
                        <?php
                        $query = new WP_Query('post_type=reviews');
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $defaults = [
                                    'fields' => [
                                        'author' => '
                                <label class="input-form">
                                    ' . __('Name') . ($req ? ' <span class="required">*</span>' : '') . '
                                    <input  class="review-name author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' .
                                            $aria_req .
                                            $html_req . ' />
                                </label>',
                                        'email' => '
                                <label class="input-form">
                                    ' . __('Email') . ($req ? ' <span class="required">*</span>' : '') . '
                                    <input  class="review-name email" name="email" type="email"  placeholder="yourmail@mail.com" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-describedby="email-notes"' .
                                            $aria_req . $html_req . ' />
                                </label>',
                                    ],
                                    'comment_field' => '
                                <label class="textarea-form">
                                    ' . _x('Comment', 'noun') . '
                                    <textarea  class="review-review comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
                                </label>',
                                    'comment_notes_before' => '',
                                    'id_form' => '',
                                    'id_submit' => '',
                                    'class_form' => 'form-default commentform',
                                    'title_reply' => __('Написать отзыв или задать вопрос', 'mz'),
                                    'title_reply_to' => '',
                                    'class_submit' => 'btn',
                                    'name_submit' => 'submit',
                                    'label_submit' => __( 'отправить', 'mz'),
                                    'submit_button' => '<button name="%1$s" type="submit"  class="%3$s %2$s"/>%4$s</button>',
                                    'submit_field' => '<p class="text-center">%1$s %2$s</p>',
                                    'format' => 'html5',
                                ];
                                comment_form($defaults);
                            }
                            wp_reset_postdata(); // сбрасываем переменную $post
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </main>

<?php get_footer(); ?>