<?php

$categories    = get_terms( 'api_services_taxonomy', array( 'hide_empty' => false ) );
$cat_hierarchy = array();
sort_terms_hierarchicaly( $categories, $cat_hierarchy );
//echo '<pre>';
//print_r($cat_hierarchy);
//die();



function loopItemPrice( $terms, $level ) {
    if ($terms->description == 'C') {
    $is_active = get_field('is_active', 'api_services_taxonomy_' . $terms->term_id);

    if (empty($is_active) || $is_active == '0') {
        return false;
    }
}

    $newargs = array(
        'post_type' => 'api_services',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'api_services_taxonomy',
                'field' => 'slug',
                'terms' => $terms->slug,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'first_parent_services',
                'compare' => '=',
                'value' => $terms->term_taxonomy_id,
            )
        )
    );
    $posts = new WP_Query($newargs);
    ?>
    <?php if($terms->description !== 'C' and  $terms->count > 0):?>
        <div class="prise-block-item-parent level-<?= $level ?> "><?php echo $terms->name ?></div>
    <?php endif;?>

    <?php
    if ($terms->description === 'C') {
        $arr = array(
            'post_type' => 'api_services',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'api_services_taxonomy',
                    'field' => 'id',
                    'terms' => $terms->term_taxonomy_id
                ),
            )
        );
        $services = new WP_Query($arr);

    ?>

        <div class="prise-block-item prise-block-item--grid level-<?= $level ?>">
            <div class="prise-block-item__title"><?php echo $terms->name ?></div>
            <div class="prise-block-item__code prise-block-item__content"><?php the_field('api_service_code',  'api_services_taxonomy_'.$terms->term_id ); ?></div>
            <div class="prise-block-item__cine prise-block-item__content"><?php the_field('api_price', 'api_services_taxonomy_'.$terms->term_id); ?> грн</div>
        </div>

        <ul class="prise-block-item__list level-<?= $level+1 ?>">
        <?php
        if ($services->have_posts()) {
            while ($services->have_posts()) : $services->the_post();
                ?>
                <li>
                    <?php the_title(); ?>
                </li>
            <?
            endwhile;
        }
        echo '</ul>';

    }

    ?>

    <?php
    if ($posts->have_posts()) {

        while ($posts->have_posts()) : $posts->the_post();
            ?>
            <div class="prise-block-item prise-block-item--grid level-<?= $level ?>">
                <div class="prise-block-item__title"><?php the_title(); ?></div>
                <div class="prise-block-item__code prise-block-item__content"><?php the_field('code_services'); ?></div>
                <div class="prise-block-item__cine prise-block-item__content"><?php the_field('price_services'); ?> грн</div>
            </div>
        <?
        endwhile;

    }


    wp_reset_query();
}



function loopItemPriceRec($arr, $count = 1){
    if($count == 1){
        foreach ($arr as $cat ) {
            loopItemPrice( $cat, $count );
            loopItemPriceRec($cat, $count +1);
        }
    }else if(!is_object($arr->children)) {
        foreach ($arr->children as $cat ) {
            loopItemPrice( $cat, $count );
            loopItemPriceRec($cat,$count +1);
        }
    }
}

loopItemPriceRec($cat_hierarchy);
