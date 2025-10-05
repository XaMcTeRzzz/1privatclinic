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
                        echo 'Оборудование';
                    } else if (LOCALE == 'ua') {
                        echo 'Обладнання';
                    } else {
                        echo 'Equipment';
                    }
                    ?></span></li>
        </ol>
        <div class="title wow" data-wow-delay="5s">
            <div class="title-wrap">
                <h1><?php
                if (LOCALE == 'ru') {
                    echo 'Оборудование';
                } else if (LOCALE == 'ua') {
                    echo 'Обладнання';
                } else {
                    echo 'Equipment';
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
        <div class="specials">

            <?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
            <div class="specials__card rowFlex mb-65-85 wow">
                <div class="specials__card-img colFlex col-md-6">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </div>
                <div class="specials__card-text colFlex col-md-6">
                    <div class="specials__card-text-title subtitle"><?php the_title(); ?></div>
                    <div class="specials__card-text-decr decr">
                        <?php the_excerpt(); ?>
                    </div>
                    <a  href="<?php the_permalink(); ?>" class="link-bubbles"><?php
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
            <?php } /* конец while */ ?>
            <?php } /* конец if */ ?>

        </div>
        <div class="pagination-wrap">
            <ul class="pagination">
                <?php pagination(); ?>
            </ul>
        </div>
    </div>
</main>

<?php get_footer(); ?>
