<?php

add_action( 'init', 'register_specializations_taxonomy' );

function register_specializations_taxonomy () {
	register_taxonomy('specializations', 'doctor', array(
		'labels' => array(
			'name' => 'Специализации',
			'singular_name'     => 'Специализации',
			'search_items'      => 'Поиск по специализациям',
			'all_items'         => 'Все специализации',
			'edit_item'         => 'Редактировать специализацию',
			'update_item'       => 'Обновить специализацию',
			'add_new_item'      => 'Добавить новую специализацию',
			'new_item_name'     => 'Новая специализация',
			'menu_name'         => 'Специализации',
		),
		'hierarchical' => true,
		'sort' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'doc' ),
	));
}

add_action( 'init', 'create_doctor_post_type' );

function create_doctor_post_type () {
	$labels = array(
		'name' => 'Врачи',
		'singular_name' => 'Врач',
		'add_new' => 'Добавить нового врача',
		'add_new_item' => 'Добавление нового врача',
		'edit_item' => 'Редактировать врача',
		'new_item' => 'Новый врач',
		'view_item' => 'Просмотр врачей',
		'not_found' => 'Врач не найден'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'taxonomies' => array('specializations'),
		'rewrite' => array('slug' => 'team-view','with_front' => false),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('doctor', $args);
}

add_action( 'init', 'create_specials_post_type');

function create_specials_post_type () {
	$labels = array(
		'name' => 'Акции, спец. предложения',
		'singular_name' => 'Спец. предложение',
		'add_new' => 'Добавить спец. предложение',
		'add_new_item' => 'Добавление спец. предложения',
		'edit_item' => 'Редактировать спец. предложение',
		'new_item' => 'Новое спец. предложение',
		'view_item' => 'Просмотр спец. предложений',
		'not_found' => 'Спец. предложения не найдены'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('specials', $args);
}

add_action( 'init', 'create_services_post_type');

function create_services_post_type () {
	$labels = array(
		'name' => 'Услуги',
		'singular_name' => 'Услуга',
		'add_new' => 'Добавить услугу',
		'add_new_item' => 'Добавление услуги',
		'edit_item' => 'Редактировать услугу',
		'new_item' => 'Новая услуга',
		'view_item' => 'Просмотр услуг',
		'not_found' => 'Услуга не найдена'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'uslugi' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('services', $args);
}

add_action( 'init', 'create_analysis_post_type');

function create_analysis_post_type () {
	$labels = array(
		'name' => 'Анализы',
		'singular_name' => 'Анализ',
		'add_new' => 'Добавить анализ',
		'add_new_item' => 'Добавление анализа',
		'edit_item' => 'Редактировать анализ',
		'new_item' => 'Новый анализ',
		'view_item' => 'Просмотр анализов',
		'not_found' => 'Анализы не найдены'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'analizy' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('analysis', $args);
}

add_action( 'init', 'register_blog_taxonomy' );

function register_blog_taxonomy () {
	register_taxonomy('blog', 'blog', array(
		'labels' => array(
			'name' => 'Разделы блога',
			'singular_name'     => 'Раздел блога',
			'search_items'      => 'Поиск по разделам блога',
			'all_items'         => 'Все разделы блога',
			'edit_item'         => 'Редактировать раздел блога',
			'update_item'       => 'Обновить раздел блога',
			'add_new_item'      => 'Добавить новый раздел блога',
			'new_item_name'     => 'Новаый раздел блога',
			'menu_name'         => 'Разделы блога',
		),
		'hierarchical' => true,
		'sort' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'category' ),
	));
}

add_action( 'init', 'create_blog_post_type' );

function create_blog_post_type () {
	$labels = array(
		'name' => 'Блог',
		'singular_name' => 'Блог',
		'add_new' => 'Добавить новую запись',
		'add_new_item' => 'Добавление новой записи',
		'edit_item' => 'Редактировать запись',
		'new_item' => 'Новая запись',
		'view_item' => 'Просмотр записи блога',
		'not_found' => 'Записи не найдены'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'taxonomies' => array('blog'),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('article', $args);
}

// ============== REMOVING SLUG FROM ARTICLE POST TYPE ============== //
function gp_remove_cpt_slug( $post_link, $post ) {

	if ( 'article' === $post->post_type && 'publish' === $post->post_status ) {
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	}

	return $post_link;
}

add_filter( 'post_type_link', 'gp_remove_cpt_slug', 10, 2 );

function na_parse_request( $query ) {

	if ( ! $query->is_main_query()) {
		return;
	}

	if ( ! empty( $query->query['name'] ) ) {
		$query->set( 'post_type', array( 'doctor', 'specials', 'services' ,'analysis' , 'article' ,'equipment' , 'reviews', 'jobs') );
	}
}

add_action( 'pre_get_posts', 'na_parse_request' );



function gp_add_cpt_post_names_to_main_query( $query ) {

	// Bail if this is not the main query.
	if ( ! $query->is_main_query() ) {
		return;
	}

	// Bail if this query doesn't match our very specific rewrite rule.
	if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
		return;
	}

	// Bail if we're not querying based on the post name.
	if ( empty( $query->query['name'] ) ) {
		return;
	}

	// Add CPT to the list of post types WP will include when it queries based on the post name.
	$query->set( 'post_type', array( 'post', 'page', 'article' ) );
}

add_action( 'pre_get_posts', 'gp_add_cpt_post_names_to_main_query' );

// ============== ================================== ============== //

add_action( 'init', 'create_equipment_post_type');

function create_equipment_post_type () {
	$labels = array(
		'name' => 'Оборудование',
		'singular_name' => 'Оборудование',
		'add_new' => 'Добавить оборудование',
		'add_new_item' => 'Добавление оборудования',
		'edit_item' => 'Редактировать оборудование',
		'new_item' => 'Новое оборудование',
		'view_item' => 'Просмотр оборудования',
		'not_found' => 'Оборудование не найдено'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'oborudovanie' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('equipment', $args);
}

add_action( 'init', 'create_reviews_post_type');

function create_reviews_post_type () {
	$labels = array(
		'name' => 'Отзывы',
		'singular_name' => 'Отзыв',
		'add_new' => 'Добавить отзыв',
		'add_new_item' => 'Добавление отзыва',
		'edit_item' => 'Редактировать отзыв',
		'new_item' => 'Новый отзыв',
		'view_item' => 'Просмотр отзыва',
		'not_found' => 'Отзывы не найдены'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'otzyvy' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('reviews', $args);
}

add_action( 'init', 'create_jobs_post_type');

function create_jobs_post_type () {
	$labels = array(
		'name' => 'Вакансии',
		'singular_name' => 'Вакансия',
		'add_new' => 'Добавить вакансию',
		'add_new_item' => 'Добавление вакансии',
		'edit_item' => 'Редактировать вакансию',
		'new_item' => 'Новая вакансия',
		'view_item' => 'Просмотр вакансии',
		'not_found' => 'Вакансии не найдены'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'vakansii' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type('jobs', $args);
}