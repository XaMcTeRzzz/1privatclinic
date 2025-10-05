<?php

global $termType;
$termType = $_POST['termType'];

$args = array_map('intval', $_POST['args']);
$term_parent_ids = array_map('intval', $_POST['term_parent_ids']);

if ($termType === 'G') {

    // 1. Получаем ID выбранных термов и их дочерних термов
    $all_term_ids = array();

    foreach ($args as $term_id) {
        $all_term_ids[] = $term_id;

        // Получаем дочерние термы
        $child_terms = get_terms(array(
            'taxonomy' => 'api_services_taxonomy',
            'child_of' => $term_id,
            'fields' => 'ids',
            'hide_empty' => false,
        ));

        if (!empty($child_terms) && !is_wp_error($child_terms)) {
            $all_term_ids = array_merge($all_term_ids, $child_terms);
        }
    }

    // Удаляем дубликаты
    $all_term_ids = array_unique($all_term_ids);

    // 2. Формируем запрос WP_Query
    $arr = array(
        'post_type'      => 'api_services',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy'         => 'api_services_taxonomy',
                'field'            => 'id',
                'terms'            => $all_term_ids,
                'include_children' => false, // Отключаем автоматическое включение дочерних термов
            ),
        ),
    );

    $servicesTerm = new WP_Query($arr);

    // 3. Обрабатываем полученные посты и термы
    $arrPostId = array();
    $arrTermWp = array();

    foreach ($servicesTerm->posts as $item) {
        $terms = wp_get_object_terms($item->ID, 'api_services_taxonomy');

        foreach ($terms as $term) {
            // Проверяем, соответствует ли терм выбранным термам или их дочерним термам
            if (!in_array($term->term_id, $all_term_ids)) {
                continue;
            }

            $arrTermWp[] = $term;
            $arrPostId[] = $item->ID;
        }
    }

    // 4. Подготовка массива ID термов для дальнейшей обработки
    $term_ids = array();

    foreach ($arrTermWp as $term) {
        $term_ids[] = $term->term_id;
    }

    // Добавляем родительские термы из $_POST, если необходимо
    $term_ids = array_merge($term_ids, $term_parent_ids);

    $resultTerm = array_unique($term_ids);

    // 5. Получаем термы для отображения
    $categories = get_terms(array(
        'taxonomy'   => 'api_services_taxonomy',
        'hide_empty' => false,
        'include'    => $resultTerm,
    ));

    // 6. Сортируем термы иерархически
    $cat_hierarchy = array();
    sort_terms_hierarchicaly($categories, $cat_hierarchy);

    function loopItemPrice($terms, $level){
     global $arrPostId;
     global $termType;

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
             'post__in' => $arrPostId,
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

        <div class="prise-block-item prise-block-item--white prise-block-item--grid level-<?= $level ?>">
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
            <div class="prise-block-item prise-block-item--white prise-block-item--grid level-<?= $level ?>">
                <div class="prise-block-item__title"><?php the_title(); ?></div>
                <div class="prise-block-item__code prise-block-item__content"><?php the_field('code_services'); ?></div>
                <div class="prise-block-item__cine prise-block-item__content"><?php the_field('price_services'); ?> грн</div>
            </div>
        <?
        endwhile;

    }


        wp_reset_query();
    }

function getValueArrayComplexity($arr, $count = 1)
{
    $count++;
    foreach ($arr->children as $val) {
        if (!is_object($arr->children)) {
            loopItemPrice($val, $count);
            getValueArrayComplexity($val);
        }
    }
}

ob_start();

foreach ($cat_hierarchy as $cat) {
    loopItemPrice($cat, 1);
    getValueArrayComplexity($cat);
}

$html = ob_get_clean();


wp_send_json_success($html);

    }

if ($termType === 'C') {
    global $termId;
    global $titleTerm;
    $termId =  (int)$_POST['args'][0];
    $termIdParent = array_reverse(get_ancestors($termId, 'api_services_taxonomy'));
    $termIdParent[] = $termId;
    $titleTerm = str_replace('\\',' ',$_POST['title']);
    $categories = get_terms('api_services_taxonomy', array('hide_empty' => false, 'include' => $termIdParent));
    $cat_hierarchy = array();
    sort_terms_hierarchicaly($categories, $cat_hierarchy);


        $arr = array(
            'post_type' => 'api_services',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'api_services_taxonomy',
                    'field' => 'id',
                    'terms' => $termId
                ),
            )
        );

        $services = new WP_Query($arr);



            function loopItemPriceTypeC($terms, $level)
            {
                global  $termId;
                global $titleTerm;
                ?>
                    <?php if($terms->term_id !== $termId ): ?>
                      <div class="prise-block-item-parent level-<?= $level ?> "><?php echo $terms->name ?></div>
                      <?php else: ?>
                        <div class="prise-block-item prise-block-item--white prise-block-item--grid level-<?= $level ?>">
                            <div class="prise-block-item__title"><?php echo $titleTerm ?></div>
                            <div class="prise-block-item__code prise-block-item__content"><?php the_field('api_service_code', 'api_services_taxonomy_' . $termId); ?></div>
                            <div class="prise-block-item__cine prise-block-item__content"><?php the_field('api_price', 'api_services_taxonomy_' . $termId) ?> грн</div>
                        </div>
                    <?php endif;?>

                <?php
            }

            function getValueArrayComplexity($arr, $count = 1)
            {
                $count++;
                foreach ($arr->children as $val) {
                    if (!is_object($arr->children)) {
                        loopItemPriceTypeC($val, $count);
                        getValueArrayComplexity($val);
                    }
                }
                return $count;
            }


             ob_start();
              foreach ($cat_hierarchy as $cat) {
                loopItemPriceTypeC($cat, 1);
                getValueArrayComplexity($cat);
            }
        if ($services->have_posts()) {
            ?>

                <ul class="prise-block-item__list level-3 pb-30">
                    <?php while ($services->have_posts()) : $services->the_post(); ?>
                        <li><?php the_title(); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php

        }

        $html = ob_get_clean();

        wp_reset_query();

        wp_send_json_success($html);
}


