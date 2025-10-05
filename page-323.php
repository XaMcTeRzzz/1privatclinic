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

                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="nav-title">
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
                <button class="link-back js__list-doctor-mob-trigger">рубрики</button>
                <div class="list-doctor-mob">
                    <button class="list-doctor-mob__cross"><svg class="svg-sprite-icon icon-crossM">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                        </svg></button>

                    <?php include get_template_directory() . '/blog-menu.php' ?>

                </div>
            </div>
            <div class="rowFlex">
                <div class="colFlex col-sm-4 col-lg-3">
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
                    </div>

                </div>
                <?php
                $paged = get_query_var('paged') ?: 1;
                $args = array( 'posts_per_page' => 12, 'paged' => $paged, 'post_type' => 'article');
                global $wp_query;
                $wp_query = new WP_Query( $args );
                ?>
                <div class="colFlex col-sm-8 col-lg-9">
                    <div class="rowFlex">
                        <?php
                        $i = 0;
                        if (have_posts()) {
                        while (have_posts() && $i == 0 ) { the_post();
                        ?>
                        <div class="colFlex  col-md-8 ">
                            <a href="<?php the_permalink(); ?>" class="top-news mb-40-64">
                                <div class="top-news-img">
                                    <?php if (get_the_post_thumbnail_url() && get_the_post_thumbnail_url() != '') { ?>
                                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                    <?php } ?>
                                </div>
                                <div class="top-news-text blog-item__text">
                                    <div class="top-news-text-row">
                                        <div class="blog-item__text-category">популярне</div>
                                        <div class="blog-item__text-data"><?php
                                            $date = get_the_date("d M Y");
                                            echo $date;
                                            ?></div>
                                        <div class="blog-item__text-title"><?php the_title(); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php $i++; } ?>
                        <div class="colFlex col-md-4">
                            <div class="saidBar rowFlex mb-40-64">
                                <?php
                                if (have_posts()) {
                                while (have_posts() && $i == 1 ) { the_post();
                                ?>
                                <div class="col-xs-6 col-md-12 colFlex">
                                    <a href="<?php the_permalink(); ?>" class="saidBar-item">
                                        <div class="blog-item__text-category">Діагностична лабораторія</div>
                                        <div class="blog-item__text-title"><?php the_title(); ?></div>
                                        <div class="blog-item__text-data"><?php
                                            $date = get_the_date("d M Y");
                                            echo $date;
                                            ?></div>
                                        <div class="blog-item__text-description">
                                            <?php
                                            $content = strip_tags(get_the_content());
                                            echo $content;
                                            ?>
                                        </div>
                                    </a>
                                </div>
                                <?php $i++; } } ?>
                                <?php
                                if (have_posts()) {
                                while (have_posts() && $i == 2 ) { the_post();
                                    ?>
                                    <div class="col-xs-6 col-md-12 colFlex">
                                        <a href="<?php the_permalink(); ?>" class="saidBar-item">
                                            <div class="blog-item__text-category">Діагностична лабораторія</div>
                                            <div class="blog-item__text-title"><?php the_title(); ?></div>
                                            <div class="blog-item__text-data"><?php
                                                $date = get_the_date("d M Y");
                                                echo $date;
                                                ?></div>
                                            <div class="blog-item__text-description">
                                                <?php
                                                $content = strip_tags(get_the_content());
                                                echo $content;
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php $i++; } } ?>
                            </div>
                        </div>

                    </div>
                    <div class="rowFlex">
                        <?php
                            if (have_posts()) {
                        while (have_posts() ) { the_post();
                        ?>
                        <div class="colFlex col-xs-6 col-lg-4">
                            <a href="<?php the_permalink(); ?>" class="blog-item">
                                <?php if (get_the_post_thumbnail_url() && get_the_post_thumbnail_url() != '') { ?>
                                    <div class="blog-item__img">
                                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                    </div>
                                <?php } ?>
                                <div class="blog-item__text">
                                    <div class="blog-item__text-category"><?php
                                        $category = wp_get_post_terms(get_the_ID(), 'blog');
                                        echo $category[0]->name;

                                        ?></div>
                                    <div class="blog-item__text-title"><?php the_title(); ?></div>
                                    <div class="blog-item__text-data"><?php
                                        $date = get_the_date("d M Y");
                                        echo $date;
                                        ?></div>
                                    <div class="blog-item__text-description"><?php
                                        $content = strip_tags(get_the_content());
                                        echo $content;
                                        ?></div>
                                    <div class="text-right">
                                        <span class="link-bubbles"><?php
                                            if (LOCALE == 'ru') {
                                                echo 'подробнее';
                                            } else if (LOCALE == 'ua') {
                                                echo 'докладніше';
                                            } else {
                                                echo 'more';
                                            }
                                            ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php $i++;}} ?>

                    </div>
                    <div class="pagination-wrap">
                        <ul class="pagination">
                            <?php pagination(); ?>
                        </ul>
                    </div>

                </div>
                <?php } ?>
                <? wp_reset_postdata(); ?>
            </div>
        </div>
    </main>

<?php get_footer(); ?>