<?php get_header(); ?>

<?php
if (get_the_ID() != 1099) {
    ?>
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

                <li class="breadcrumb-item"><a href="/<?php echo LOCALE; ?>/uslugi"><?php
                        if (LOCALE == 'ru') {
                            echo 'Услуги';
                        } else if (LOCALE == 'ua') {
                            echo 'Послуги';
                        } else {
                            echo 'Services';
                        }
                        ?></a></li>

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
            </div>
            <div class="specials">
                <div class="specials__card rowFlex mb-65-85">
                    <div class="specials__card-img colFlex col-md-6">
                        <?php
                        $services_inside_img = CFS()->get('services_inside_img');
                        if ($services_inside_img == '') {
                            $services_inside_img = '/wp-content/uploads/no_photo1.png';
                        }
                        ?>
                        <img src="<?php echo $services_inside_img; ?>" alt="<?php the_title(); ?>">
                        <?php
                        global $post;
                        $content_parts = get_extended($post->post_content);
                        ?>
                        <div class="specials__card-text decr ">
                            <?php echo apply_filters('the_content', $content_parts['extended']); ?>
                        </div>
                    </div>
                    <div class="specials__card-text colFlex col-md-6">
                        <div class="specials__card-text-decr decr">
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
                                    ?></a><br><br>
                            <?php } ?>
                            <?php
                            echo apply_filters('the_content', $content_parts['main']);
                            ?>
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
                        $prices = get_field('price');
                        if (is_array($prices)) {
                            ?>
                            <div class="prise-block">
                                <div class="prise-block-header">
                                    <div class="prise-block-header__title"><?= 'ПЕРЕЛІК ПОСЛУГ' ?></div>
                                    <div class="prise-block-header__code"><?= 'Код' ?></div>
                                    <div class="prise-block-header__price"><?= 'ЦІНА (ГРН)' ?></div>
                                </div>
                                <div class="prise-block-response">
                                    <div class="indicator">
                                        <svg width="16px" height="12px">
                                            <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                                            <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <?php
                                        foreach ($prices as $price) {
                                            $newargs = array(
                                                'post_type' => 'api_services',
                                                'post_status' => 'publish',
                                                'posts_per_page' => -1,
                                                'meta_query' => array(
                                                    array(
                                                        'key' => 'first_parent_services',
                                                        'compare' => '=',
                                                        'value' => $price,
                                                    )
                                                )
                                            );
                                            $posts = new WP_Query($newargs);
                                            if ($posts->have_posts()) {

                                                while ($posts->have_posts()) : $posts->the_post();
                                                    ?>
                                                    <div class="prise-block-item prise-block-item--grid level-<?= $level ?>">
                                                        <div class="prise-block-item__title"><?php the_title(); ?></div>
                                                        <div class="prise-block-item__code prise-block-item__content"><?php the_field('code_services'); ?></div>
                                                        <div class="prise-block-item__cine prise-block-item__content"><?php the_field('price_services'); ?>
                                                            грн
                                                        </div>
                                                    </div>
                                                <?
                                                endwhile;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>


        <?php
        if (CFS()->get('seo3_text_title_' . LOCALE) != "" && CFS()->get('seo3_text_' . LOCALE) != "") {
            ?>
            <div class="bg-gray">
                <div class="container-fluid all-text">
                    <h4><?php echo CFS()->get('seo3_text_title_' . LOCALE); ?></h4>

                    <div class="all-text-column">
                        <?php echo apply_filters('the_content', CFS()->get('seo3_text_' . LOCALE)); ?>
                    </div>

                </div>
            </div>
        <?php } ?>
    </main>
<?php } else { ?>
    <main role="main" class="content">
        <section class="schedule">
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
                <div class="rowFlex jc-sb-md">
                    <div class="colFlex col-md-4">
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
                    </div>
                    <div class="colFlex col-md-7">
                        <form class="search-bar search-bar__js search-bar--lg" action="/" method="get"
                              autocomplete="off" novalidate>
                            <input type="text" name="s"
                                   value="<?php echo !empty($_GET['usluga']) ? $_GET['usluga'] : ''; ?>"
                                   class="search-input input_search"
                                   placeholder="Введіть,будь ласка, запит на українскій мові."
                                   autocomplete="off"
                                   required=""
                                   title=""
                            >
                            <button type="button" class="search-icon">
                                <svg class="svg-sprite-icon icon-searchForm">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core' ?>/images/svg/symbol/sprite.svg#searchForm"></use>
                                </svg>
                            </button>
                            <button class="search-close search-close__js ">
                                <svg class="svg-sprite-icon icon-crossM">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core' ?>/images/svg/symbol/sprite.svg#crossM"></use>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>


                <div class="rowFlex jc-sb-md">
                    <div class="colFlex col-md-4 prise-sidebar-wrap">

                        <?php
                        $categories = get_terms('api_services_taxonomy', array('hide_empty' => false));
                        $cat_hierarchy = array();
                        sort_terms_hierarchicaly($categories, $cat_hierarchy);

                        function has_posts_in_tree($category)
                        {
                            // Если в текущей категории есть посты, возвращаем true
                            if ($category->count > 0) {
                                return true;
                            }

                            // Если у категории есть дочерние категории, проверяем их рекурсивно
                            if (!empty($category->children)) {
                                foreach ($category->children as $child) {
                                    if (has_posts_in_tree($child)) {
                                        return true; // Если хотя бы в одной дочерней категории есть посты, возвращаем true
                                    }
                                }
                            }

                            // Если нет постов ни в текущей категории, ни в дочерних, возвращаем false
                            return false;
                        }

                        function render_category_list($categories, $depth = 0, $parent_ids = [])
                        {
                            foreach ($categories as $category) {
                                // Пропускаем главные категории, у которых нет дочерних и постов
                                if (($category->parent == 0 && !count($category->children)) || !has_posts_in_tree($category)) {
                                    continue;
                                }

                                // Создаем новый массив родителей, добавляя текущий ID категории
                                $current_parent_ids = $parent_ids;
                                if ($category->parent != 0) {
                                    $current_parent_ids[] = $category->parent;
                                }

                                // Проверка на наличие дочерних категорий или если это родительская категория
                                if ($category->parent == 0 || count($category->children)) {
                                    // Преобразуем массив родителей в строку
                                    $parent_ids_tree = implode(' ', array_reverse($current_parent_ids));

                                    // Выводим категорию с нужными атрибутами
                                    echo str_repeat("\t", $depth) . "<li class='parent-category' data-level='" . ($depth + 1) . "'>";
                                    echo "<span class='parent-category-dropdown' data-term-id='{$category->term_id}' data-term-id-tree='{$parent_ids_tree}' data-term-type='{$category->description}'>{$category->name}</span>";

                                    // Если есть дочерние категории, создаем вложенный список
                                    if (count($category->children)) {
                                        echo "<button class='parent-accordion-arrow'>
                        <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M8 10L12 14L16 10' stroke='#707E98' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                        </svg>
                      </button>";
                                        echo "<ul class='children' style='display: none;'>\n";

                                        // Рекурсивно выводим подкатегории с обновленным массивом родителей
                                        render_category_list($category->children, $depth + 1, $current_parent_ids);

                                        echo str_repeat("\t", $depth) . "</ul>\n";
                                    }

                                    echo "</li>\n";
                                } else {
                                    // Если у категории нет дочерних категорий, выводим как подкатегорию
                                    $parent_ids_tree = implode(' ', array_reverse($current_parent_ids));
                                    echo str_repeat("\t", $depth) . "<li class='sub-category i-dont-have-kids' data-level='" . ($depth + 1) . "'>";
                                    echo "<span data-term-id='{$category->term_id}' data-term-id-tree='{$parent_ids_tree}' data-term-type='{$category->description}'>{$category->name}</span>";
                                    echo "</li>\n";
                                }
                            }
                        }

                        function render_category_list_category_one($categories, $depth = 0)
                        {
                            foreach ($categories as $category) {
                                // Пропускаем главные категории, у которых нет дочерних и постов
                                if (($category->parent == 0 && !count($category->children)) || !has_posts_in_tree($category)) {
                                    continue;
                                }

                                // Получаем ID непосредственного родителя (если он есть)
                                $parent_id = $category->parent != 0 ? $category->parent : '';

                                // Проверка на наличие дочерних категорий или если это родительская категория
                                if ($category->parent == 0 || count($category->children)) {
                                    // Выводим категорию с нужными атрибутами
                                    echo str_repeat("\t", $depth) . "<li class='parent-category' data-level='" . ($depth + 1) . "'>";
                                    echo "<span class='parent-category-dropdown' data-term-id='{$category->term_id}' data-term-id-tree='{$parent_id}' data-term-type='{$category->description}'>{$category->name}</span>";

                                    // Если есть дочерние категории, создаем вложенный список
                                    if (count($category->children)) {
                                        echo "<button class='parent-accordion-arrow'>
                        <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M8 10L12 14L16 10' stroke='#707E98' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                        </svg>
                      </button>";
                                        echo "<ul class='children' style='display: none;'>\n";

                                        // Рекурсивно выводим подкатегории
                                        render_category_list($category->children, $depth + 1);

                                        echo str_repeat("\t", $depth) . "</ul>\n";
                                    }

                                    echo "</li>\n";
                                } else {
                                    // Если у категории нет дочерних категорий, выводим как подкатегорию
                                    echo str_repeat("\t", $depth) . "<li class='sub-category i-dont-have-kids' data-level='" . ($depth + 1) . "'>";
                                    echo "<span data-term-id='{$category->term_id}' data-term-id-tree='{$parent_id}' data-term-type='{$category->description}'>{$category->name}</span>";
                                    echo "</li>\n";
                                }
                            }
                        }
                        ?>

                        <div class="prise-sidebar">
                            <?php
                            echo "<ul class='prise-list '>\n";
                            render_category_list($cat_hierarchy);
                            echo "</ul>\n";
                            ?>
                        </div>

                        <div class="prise-sidebar-reset">
                            <button class="js__reset-filter btn-reset-filter  btn btn-t"><?= 'очистити' ?></button>
                        </div>
                        <div style="margin-top: 40px;">
                            <p><strong>Увага!</strong></p>
                            <p>Шановні відвідувачі, на сайті проходять технічні роботи.</p>
                            <p>Актуальність цін у прайсі, уточнюйте в нашому контакт-центрі за телефонами:</p>
                            <ul>
                                <li><a href="tel:380504020193">+38 (050) 402 01 93</a></li>
                                <li><a href="tel:380677207077">+38 (067) 720 70 77</a></li>
                                <li><a href="tel:380732592094">+38 (073) 259 20 94</a></li>
                            </ul>
                            <p>Дякуюємо за розуміння!</p>
                        </div>
                    </div>
                    <div class="colFlex col-md-8">
                        <div class="prise-block">
                            <div class="prise-block-header">
                                <div class="prise-block-header__title"><?= 'ПЕРЕЛІК ПОСЛУГ' ?></div>
                                <div class="prise-block-header__code"><?= 'Код' ?></div>
                                <div class="prise-block-header__price"><?= 'ЦІНА (ГРН)' ?></div>
                            </div>
                            <div class="prise-block-response">
                                <div class="indicator">
                                    <svg width="16px" height="12px">
                                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                                    </svg>
                                </div>
                                <div id="ajax-block">
                                    <?php get_template_part('core/inc/components/all-price'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
<?php } ?>
<?php get_footer(); ?>