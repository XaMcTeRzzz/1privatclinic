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
                <?php $category = get_the_terms(get_the_ID(), 'blog'); ?>
                <li class="breadcrumb-item"><a href="/category/<?php echo $category[0]->slug; ?>"><?php
                        echo strip_tags(apply_filters('the_content', $category[0]->name));
                        ?></a>
                </li>

                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="rowFlexPad jc-sb-md">
                <div class="colPad-sm-4 colPadDef colPad-lg-3">
                    <div class="sandbar-sticky">
                        <?php include get_template_directory() . '/blog-menu.php' ?>
                        <div class="list-shared">
                            <a href="#" class="list-shared__item__link"><svg class="svg-sprite-icon icon-fb">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#fb"></use>
                                </svg></a>
                            <a href="#" class="list-shared__item__link"><svg class="svg-sprite-icon icon-twitter">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#twitter"></use>
                                </svg></a>
                            <a href="#" class="list-shared__item__link">
                                <svg class="svg-sprite-icon icon-instagram" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.59785 2H16.9979C20.1979 2 22.7979 4.6 22.7979 7.8V16.2C22.7979 17.7383 22.1868 19.2135 21.0991 20.3012C20.0114 21.3889 18.5361 22 16.9979 22H8.59785C5.39785 22 2.79785 19.4 2.79785 16.2V7.8C2.79785 6.26174 3.40892 4.78649 4.49663 3.69878C5.58434 2.61107 7.0596 2 8.59785 2ZM18.0479 5.5C18.3794 5.5 18.6973 5.6317 18.9317 5.86612C19.1662 6.10054 19.2979 6.41848 19.2979 6.75C19.2979 7.08152 19.1662 7.39946 18.9317 7.63388C18.6973 7.8683 18.3794 8 18.0479 8C17.7163 8 17.3984 7.8683 17.164 7.63388C16.9295 7.39946 16.7979 7.08152 16.7979 6.75C16.7979 6.41848 16.9295 6.10054 17.164 5.86612C17.3984 5.6317 17.7163 5.5 18.0479 5.5ZM12.7979 7C14.1239 7 15.3957 7.52678 16.3334 8.46447C17.2711 9.40215 17.7979 10.6739 17.7979 12C17.7979 13.3261 17.2711 14.5979 16.3334 15.5355C15.3957 16.4732 14.1239 17 12.7979 17C11.4718 17 10.2 16.4732 9.26232 15.5355C8.32464 14.5979 7.79785 13.3261 7.79785 12C7.79785 10.6739 8.32464 9.40215 9.26232 8.46447C10.2 7.52678 11.4718 7 12.7979 7ZM12.7979 9C12.0022 9 11.2391 9.31607 10.6765 9.87868C10.1139 10.4413 9.79785 11.2044 9.79785 12C9.79785 12.7956 10.1139 13.5587 10.6765 14.1213C11.2391 14.6839 12.0022 15 12.7979 15C13.5935 15 14.3566 14.6839 14.9192 14.1213C15.4818 13.5587 15.7979 12.7956 15.7979 12C15.7979 11.2044 15.4818 10.4413 14.9192 9.87868C14.3566 9.31607 13.5935 9 12.7979 9Z"
                                          fill="#707E98"/>
                                    <circle cx="18.2979" cy="6.5" r="1.5" fill="white"/>
                                    <circle cx="12.7979" cy="12" r="5" fill="white"/>
                                    <circle cx="12.7979" cy="12" r="3" fill="#707E98"/>
                                </svg>
                            </a>
                        </div>
                        <div class="saidBar">
                            <?php
                            $articles = get_posts(['post_type' => 'article']);
                            ?>
                            <a href="<?php the_permalink($articles[0]->ID) ?>" class="saidBar-item">
                                <div class="blog-item__text-category"><?php
                                    $terms = get_the_terms($articles[0]->ID, 'blog');
                                    echo $terms[0]->name;
                                    ?></div>
                                <div class="blog-item__text-title"><?php echo $articles[0]->post_title; ?></div>
                                <div class="blog-item__text-data"><?php
                                    $date = get_the_date("d M Y", $articles[0]->ID);
                                    echo $date;
                                    ?></div>
                                <div class="blog-item__text-description"><?php
                                    $content = strip_tags($articles[0]->post_content);
                                    echo $content;
                                    ?></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="colPad-sm-8 colPadDef">
                    <a href="javascript:history.back()" class="link-chevron absolute-md">
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
                    <div class="nav-title">
                        <div class="title">
                            <?php the_title(); ?>
                        </div>
                        <button class="link-back js__list-doctor-mob-trigger">рубрики</button>
                        <div class="list-doctor-mob top">
                            <button class="list-doctor-mob__cross"><svg class="svg-sprite-icon icon-crossM">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                                </svg></button>
                            <?php include get_template_directory() . '/blog-menu.php' ?>
                        </div>
                    </div>

                    <div class="top-news-text-row mb-10 col-md-5">
                        <div class="blog-item__text-data mb-0 "><?php
                            $date = get_the_date("d M Y");
                            echo $date;
                            ?></div>
                        <div class="blog-item__text-category mb-0"></div>
                    </div>
                    <?php
                    $images = get_post_meta(get_the_ID(), 'blog_slider_images');
                    if ($images) {
                    ?>
                    <div class="blog-slider">
                        <div class="page-slider">
                            <!-- Swiper -->
                            <div class="js__page-slider swiper-container">
                                <div class="swiper-wrapper">
                                    <?php foreach ($images as $image) { ?>
                                    <div class="swiper-slide">
                                        <div class="page-slide__item">
                                            <img src="<?php echo $image['guid'] ?>" alt="<?php the_title(); ?>">
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!-- nav-slider -->
                                <div class="nav-slider nav-slider--sm">
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
                        </div>      </div>
                    <?php } ?>

                    <div class="blog-all-text">
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" style="color: white" class="btn mt-1 get-covid-test"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Записаться на тест';
                                } else if (LOCALE == 'ua') {
                                    echo 'Записатися на тестування';
                                } else {
                                    echo 'Sign up for testing';
                                }
                                ?></a>
                            <br>
                            <br>
                        <?php } ?>
                        <?php the_post(); the_content(); ?>
                        <?php
                        if (CFS()->get('show_covid_test_button')) {
                            ?>
                            <a href="javascript:void(0);" style="color: white" class="btn mt-1 get-covid-test"><?php
                                if (LOCALE == 'ru') {
                                    echo 'Записаться на тест';
                                } else if (LOCALE == 'ua') {
                                    echo 'Записатися на тестування';
                                } else {
                                    echo 'Sign up for testing';
                                }
                                ?></a>
                        <?php } ?>
                    </div>
                    <?php
                    $next_post = get_next_post();
                    $next_post_link = get_permalink($next_post->ID);
                    $previous_post = get_previous_post();
                    $previous_post_link = get_permalink($previous_post->ID);
                    $prev_title = strip_tags(apply_filters('the_content', get_the_title($previous_post->ID)));
                    $next_title = strip_tags(apply_filters('the_content', get_the_title($next_post->ID)));
                    ?>
                    <div class="pagination-row">
                        <div class="pagination-row__item prev">
                            <a href="<?php echo $previous_post_link; ?>" class="pagination-title link-chevron">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 6L9 12L15 18" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <?php
                                if (LOCALE == 'ru') {
                                    echo 'Предыдущая';
                                } else if (LOCALE == 'ua') {
                                    echo 'Попередня';
                                } else {
                                    echo 'Previous';
                                }
                                ?>
                            </a>
                            <a href="<?php echo $previous_post_link; ?>" class="pagination-decr"><?php echo $prev_title; ?></a>
                        </div>

                        <div class="pagination-row__item next">
                            <a href="<?php echo $next_post_link; ?>" class="pagination-title link-chevron">
                                <?php
                                if (LOCALE == 'ru') {
                                    echo 'Следующая';
                                } else if (LOCALE == 'ua') {
                                    echo 'Наступна';
                                } else {
                                    echo 'Next';
                                }
                                ?>
                                <svg width="24" transform="rotate(180)"  height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 6L9 12L15 18" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <a href="<?php echo $next_post_link; ?>" class="pagination-decr"><?php echo $next_title; ?></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

<?php get_footer(); ?>