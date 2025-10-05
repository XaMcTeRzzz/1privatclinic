<?php get_header(); ?>

<main role="main" class="content">
    <section class="schedule">
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
                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?php the_title(); ?></h1>
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
            <?php the_post(); the_content(); ?>
        </div>

    </section>
</main>

<?php get_footer(); ?>
