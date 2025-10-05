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
                            echo 'Анализы';
                        } else if (LOCALE == 'ua') {
                            echo 'Аналізи';
                        } else {
                            echo 'Analyzes';
                        }
                        ?></span></li>
            </ol>
            <div class="nav-title">
                <div class="title wow" data-wow-delay="5s">
                    <div class="title-wrap">
                        <h1><?php
                        if (LOCALE == 'ru') {
                            echo 'Анализы';
                        } else if (LOCALE == 'ua') {
                            echo 'Аналізи';
                        } else {
                            echo 'Analyzes';
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
            </div>
            <div class="rowFlex mb-20-60">

                <?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
                <div class="col-md-4 colFlex">
                    <div class="directions__item">
                        <div class="directions__item-left">
                            <a class="directions__item-img" href="<?php the_permalink(); ?>">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                            </a>
                        </div>
                        <div class="directions__item-right">
                            <div class="directions__item-title">
                                <?php the_title(); ?>
                            </div>
                            <div class="directions__item-decr">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="link-bubbles"><?php
                                if (LOCALE == 'ru') {
                                    echo 'подробнее';
                                } else if (LOCALE == 'ua') {
                                    echo 'докладніше';
                                } else {
                                    echo 'more';
                                }
                                ?></a>
                        </div>
                    </div>
                </div>
                <?php } /* конец while */ ?>
                <?php } /* конец if */ ?>

            </div>
        </div>

        <?php
            if (CFS()->get('seo3_text_title_' . LOCALE, 772) != "" && CFS()->get('seo3_text_' . LOCALE, 772) != "") {
        ?>
        <div class="bg-gray">
            <div class="container-fluid all-text">
                <h4><?php echo CFS()->get('seo3_text_title_' . LOCALE, 772); ?></h4>

                    <div class="all-text-column">
                        <?php echo apply_filters('the_content', CFS()->get('seo3_text_' . LOCALE, 772)); ?>
                    </div>

            </div>
        </div>
        <?php } ?>

    </main>

<?php get_footer(); ?>