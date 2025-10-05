<?php
/*
    Template Name: Шаблон страницы Чекап
*/
get_header();
?>

<main role="main" class="content">


    <?php
    $doc_banner_text = get_field('title_check_up');
    $doc_banner_img = get_field('photo_check_up');
    ?>
    <?php if ($doc_banner_img): ?>
        <div class="doc-banner">
            <div class="doc-banner__img">
                <img src='<?= $doc_banner_img ?>' alt="<?php esc_html_e($doc_banner_text) ?>">
            </div>
            <div class="container-fluid">
                <div class="doc-banner__text text-black"><?php esc_html_e($doc_banner_text) ?></div>
                <div class="row-link">
                    <a class="btn" data-fancybox="" data-src="#check_up_modal" href="javascript:;"><?php _e("записаться на приём", 'mz') ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/<?php echo (LOCALE != 'ru') ? LOCALE : ''; ?>"><?php _e('Главная') ?></a></li>
            <li class="breadcrumb-item"><span><?php the_title(); ?></li>
        </ol>
        <div class="title wow mb-40-64" data-wow-delay="5s">
            <div class="title-wrap"><h1><?php the_title(); ?></h1></div>
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


        <div class="blog-all-text">
            <div class="rowFlex jcc">
                <div class="col-md-8 colFlex">
                    <div>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-btn  justify-center">
            <a class="btn btn-t" data-fancybox="" data-src="#call-back" href="javascript:;"><?php _e('перезвоните мне', 'mz') ?></a>
            <a class="btn" data-fancybox="" data-src="#check_up_modal" href="javascript:;"><?php _e('пройти обследование', 'mz') ?></a>
        </div>
        <div class="rowFlex jcc">
            <div class="col-md-8 colFlex">

                <?php
                $taxonomy_id = [];
                $args = array(
                    'hide_empty' => false,
                );
                $terms = get_terms('api_services_taxonomy', $args);

                foreach ($terms as $term) {
                    if ($term->description === 'C') {
                        $taxonomy_id[] = $term;
                    }
                }
                ?>

                <div class="product-accordion">
                    <?php foreach ($taxonomy_id as $term): ?>
                        <?php

                        $title = $term->name;
                        $code = get_field('api_service_code', 'api_services_taxonomy_' . $term->term_id);
                        $price = get_field('api_price', 'api_services_taxonomy_' . $term->term_id);


                        $arr = array(
                            'post_type' => 'api_services',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'api_services_taxonomy',
                                    'field' => 'id',
                                    'terms' => $term->term_id
                                ),
                            )
                        );
                        $services = new WP_Query($arr);

                        ?>

                        <div class="product-accordion-item">
                            <div class="product-accordion-title product-accordion-title--grid">
                                <div class="product-accordion-title__main"><?php echo $title ?></div>
                                <div class="product-accordion-title__code">код <?php echo $code ?> </div>
                                <div class="product-accordion-title__price"> <?php echo $price ?> грн</div>
                                <span class="close"></span>
                            </div>
                            <div class="product-accordion-decr all-text">
                                <ul>
                                    <?php
                                    if ($services->have_posts()) {
                                        while ($services->have_posts()) : $services->the_post();
                                            ?>
                                            <li><?php the_title(); ?></li>
                                        <?php
                                        endwhile;
                                    }
                                    wp_reset_query();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <?php get_template_part('core/inc/have_questions') ?>


</main>


<?php get_footer(); ?>



