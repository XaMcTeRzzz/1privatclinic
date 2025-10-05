<?php get_header(); ?>

    <main role="main" class="content">

        <div class="price-block-container">
            <div class="price-block-container-img">
                <picture>
                    <source media="(min-width: 576px)" srcset="<?php echo get_template_directory_uri() . '/core/' ?>images/general/f-2.jpg">
                    <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/f-2.jpg" alt="logo">
                </picture>
            </div>
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">главная</a></li>


                    <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                </ol>
                <div class="rowFlex">
                    <div class="col-md-5 colFlex">
                        <div class="title wow" data-wow-delay="5s">
                            <div class="title-wrap">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 colFlex ">
                        <div class="price-block price-block--grid">
                            <div class="price-block-item">
                                <a href="/about-us/" class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-cross">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#cross"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php echo get_the_title(531); ?></div>
                                    <a class="link-bubbles" href="<?php the_permalink(531)?>"><?php
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
                            <!-- <div class="price-block-item">
                                <a  href="<?php //the_permalink(569)?>" class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-company">
                                        <use xlink:href="<?php //echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#company"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php //echo get_the_title(569); ?></div>
                                    <a class="link-bubbles" href="<?php //the_permalink(569)?>"
                                    ><?php
                                        //if (LOCALE == 'ru') {
                                        //    echo 'подробнее';
                                        //} else if (LOCALE == 'ua') {
                                        //    echo 'докладніше';
                                        //} else {
                                        //    echo 'more';
                                        //}
                                        ?></a>
                                </div>
                            </div> -->
                            <div class="price-block-item">
                                <a
                                   href="<?= get_post_type_archive_link( 'equipment' )?>"
                                   class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-lib">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#lib"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Оборудование';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Обладнання';
                                        } else {
                                            echo 'Equipment';
                                        }
                                        ?></div>
                                    <a class="link-bubbles"
                                       href="<?= get_post_type_archive_link( 'equipment' )?>"
                                    ><?php
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
                            <div class="price-block-item">
                                <a
                                        href="<?= get_post_type_archive_link( 'reviews' )?>"
                                   class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-like">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#like"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Отзывы';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Відгуки';
                                        } else {
                                            echo 'Reviews';
                                        }
                                        ?></div>
                                    <a class="link-bubbles"
                                       href="<?= get_post_type_archive_link( 'reviews' )?>"
                                    ><?php
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
                            <div class="price-block-item">
                                <a href="<?= get_post_type_archive_link( 'jobs' )?>"
                                        class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-search">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#search"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Вакансии';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Вакансії';
                                        } else {
                                            echo 'Jobs';
                                        }
                                        ?></div>
                                    <a class="link-bubbles"
                                       href="<?= get_post_type_archive_link( 'jobs' )?>"
                                    ><?php
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
                            <div class="price-block-item">
                                <a href="<?php the_permalink(639)?>" class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-dnk">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#dnk"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Лаборатория';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Лабораторія';
                                        } else {
                                            echo 'Laboratory';
                                        }
                                        ?></div>
                                    <a class="link-bubbles"
                                       href="<?php the_permalink(639)?>"
                                    ><?php
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

                    </div>
                </div>

            </div>
        </div>

    </main>

<?php get_footer(); ?>