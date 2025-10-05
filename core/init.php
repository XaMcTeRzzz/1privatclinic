<?php

//Define locale
if (get_locale() == 'en_US') {
    define('LOCALE', 'en');
} else if (get_locale() == 'uk') {
    define('LOCALE', 'ua');
} else {
    define('LOCALE', 'ru');
}

function include_css() {
    $css_uri = get_template_directory_uri() . '/core/css/';
    wp_enqueue_style('main', $css_uri . 'main.min.css', '', '15');
    wp_enqueue_style('dev', $css_uri . 'dev.css', '', '15');
}

add_action('wp_enqueue_scripts', 'include_css');

add_action( 'init', 'true_jquery_register' );

function true_jquery_register() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', ( get_template_directory_uri() . '/core/js/jquery.min.js' ), false, null, true );
        wp_enqueue_script( 'jquery' );
    }
}

function include_js() {
    $js_uri = get_template_directory_uri() . '/core/build-js/';
    $js_uri_dev = get_template_directory_uri() . '/core/js/';
    wp_enqueue_script('libs.min.js', $js_uri . 'libs.min.js', array(), null, true);
    wp_enqueue_script( 'scripts.min.js',  $js_uri . 'scripts.min.js', array(), null, true);
    wp_enqueue_script( 'rebuild-banner-slider.js',  $js_uri_dev . 'rebuild-banner-slider.js', array('scripts.min.js'), null, true);
    wp_enqueue_script( 'simple-banner-clicks.js',  $js_uri_dev . 'simple-banner-clicks.js', array('jquery'), null, true);
    wp_localize_script( 'scripts.min.js', 'get_locale', array( 'locale' => LOCALE ) );
}




add_action('wp_enqueue_scripts', 'include_js');

// Enable image support for posts
add_theme_support( 'post-thumbnails' );

add_post_type_support( 'page', 'excerpt' );
