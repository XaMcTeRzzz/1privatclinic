<?php
// Безопасная версия functions.php для диагностики

// Подключение основных стилей
function enqueue_theme_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/core/css/main.min.css');
    wp_enqueue_style('menu-style', get_template_directory_uri() . '/core/css/menu-2025-v2.css');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

// Подключение скриптов
function enqueue_theme_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/core/js/init-plugins.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// Поддержка меню
add_theme_support('menus');

// Поддержка миниатюр
add_theme_support('post-thumbnails');
