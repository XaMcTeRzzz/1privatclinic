<?php

function slugify($text)
{

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function slugify_title($text)
{

    // remove unwanted characters
    $code_match = array('-', '"', '!', '@', '#', '$', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '',
        '~', '`', '=');
    $text = str_replace($code_match, ' ', $text);
    // trim
    $text = trim($text);

    $text = ucfirst($text);

    return $text;
}

add_action('init', 'register_api_services');

function register_api_services()
{
    $arg = array(
        'labels' => array(
            'name' => 'Прайс услуги',
            'singular_name' => 'Услуга',
            'add_new' => 'Добавить новую',
            'add_new_item' => 'Добавить новую услугу',
            'edit_item' => 'Редактировать услугу',
            'new_item' => 'Новая услуга',
            'view_item' => 'Посмотреть услугу',
            'search_items' => 'Найти услугу',
            'not_found' => 'Услуга не найдено',
            'not_found_in_trash' => 'В корзине услуг не найдено',
            'parent_item_colon' => '',
            'menu_name' => 'Прайс услуги'
        ),
        'public' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-cart',
        'supports' => array('title')
    );
    register_post_type('api_services', $arg);


    register_taxonomy('api_services_taxonomy', ['api_services'], [
        'label' => 'Категории',
        'labels' => [
            'name' => 'Категории',
            'singular_name' => 'Категория',
            'search_items' => 'Искать категорию',
            'all_items' => 'Все категорию',
            'view_item ' => 'Смотреть категорию',
            'parent_item' => 'Родительская категория',
            'parent_item_colon' => 'Родитель категорию:',
            'edit_item' => 'Изменить категорию',
            'update_item' => 'Обновить категорию',
            'add_new_item' => 'Добавить новую категорию',
            'new_item_name' => 'Добавить категорию',
            'menu_name' => 'Категории',
        ],
        'description' => '',
        'public' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ]);

}


add_action('wp_ajax_get_services_from_api', 'get_services_from_api');
add_action('wp_ajax_nopriv_get_services_from_api', 'get_services_from_api');


//add_action('init', function (){
//    $allposts= get_posts( array('post_type'=>'api_services','numberposts'=>-1) );
//    foreach ($allposts as $eachpost) {
//        wp_delete_post( $eachpost->ID, true );
//    }
//
//}, 20);

if (isset($_GET['get_services_from_api'])) {
    add_action('init', 'get_services_from_api', 20);
}



add_action('wp', 'update_electronic_price_activation');
function update_electronic_price_activation()
{
    if (!wp_next_scheduled('update_electronic_price')) {
        wp_schedule_event(time(), 'daily', 'update_electronic_price');
    }
}

add_action('update_electronic_price', 'get_services_from_api');


function get_services_from_api()
{
    /*
    API_URL_AUTHORIZATION
    API_URL_SERVER
    В wp-config.php
    */

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL_AUTHORIZATION.'/connect/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('client_id' => 'api_server_access', 'client_secret' => 'mapp_d87_EXPRESS_PUBLIC_sec', 'scope' => 'healthcareservices specialities physicians events appointments simplified login account organizations', 'grant_type' => 'client_credentials'),
    ));

    $response_token = curl_exec($curl);

    $response_token_decode = json_decode($response_token, true);

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL_SERVER.'/HealthcareServices/5/FullPriceList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $response_token_decode['access_token'],
            'Organization: B86530AD-BFAB-4899-8A0A-2BE5E9AF7852'
        ),
    ));

    $response = curl_exec($curl);
    $results = json_decode($response, true);

    /* Получаем чекапы */

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL_SERVER.'/HealthcareServices/ServiceComplexList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $response_token_decode['access_token'],
            'Organization: B86530AD-BFAB-4899-8A0A-2BE5E9AF7852'
        ),
    ));

    $responseComplexList = curl_exec($curl);

    curl_close($curl);

    if (empty($results['Data'])) {
        http_response_code(400);
        wp_send_json_success('ошибка сервера');
    }

    $resultsServiceComplexList = json_decode($responseComplexList, true);

    foreach ($results['Data'] as &$itemFullPriceList) {
        // Skip items that are not active
        if (isset($itemFullPriceList['IsActive']) && !$itemFullPriceList['IsActive']) {
            continue;
        }

        foreach ($resultsServiceComplexList['Data'] as $itemComplexList) {
            if ($itemFullPriceList['Type'] == 'C') {
                if ($itemComplexList['ComplexServiceID'] === $itemFullPriceList['ServiceID']) {
                    $itemFullPriceList['ServicesItemsID'][] = $itemComplexList['ServiceID'];
                }
            }
        }
    }

    /* обновляем услуги с API */
    $service_arr_api = [];
    foreach ($results['Data'] as $item) {
        // Skip items that are not active
        if (isset($item['IsActive']) && !$item['IsActive']) {
            continue;
        }

        if ($item['Type'] == 'S') {
            $code = $item['ServiceCode'];
            $service_arr_api[$code] = [
                'name' => $item['ServiceName'],
                'code' => $code,
                'price' => round($item['Price']),
            ];
        }
    }
    $service_posts = get_posts(array(
        'post_type'   => 'api_services',
        'post_status' => array('publish', 'private'),
        'numberposts' => -1,
    ));
    $service_arr_wp = [];

    // Собираем данные услуг из WordPress
    $temp_item = 0;
    foreach ($service_posts as $post) {
        $temp_item++;
        $itemId = $post->ID;
        $current_status = $post->post_status;

        // Получаем все пользовательские поля одним запросом
        $fields = get_fields($itemId);

        $code = $fields['code_services'] ?? time().$temp_item;
        $price = round($fields['price_services'] ?? 0);

        $service_arr_wp[$code] = [
            'post_id'   => $post->ID,
            'name'      => $post->post_title,
            'price'     => $price,
            'status'    => $current_status,
        ];
    }

    // Проходим по услугам из WordPress и обновляем их на основе данных из API
    foreach ($service_arr_wp as $code => $service_wp) {
        $itemId = $service_wp['post_id'];
        $name = $service_wp['name'];
        $current_status = $service_wp['status'];

        if (isset($service_arr_api[$code])) {
            // Услуга существует в API
            // Обновляем наименование если оно изменилось
            if ($name != $service_arr_api[$code]['name']){
                wp_update_post(array('ID' => $itemId, 'post_title' => $service_arr_api[$code]['name']));
            }


            $api_price = $service_arr_api[$code]['price'];
            // Обновляем цену, если она изменилась
            if ($service_wp['price'] != $api_price) {
                update_field('price_services', $api_price, $itemId);
            }

            // Обновляем статус поста на 'publish', если он не опубликован
            if ($current_status != 'publish') {
                wp_update_post(array('ID' => $itemId, 'post_status' => 'publish'));
            }
            // Удаляем услугу из массива API, так как она обработана
            unset($service_arr_api[$code]);

        } else {
            // Услуга отсутствует в API

            // Обновляем статус поста на 'private', если он не скрыт
            if ($current_status != 'private') {
                wp_update_post(array('ID' => $itemId, 'post_status' => 'private'));
            }
        }
    }

    $cats = array();
    foreach ($results['Data'] as $cat) {
        $cats[$cat['ParentServiceID']][$cat['ServiceID']] = $cat;
    }

    function build_tree($cats, $parent_id)
    {
        $tree = [];
        if (is_array($cats) and isset($cats[$parent_id])) {
            foreach ($cats[$parent_id] as $cat) {
                if ($cat['Type'] == 'G') {
                    $key = $cat['ServiceName'] . '█' . $cat['ServiceID'] . '█' . $cat['Type'];
                }
                if ($cat['Type'] == 'C') {

                    $servicesItemsID = isset($cat['ServicesItemsID']) && is_array($cat['ServicesItemsID']) ? implode(";", $cat['ServicesItemsID']) : '';
                    $key = $cat['ServiceName'] . '█' . $cat['ServiceID'] . '█' . $cat['Type'] . '█' . $cat['ServiceCode'] . '█' . round($cat['Price']) . '█' . $servicesItemsID . '█' . ($cat['IsActive'] ? 1 : 0);
                }

                if ($cat['Type'] !== 'S') {
                    if (!empty(build_tree($cats, $cat['ServiceID'])) || $cat['ParentServiceID'] == -1) {
                        $tree [$key] = build_tree($cats, $cat['ServiceID']);
                    } else {
                        $tree [] = $key;
                    }
                }
            }
        }
        return $tree;
    }

    /* acf update */
    function updateAcfTermField($value, $termID)
    {
        $meta_arr_cat = [
            'field_619677ca7850d' => explodeApiItem($value)['ServiceID'],
            'field_6197994217d51' => explodeApiItem($value)['Type'],
            'field_6197996817d52' => explodeApiItem($value)['ServiceCode'],
            'field_619799ce17d53' => explodeApiItem($value)['Price'],
            'field_619799e317d54' => explodeApiItem($value)['ServicesItemsID'],
            'field_670e1efde5ade' => explodeApiItem($value)['IsActive'],
        ];

        foreach ($meta_arr_cat as $item => $name) {
            update_field($item, $name, 'api_services_taxonomy_' . $termID);
        }
    }

    function get_term_id_by_acf_field($acf_field_key, $acf_field_value, $taxonomy) {
        $args = array(
            'taxonomy' => $taxonomy,
//            'hide_empty' => false, // Показывать термины даже если у них нет постов
            'meta_query' => array(
                array(
                    'key' => $acf_field_key, // Ключ ACF поля
                    'value' => $acf_field_value, // Значение, по которому нужно искать
                    'compare' => '='
                )
            )
        );

        // Получаем термины по полю ACF
        $terms = get_terms($args);

        if (!empty($terms) && !is_wp_error($terms)) {
            // Возвращаем ID первого найденного термина
            return $terms[0];
        }

        return null; // Если не найдено, возвращаем null
    }

    function explodeApiItemTree($related_terms, $term_arr_id, $term_parent_id = 0)
    {
        $taxonomy_term = 'api_services_taxonomy';
        foreach ($related_terms as $key => $term) {
            if ($term_parent_id != 0) {
                if (!is_array($term)) {
                    $key = $term;
                }
            }

            $name = explodeApiItem($key)['ServiceName'];

            $api_id = explodeApiItem($key)['ServiceID'];

            // Check if the term already exists
//            $existing_term = term_exists($name, $taxonomy_term);
            $existing_term = get_term_id_by_acf_field('api_service_id', $api_id, $taxonomy_term);
            if ($existing_term) {
                if($existing_term->name != $name){
                    $args = array(
                        'name' => $name,
                    );
                    wp_update_term($existing_term->term_id, $taxonomy_term, $args);
                }
                $term_id = $existing_term->term_id;
            } else {
                $wp_insert_term_args = array(
                    'description' => explodeApiItem($key)['Type'],
                    'slug' => strval($name . '-' . $api_id)
                );
                if ($term_parent_id != 0) {
                    $wp_insert_term_args['parent'] = $term_parent_id;
                }
                $parent_term = wp_insert_term(
                    (string)$name,
                    $taxonomy_term,
                    $wp_insert_term_args
                );

                if (is_wp_error($parent_term)) {
                    $parent_term = term_exists($name, $taxonomy_term);
                }

                $term_id = $parent_term['term_id'];
            }

            $term_arr_id['term_id'][] = [
                'wp_id' => (int)$term_id,
                'api_id' => $api_id
            ];
            updateAcfTermField($key, $term_id);
            if (is_array($term)) {
                $term_arr_id = explodeApiItemTree($term, $term_arr_id, $term_id);
            }
        }

        return $term_arr_id;
    }

    function explodeApiItem($str): array
    {
        $resultExplode = explode("█", $str);

        return $result = [
            'ServiceName' => $resultExplode[0],
            'ServiceID' => $resultExplode[1],
            'Type' => $resultExplode[2],
            'ServiceCode' => $resultExplode[3],
            'Price' => $resultExplode[4],
            'ServicesItemsID' => $resultExplode[5],
            'IsActive' => $resultExplode[6],
        ];
    }

    $taxonomy_term = 'api_services_taxonomy';
    $term_arr_id = ['term_id' => []];

    $related_terms = build_tree($cats, -1);

    $term_arr_id = explodeApiItemTree($related_terms, $term_arr_id, 0);

    $service_arr = [];
    foreach ($results['Data'] as $item) {
        if ($item['Type'] == 'S' || $item['Type'] == 'C') {
            $service_arr[] = [
                'title' => $item['ServiceName'],
                'price' => round($item['Price']),
                'code' => $item['ServiceCode'],
                'ParentServiceID' => $item['ParentServiceID'],
                'ServiceID' => $item['ServiceID']
            ];
        }
    }
    if (!is_array($service_arr) || empty($service_arr)) {
        return false;
    }

    $arr_post_id = [];

    wp_defer_term_counting(false);

    foreach ($service_arr as $service) {
        $wp_id = null;
        $wp_id_first_parent = null;
        foreach ($term_arr_id['term_id'] as $term) {
            if ($service['ParentServiceID'] == $term['api_id']) {
                $wp_id = $term['wp_id'];
                $wp_id_first_parent = $term['wp_id'];
                break;
            }
        }

        $wp_term_arr = [$wp_id];

        while ($parent_id = wp_get_term_taxonomy_parent_id($wp_id, 'api_services_taxonomy')) {
            $wp_id = $parent_id;
            $wp_term_arr[] = $wp_id;
        }

        $service_slug = slugify($service['title'] . '-' . $service['code']);

        $existing_service = get_page_by_path($service_slug, 'OBJECT', 'api_services');

        if ($existing_service === null) {
            $inserted_service = wp_insert_post([
                'post_name' => $service_slug,
                'post_title' => slugify_title($service['title']),
                'post_status' => 'publish',
                'post_type' => 'api_services',
            ], true);

            $arr_post_id[] = $inserted_service;

            if (is_wp_error($inserted_service)) {
                echo $inserted_service->get_error_message();
            }

            if ($wp_term_arr) {
                wp_set_post_terms($inserted_service, $wp_term_arr, 'api_services_taxonomy');
            }

            if (is_wp_error($inserted_service) || $inserted_service === 0) {
                continue;
            }

            $meta_arr = [
                'field_617fd0fdc39aa' => $service['code'],
                'field_617fd12ec39ab' => $service['price'],
                'field_618d2f636a44a' => $wp_id_first_parent,
                'field_61967747d06da' => $service['ServiceID'],
            ];

            foreach ($meta_arr as $key => $name) {
                update_field($key, $name, $inserted_service);
            }
        } else {
            // Обновить доп поля для существующего поста
            $existing_service_id = $existing_service->ID;

            $meta_arr = [
                'code_services' => $service['code'],
                'price_services' => $service['price'],
                'first_parent_services' => $wp_id_first_parent,
                'id_service_api' => $service['ServiceID'],
            ];

            foreach ($meta_arr as $key => $value) {
                update_post_meta($existing_service_id, $key, $value);
            }
        }
    }
    wp_defer_comment_counting(false);

    function findTermTypeC($id, $term_id,$service_arr_wp)
    {
        $term_id = $id;
        $term = get_term_by('id', $term_id, 'api_services_taxonomy');
        $ids = get_field('api_services_items_id', $term);
        if (!empty($ids)) {
            $ids = explode(';', $ids);
        }
//        $args = [
//            'post_type' => 'api_services',
//            'posts_per_page' => -1,
//            'meta_query' => [
//                'relation' => 'OR',
//            ],
//        ];
//        if (!empty($ids)) {
//            foreach ($ids as $id) {
//                $args['meta_query'][] = [
//                    'key' => 'id_service_api',
//                    'value' => $id,
//                ];
//            }
//        }
//
//        $qwe = new WP_Query($args);
//        $return = [];
//        if (!empty($qwe->posts)) {
//            $return = $qwe->posts;
//        }

//        $type_c_post = [];
//        foreach ($return as $item) {
//            $type_c_post[] = $item->ID;
//        }

        $type_c_post = [];
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $type_c_post[] = $service_arr_wp[$id]['post_id'];
            }
        } else {
            $type_c_post[] = $service_arr_wp[$ids]['post_id'];
        }
        foreach ($type_c_post as $item) {
            wp_set_post_terms($item, $term_id, 'api_services_taxonomy', true);
        }

    }

    $taxonomy_id = [];

    $args = array(
        'hide_empty' => false,
    );

    $terms = get_terms('api_services_taxonomy', $args);

    foreach ($terms as $term) {
        if ($term->description === 'C') {
            $taxonomy_id[] = $term->term_id;
        }
    }

    foreach ($taxonomy_id as $term) {
        findTermTypeC($term, $term, $service_arr_wp);
    }

    wp_send_json_success('Импорт завершен');
}


