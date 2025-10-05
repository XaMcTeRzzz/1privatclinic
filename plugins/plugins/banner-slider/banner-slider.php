<?php
/**
 * Plugin Name: Banner Slider
 * Plugin URI: https://yourwebsite.com/banner-slider
 * Description: Кастомный баннерный слайдер с возможностью добавления ссылок к изображениям
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: banner-slider
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Banner Slider Class
 */
class Banner_Slider_Plugin {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('acf/init', array($this, 'register_acf_fields'));
        add_shortcode('banner_slider', array($this, 'render_slider'));
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain('banner-slider', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Initialize plugin
     */
    public function init() {
        // Plugin initialization code
    }

    /**
     * Register ACF fields
     */
    public function register_acf_fields() {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        // Register field group for banner slider
        acf_add_local_field_group(array(
            'key' => 'group_banner_slider',
            'title' => __('Настройки баннерного слайдера', 'banner-slider'),
            'fields' => array(
                array(
                    'key' => 'field_banner_images',
                    'label' => __('Изображения баннера', 'banner-slider'),
                    'name' => 'banner_images',
                    'type' => 'repeater',
                    'instructions' => __('Добавьте изображения для баннерного слайдера', 'banner-slider'),
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => __('Добавить изображение', 'banner-slider'),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_banner_image',
                            'label' => __('Изображение', 'banner-slider'),
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_banner_link',
                            'label' => __('Ссылка', 'banner-slider'),
                            'name' => 'link',
                            'type' => 'url',
                            'instructions' => __('URL для перехода при клике на изображение (оставьте пустым, если ссылка не нужна)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'https://example.com',
                        ),
                        array(
                            'key' => 'field_banner_title',
                            'label' => __('Заголовок', 'banner-slider'),
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => __('Заголовок изображения (для доступности)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_slider_settings',
                    'label' => __('Настройки слайдера', 'banner-slider'),
                    'name' => 'slider_settings',
                    'type' => 'group',
                    'instructions' => __('Настройки поведения слайдера', 'banner-slider'),
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'row',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_slides_per_view',
                            'label' => __('Количество видимых слайдов', 'banner-slider'),
                            'name' => 'slides_per_view',
                            'type' => 'number',
                            'instructions' => __('Количество изображений, видимых одновременно (по умолчанию: 3)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 3,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 1,
                            'max' => 10,
                            'step' => 1,
                        ),
                        array(
                            'key' => 'field_space_between',
                            'label' => __('Отступ между слайдами (px)', 'banner-slider'),
                            'name' => 'space_between',
                            'type' => 'number',
                            'instructions' => __('Расстояние между изображениями в пикселях (по умолчанию: 20)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 20,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ),
                        array(
                            'key' => 'field_slider_height',
                            'label' => __('Высота слайдера (px)', 'banner-slider'),
                            'name' => 'slider_height',
                            'type' => 'number',
                            'instructions' => __('Высота контейнера слайдера в пикселях (по умолчанию: 300)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 300,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 100,
                            'max' => 800,
                            'step' => 10,
                        ),
                        array(
                            'key' => 'field_enable_autoplay',
                            'label' => __('Включить автопрокрутку', 'banner-slider'),
                            'name' => 'enable_autoplay',
                            'type' => 'true_false',
                            'instructions' => __('Автоматически переключать слайды', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => __('Включено', 'banner-slider'),
                            'ui_off_text' => __('Отключено', 'banner-slider'),
                        ),
                        array(
                            'key' => 'field_autoplay_delay',
                            'label' => __('Задержка автопрокрутки (мс)', 'banner-slider'),
                            'name' => 'autoplay_delay',
                            'type' => 'number',
                            'instructions' => __('Время между автоматическими переключениями в миллисекундах (по умолчанию: 5000)', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_enable_autoplay',
                                        'operator' => '==',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 5000,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 1000,
                            'max' => 10000,
                            'step' => 500,
                        ),
                        array(
                            'key' => 'field_show_navigation',
                            'label' => __('Показывать кнопки навигации', 'banner-slider'),
                            'name' => 'show_navigation',
                            'type' => 'true_false',
                            'instructions' => __('Показывать стрелочки для ручного переключения', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 1,
                            'ui' => 1,
                            'ui_on_text' => __('Показывать', 'banner-slider'),
                            'ui_off_text' => __('Скрыть', 'banner-slider'),
                        ),
                        array(
                            'key' => 'field_enable_touch',
                            'label' => __('Разрешить перетаскивание касаниями', 'banner-slider'),
                            'name' => 'enable_touch',
                            'type' => 'true_false',
                            'instructions' => __('Разрешить перетаскивание пальцем на мобильных устройствах', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => __('Разрешить', 'banner-slider'),
                            'ui_off_text' => __('Запретить', 'banner-slider'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mobile_images',
                    'label' => __('Мобильные изображения', 'banner-slider'),
                    'name' => 'mobile_images',
                    'type' => 'repeater',
                    'instructions' => __('Отдельные изображения для мобильных устройств (если не заполнены, будут использоваться основные изображения)', 'banner-slider'),
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => __('Добавить мобильное изображение', 'banner-slider'),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mobile_image',
                            'label' => __('Мобильное изображение', 'banner-slider'),
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_mobile_link',
                            'label' => __('Ссылка', 'banner-slider'),
                            'name' => 'link',
                            'type' => 'url',
                            'instructions' => __('URL для перехода при клике на мобильное изображение', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'https://example.com',
                        ),
                        array(
                            'key' => 'field_mobile_title',
                            'label' => __('Заголовок', 'banner-slider'),
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => __('Заголовок мобильного изображения', 'banner-slider'),
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'banner-slider-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }

    /**
     * Enqueue plugin assets
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'banner-slider-css',
            plugins_url('assets/css/banner-slider.css', __FILE__),
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'assets/css/banner-slider.css')
        );

        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
            array('jquery'),
            '8.0.0',
            true
        );

        wp_enqueue_script(
            'banner-slider-js',
            plugins_url('assets/js/banner-slider.js', __FILE__),
            array('jquery', 'swiper-js'),
            filemtime(plugin_dir_path(__FILE__) . 'assets/js/banner-slider.js'),
            true
        );

        // Localize script for AJAX
        wp_localize_script('banner-slider-js', 'banner_slider_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('banner_slider_nonce')
        ));
    }

    /**
     * Render banner slider shortcode
     */
    public function render_slider($atts) {
        $atts = shortcode_atts(array(
            'id' => 'banner-slider-' . uniqid(),
        ), $atts);

        // Get slider data from ACF options
        $images = get_field('banner_images', 'option');
        $mobile_images = get_field('mobile_images', 'option');
        $settings = get_field('slider_settings', 'option');

        if (!$images && !$mobile_images) {
            return '<p>' . __('Добавьте изображения в настройках баннерного слайдера', 'banner-slider') . '</p>';
        }

        // Set default settings
        $slides_per_view = isset($settings['slides_per_view']) ? $settings['slides_per_view'] : 3;
        $space_between = isset($settings['space_between']) ? $settings['space_between'] : 20;
        $slider_height = isset($settings['slider_height']) ? $settings['slider_height'] : 300;
        $enable_autoplay = isset($settings['enable_autoplay']) ? $settings['enable_autoplay'] : false;
        $autoplay_delay = isset($settings['autoplay_delay']) ? $settings['autoplay_delay'] : 5000;
        $show_navigation = isset($settings['show_navigation']) ? $settings['show_navigation'] : true;
        $enable_touch = isset($settings['enable_touch']) ? $settings['enable_touch'] : false;

        ob_start();
        ?>
        <div class="banner-slider-container" id="<?php echo esc_attr($atts['id']); ?>">
            <!-- Desktop Slider -->
            <?php if ($images): ?>
            <div class="banner-slider-wrapper desktop-slider">
                <div class="swiper-container banner-slider" style="height: <?php echo esc_attr($slider_height); ?>px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $index => $image_data): ?>
                        <div class="swiper-slide">
                            <div class="banner-slider-item">
                                <?php if (!empty($image_data['link'])): ?>
                                    <a href="<?php echo esc_url($image_data['link']); ?>" class="banner-slide-link" <?php echo (!empty($image_data['title']) ? 'title="' . esc_attr($image_data['title']) . '"' : ''); ?>>
                                        <img src="<?php echo esc_url($image_data['image']['url']); ?>"
                                             alt="<?php echo esc_attr($image_data['image']['alt'] ?: $image_data['title'] ?: __('Изображение баннера', 'banner-slider')); ?>"
                                             width="<?php echo esc_attr($image_data['image']['width']); ?>"
                                             height="<?php echo esc_attr($image_data['image']['height']); ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo esc_url($image_data['image']['url']); ?>"
                                         alt="<?php echo esc_attr($image_data['image']['alt'] ?: $image_data['title'] ?: __('Изображение баннера', 'banner-slider')); ?>"
                                         width="<?php echo esc_attr($image_data['image']['width']); ?>"
                                         height="<?php echo esc_attr($image_data['image']['height']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($show_navigation): ?>
                    <div class="banner-navigation">
                        <div class="swiper-button-prev banner-slider-prev">
                            <span>&lt;</span>
                        </div>
                        <div class="swiper-button-next banner-slider-next">
                            <span>&gt;</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Mobile Slider -->
            <?php if ($mobile_images): ?>
            <div class="banner-slider-wrapper mobile-slider">
                <div class="swiper-container banner-slider mobile" style="height: <?php echo esc_attr($slider_height); ?>px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($mobile_images as $index => $image_data): ?>
                        <div class="swiper-slide">
                            <div class="banner-slider-item">
                                <?php if (!empty($image_data['link'])): ?>
                                    <a href="<?php echo esc_url($image_data['link']); ?>" class="banner-slide-link" <?php echo (!empty($image_data['title']) ? 'title="' . esc_attr($image_data['title']) . '"' : ''); ?>>
                                        <img src="<?php echo esc_url($image_data['image']['url']); ?>"
                                             alt="<?php echo esc_attr($image_data['image']['alt'] ?: $image_data['title'] ?: __('Мобильное изображение баннера', 'banner-slider')); ?>"
                                             width="<?php echo esc_attr($image_data['image']['width']); ?>"
                                             height="<?php echo esc_attr($image_data['image']['height']); ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo esc_url($image_data['image']['url']); ?>"
                                         alt="<?php echo esc_attr($image_data['image']['alt'] ?: $image_data['title'] ?: __('Мобильное изображение баннера', 'banner-slider')); ?>"
                                         width="<?php echo esc_attr($image_data['image']['width']); ?>"
                                         height="<?php echo esc_attr($image_data['image']['height']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($show_navigation): ?>
                    <div class="banner-navigation">
                        <div class="swiper-button-prev banner-slider-prev">
                            <span>&lt;</span>
                        </div>
                        <div class="swiper-button-next banner-slider-next">
                            <span>&gt;</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Desktop slider initialization
            <?php if ($images): ?>
            var desktopSlider = new Swiper('#<?php echo esc_attr($atts['id']); ?> .banner-slider:not(.mobile)', {
                loop: false,
                autoplay: <?php echo $enable_autoplay ? '{ delay: ' . $autoplay_delay . ' }' : 'false'; ?>,
                speed: 600,
                slidesPerView: <?php echo esc_attr($slides_per_view); ?>,
                slidesPerGroup: 1,
                spaceBetween: <?php echo esc_attr($space_between); ?>,
                centeredSlides: false,
                direction: 'horizontal',
                effect: 'slide',
                allowTouchMove: <?php echo $enable_touch ? 'true' : 'false'; ?>,
                simulateTouch: false,
                grabCursor: false,
                watchOverflow: true,
                rewind: true,
                keyboard: false,
                mousewheel: false,
                touchRatio: <?php echo $enable_touch ? '1' : '0'; ?>,
                touchAngle: 90,
                preventInteractionOnTransition: false,
                touchMoveStopPropagation: false,
                followFinger: false,
                navigation: <?php echo $show_navigation ? '{
                    nextEl: "#' . esc_attr($atts['id']) . ' .banner-slider-next",
                    prevEl: "#' . esc_attr($atts['id']) . ' .banner-slider-prev"
                }' : 'false'; ?>,
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        allowTouchMove: <?php echo $enable_touch ? 'true' : 'false'; ?>
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                        allowTouchMove: <?php echo $enable_touch ? 'true' : 'false'; ?>
                    },
                    1024: {
                        slidesPerView: <?php echo esc_attr($slides_per_view); ?>,
                        spaceBetween: <?php echo esc_attr($space_between); ?>,
                        allowTouchMove: <?php echo $enable_touch ? 'true' : 'false'; ?>
                    }
                }
            });

            // Block dragging but allow link clicks
            $('#<?php echo esc_attr($atts['id']); ?> .banner-slider .swiper-wrapper, #<?php echo esc_attr($atts['id']); ?> .banner-slider .swiper-slide').on('mousedown touchstart', function(e) {
                if ($(e.target).closest('.banner-slide-link').length > 0) {
                    return true;
                }
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            $('#<?php echo esc_attr($atts['id']); ?> .banner-slider .swiper-wrapper, #<?php echo esc_attr($atts['id']); ?> .banner-slider .swiper-slide').on('dragstart selectstart', function(e) {
                if ($(e.target).closest('.banner-slide-link').length > 0) {
                    return true;
                }
                e.preventDefault();
                return false;
            });
            <?php endif; ?>

            // Mobile slider initialization (only if mobile images exist)
            <?php if ($mobile_images): ?>
            var mobileSlider = new Swiper('#<?php echo esc_attr($atts['id']); ?> .banner-slider.mobile', {
                loop: false,
                autoplay: <?php echo $enable_autoplay ? '{ delay: ' . $autoplay_delay . ' }' : 'false'; ?>,
                speed: 600,
                slidesPerView: 1,
                spaceBetween: 10,
                direction: 'horizontal',
                effect: 'slide',
                allowTouchMove: <?php echo $enable_touch ? 'true' : 'false'; ?>,
                simulateTouch: false,
                grabCursor: false,
                watchOverflow: true,
                rewind: true,
                keyboard: false,
                mousewheel: false,
                touchRatio: <?php echo $enable_touch ? '1' : '0'; ?>,
                touchAngle: 90,
                preventInteractionOnTransition: false,
                touchMoveStopPropagation: false,
                followFinger: false,
                navigation: <?php echo $show_navigation ? '{
                    nextEl: "#' . esc_attr($atts['id']) . ' .banner-slider-next",
                    prevEl: "#' . esc_attr($atts['id']) . ' .banner-slider-prev"
                }' : 'false'; ?>
            });
            <?php endif; ?>
        });
        </script>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new Banner_Slider_Plugin();

/**
 * Add settings page to admin menu
 */
add_action('admin_menu', 'banner_slider_add_admin_menu');
add_action('admin_init', 'banner_slider_settings_init');

function banner_slider_add_admin_menu() {
    add_options_page(
        __('Баннерный слайдер', 'banner-slider'),
        __('Баннерный слайдер', 'banner-slider'),
        'manage_options',
        'banner-slider-settings',
        'banner_slider_options_page'
    );
}

function banner_slider_settings_init() {
    register_setting('banner_slider_settings', 'banner_slider_settings');

    add_settings_section(
        'banner_slider_settings_section',
        __('Настройки баннерного слайдера', 'banner-slider'),
        'banner_slider_settings_section_callback',
        'banner_slider_settings'
    );
}

function banner_slider_settings_section_callback() {
    echo __('Настройте изображения и поведение баннерного слайдера', 'banner-slider');
}

function banner_slider_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Баннерный слайдер', 'banner-slider'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('banner_slider_settings');
            do_settings_sections('banner_slider_settings');
            ?>
            <div class="acf-fields">
                <?php
                // Display ACF fields
                if (function_exists('acf_form')) {
                    acf_form(array(
                        'post_id' => 'options',
                        'form' => true,
                        'return' => admin_url('admin.php?page=banner-slider-settings'),
                        'submit_value' => __('Сохранить настройки', 'banner-slider')
                    ));
                }
                ?>
            </div>
        </form>

        <div class="banner-slider-usage">
            <h2><?php _e('Использование', 'banner-slider'); ?></h2>
            <p><?php _e('Для отображения баннерного слайдера в нужном месте добавьте шорткод:', 'banner-slider'); ?></p>
            <code>[banner_slider]</code>
            <p><?php _e('Или используйте в PHP коде:', 'banner-slider'); ?></p>
            <code>&lt;?php echo do_shortcode('[banner_slider]'); ?&gt;</code>
        </div>
    </div>
    <?php
}
?>