add_action('wp_ajax_mia_get_filterd_posts', 'mia_get_filterd_posts');
add_action('wp_ajax_nopriv_mia_get_filterd_posts', 'mia_get_filterd_posts');

function mia_get_filterd_posts()
{
    if (!empty($_POST['args'])) {
        get_template_part('core/inc/components/all-price-ajax-search-group');
    } else {
        get_template_part('core/inc/components/all-price-ajax');
    }

}

function search_api_services($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_search) {
        $query->set('post_type', 'api_services');
    }
    return $query;
}

add_action('wp_ajax_mia_search_api_services', 'mia_search_api_services');
add_action('wp_ajax_nopriv_mia_search_api_services', 'mia_search_api_services');
function mia_search_api_services()
{
    global $wpdb;

    $search = $_GET['s'];
    $arr = array(
        'post_type' => 'api_services',
        'post_status' => 'publish',
        'order' => 'ASC',
        'posts_per_page' => -1,
        's' => $search,
    );
    $search_query = sanitize_text_field($_GET['s']);

    $checkups = $wpdb->get_results($wpdb->prepare("SELECT *
                    FROM nyksm_terms AS t
                    INNER JOIN nyksm_term_taxonomy AS tt
                    ON t.term_id = tt.term_id
                    WHERE tt.taxonomy IN ('api_services_taxonomy')
                    AND ((t.name LIKE '%$search_query%')
                    OR (t.slug LIKE '%$search_query%'))
                    and tt.description = 'C'
                    ORDER BY (t.term_id)"
    ));



    add_filter('pre_get_posts', 'search_api_services', 9999);
    $search_result = new WP_Query($arr);
    remove_filter('pre_get_posts', 'search_api_services', 9999);

    ob_start();
    ?>
    <div class="prise-block-item prise-block-item--white prise-block-item--grid">
        <div class="prise-block-item__title"><?php _e('Ничего не найдено') ?></div>
    </div>
    <?php
    $html = ob_get_clean();

    if (strlen($search) > 0) {
        if (!empty($search_result->posts)) {
            $groupAncestors = [];
            foreach ($search_result->posts as $item) {
                $firstParentServices = get_field('first_parent_services', $item->ID);
                $ancestors = array_reverse(get_ancestors($firstParentServices, 'api_services_taxonomy'));
                $ancestors[] = (int)$firstParentServices;

                $groupAncestors [] = [
                    'post_id' => $item->ID,
                    'parent_id' => $ancestors
                ];

            }

            $allTerm = [];

            foreach ($groupAncestors as $item) {
                foreach ($item['parent_id'] as $term) {
                    if (!in_array($term, $allTerm)) {
                        $allTerm[] = $term;
                    }
                }
            }

            global $allPost;
            $allPost = [];
            foreach ($groupAncestors as $postItem) {
                if (!in_array($postItem, $allPost)) {
                    $allPost[] = $postItem['post_id'];
                }
            }

            if(!empty($checkups)){
                $allTermTypeC = [];
                /* получаем все чекапы таксономий  */
                foreach ($checkups as $cId){
                    $allTermTypeC[] = (int)$cId->term_id;
                }

                /* получаем родителей такосномий  */
                foreach ($allTermTypeC as $item){
                    $allTermTypeCAll[] = (int)$item;
                    $allTermTypeCAll[] = get_ancestors($item, 'api_services_taxonomy');
                }

                /*приводим все к ономерному массиву  */
                $resultTypeCAll = [];
                array_walk_recursive($allTermTypeCAll, function ($item, $key) use ($resultTypeCAll) {
                    $resultTypeCAll[] = $item;
                });
            }

            /* Добавляем категориия с чекапами в общею массив с таксономия*/
            foreach ($resultTypeCAll as $item) {
                if (!in_array($item, $allTerm)) {
                    $allTerm[] = $item;
                }
            }


            $categories = get_terms('api_services_taxonomy', array('hide_empty' => false, 'include' => $allTerm));

            $cat_hierarchy = array();
            sort_terms_hierarchicaly($categories, $cat_hierarchy);


            function loopItemPrice($terms, $level)
            {
                global $allPost;

                $newargs = array(
                    'post_type' => 'api_services',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'post__in' => $allPost,
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


                <?php if($terms->description !== 'C'):?>
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
        }
        wp_send_json_success($html);

    } else {
        get_template_part('core/inc/components/all-price-ajax');
    }

}

add_action('init',function(){
    if(!empty($_GET['ss'])) {
        global $wpdb;
        $search_query = sanitize_text_field($_GET['ss']);
        $query = $wpdb->get_results($wpdb->prepare("SELECT *
                    FROM nyksm_terms AS t
                    INNER JOIN nyksm_term_taxonomy AS tt
                    ON t.term_id = tt.term_id
                    WHERE tt.taxonomy IN ('api_services_taxonomy')
                    AND ((t.name LIKE '%$search_query%')
                    OR (t.slug LIKE '%$search_query%'))
                    and tt.description = 'C'
                    ORDER BY (t.term_id)"
        ));

        $check_up = [];
        foreach ( $query as $idTypeC ) {
            $check_up[] = $idTypeC->term_id;
        }
        echo "<pre>".print_r($query,true)."</pre>";
        die();
    }
});
function mia_get_checkap($term_name){
    $args   = array(
        'taxonomy'               => array( 'api_services_taxonomy' ),
        'fields'                 => 'all',
        'description__like'      => 'C',
        'search'                 => $term_name,
    );

    $term_query = new WP_Term_Query( $args );
    $level = 3;
    if(!empty($term_query->terms)){
	    foreach ( $term_query->terms as $term ) {

        $arr = array(
            'post_type' => 'api_services',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'api_services_taxonomy',
                    'field' => 'id',
                    'terms' => $term->term_taxonomy_id
                ),
            )
        );
        $services = new WP_Query($arr);

    ?>

        <div class="prise-block-item prise-block-item--white prise-block-item--grid level-<?= $level ?>">
            <div class="prise-block-item__title"><?php echo $term->name ?></div>
            <div class="prise-block-item__code prise-block-item__content"><?php the_field('api_service_code',  'api_services_taxonomy_'.$term->term_id ); ?></div>
            <div class="prise-block-item__cine prise-block-item__content"><?php the_field('api_price', 'api_services_taxonomy_'.$term->term_id); ?> грн</div>
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
        }
}
add_action('manage_posts_extra_tablenav', 'add_extra_button');
function add_extra_button($where)
{
    global $post_type_object;
    if ($post_type_object->name === 'api_services') {
        echo '<button class="button js__import-for-api" type="button">Импорт услуг с API </button> <span class="spinner  float-none"></span>';
    }
}

add_action('admin_enqueue_scripts', 'action_function_name_9843');

function action_function_name_9843($hook_suffix)
{
    wp_enqueue_script('admin-js.js', get_template_directory_uri() . '/admin-js.js');
}


/**
 * [list_searcheable_acf list all the custom fields we want to include in our search query]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf()
{
    $list_searcheable_acf = array("code_services");
    return $list_searcheable_acf;
}


/**
 * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
 * @param  [query-part/string]      $where    [the initial "where" part of the search query]
 * @param  [object]                 $wp_query []
 * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function advanced_custom_search($where, $wp_query)
{

    global $wpdb;

    if (empty($where))
        return $where;

    // get search expression
    $terms = $wp_query->query_vars['s'];

    // explode search expression to get search terms
    $exploded = explode(' ', $terms);
    if ($exploded === FALSE || count($exploded) == 0)
        $exploded = array(0 => $terms);

    // reset search in order to rebuilt it as we whish
    $where = '';

    // get searcheable_acf, a list of advanced custom fields you want to search content in
    $list_searcheable_acf = list_searcheable_acf();

    foreach ($exploded as $tag) :
        $where .= " 
          AND (
            (nyksm_posts.post_title LIKE '%$tag%')
            OR (nyksm_posts.post_content LIKE '%$tag%')
            OR EXISTS (
              SELECT * FROM nyksm_postmeta
	              WHERE post_id = nyksm_posts.ID
	                AND (";

        foreach ($list_searcheable_acf as $searcheable_acf) :
            if ($searcheable_acf == $list_searcheable_acf[0]):
                $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
            else :
                $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
            endif;
        endforeach;

        $where .= ")
            )
            OR EXISTS (
              SELECT * FROM nyksm_comments
              WHERE comment_post_ID = nyksm_posts.ID
                AND comment_content LIKE '%$tag%'
            )
            OR EXISTS (
              SELECT * FROM nyksm_terms
              INNER JOIN nyksm_term_taxonomy
                ON nyksm_term_taxonomy.term_id = nyksm_terms.term_id
              INNER JOIN nyksm_term_relationships
                ON nyksm_term_relationships.term_taxonomy_id = nyksm_term_taxonomy.term_taxonomy_id
              WHERE (
          		taxonomy = 'post_tag'
            		or taxonomy = 'api_services_taxonomy'
          		)
              	AND object_id = nyksm_posts.ID
              	AND nyksm_terms.name LIKE '%$tag%'
            )
        )";
    endforeach;
    return $where;
}

add_filter('posts_search', 'advanced_custom_search', 500, 2);



