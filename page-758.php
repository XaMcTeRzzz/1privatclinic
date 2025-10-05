<?php
get_header();

global $wpdb;
$table = $wpdb->prefix . 'dd_routines';

$search = isset($_GET['usluga']) ? trim($_GET['usluga']) : '';

if (!empty($search)) {
    $like = '%' . $wpdb->esc_like($search) . '%';
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE name LIKE %s",
        $like
    ), ARRAY_A);
} else {
    $results = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
}

// Групування
$grouped = [];
if (is_array($results)) {
    foreach ($results as $item) {
        $topLevel = $item['top_level_group_name'];
        $group = $item['group_name'];
        $grouped[$topLevel][$group][] = $item;
    }

    // Сортуємо послуги за назвою
    foreach ($grouped as $topLevel => $groups) {
        foreach ($groups as $group => $items) {
            usort($items, fn($a, $b) => $a['name'] <=> $b['name']);
            $grouped[$topLevel][$group] = $items;
        }
    }

    // Сортуємо групи за алфавітом
    foreach (array_keys($grouped) as $topLevelKey) {
        uksort($grouped[$topLevelKey], fn($a, $b) => strcmp($a, $b));
    }
}
?>

<main role="main" class="content">
    <section class="schedule">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/"><?php
                        echo (LOCALE === 'ru') ? 'Главная' : ((LOCALE === 'ua') ? 'Головна' : 'Home');
                        ?></a>
                </li>
                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>

            <div class="rowFlex jc-sb-md">
                <div class="colFlex col-md-5">
                    <div class="title wow" data-wow-delay="5s">
                        <div class="title-wrap">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="title-decor">
                            <svg width="70" height="20" viewBox="0 0 70 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="strokeGradient" x1="0" y1="0" x2="70" y2="0"
                                                    gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#04B8FE"></stop>
                                        <stop offset="100%" stop-color="#00DBA1"></stop>
                                    </linearGradient>
                                </defs>
                                <path d="M0 10H28L33 5L38 14L43 9H70" stroke="url(#strokeGradient)"
                                      stroke-width="2"></path>
                                <path d="M0 8H28L33 3L38 12L43 7H70" stroke="url(#strokeGradient)" stroke-width="1.5"
                                      opacity="0.6"></path>
                                <path d="M0 12H28L33 7L38 16L43 11H70" stroke="url(#strokeGradient)" stroke-width="1.5"
                                      opacity="0.4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="colFlex col-md-7">
                    <form class="search-bar search-bar__js search-bar--lg" action="vartist-posluh" method="get"
                          autocomplete="off" novalidate>
                        <input type="text" name="usluga"
                               value="<?php echo !empty($_GET['usluga']) ? $_GET['usluga'] : ''; ?>"
                               class="search-input"
                               placeholder="Введіть,будь ласка запит."
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

            <div class="rowFlex jc-sb-md mb-48-30">
                <div class="colFlex col-md-12">
                    <div class="prise-block">
                        <div class="prise-block-header">
                            <div class="prise-block-header__title">ПЕРЕЛІК ПОСЛУГ</div>
                            <div class="prise-block-header__code">Код</div>
                            <div class="prise-block-header__price">ЦІНА (ГРН)</div>
                        </div>
                        <div class="prise-block-response">
                            <div id="ajax-block">
                                <?php if (!empty($grouped)) : ?>
                                    <?php foreach ($grouped as $topLevelName => $groups): ?>
                                        <div class="prise-block-item-parent level-1 prise-block-toggle toggle-btn">
                                            <?= esc_html($topLevelName) ?>
                                        </div>
                                        <div class="group-content level-1-content">
                                            <?php foreach ($groups as $groupName => $services): ?>
                                                <div class="prise-block-item-parent level-2 prise-block-toggle toggle-btn">
                                                    <?= esc_html($groupName) ?>
                                                </div>
                                                <div class="group-content level-2-content">
                                                    <?php foreach ($services as $service): ?>
                                                        <div class="prise-block-item prise-block-item--white prise-block-item--grid level-3 toggle-btn">
                                                            <div class="prise-block-item__title"><?= esc_html($service['name']) ?></div>
                                                            <div class="prise-block-item__code prise-block-item__content"><?= esc_html($service['code']) ?></div>
                                                            <div class="prise-block-item__cine prise-block-item__content">
                                                                <?= $service['price'] !== null ? number_format($service['price'], 0) . ' грн' : '-' ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Дані не знайдено. Спробуйте пізніше або зверніться до адміністратора.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rowFlex">
                <div class="colFlex col-md-12">
                        <p>*Ціни на консультації та діагностику після 20.00 за подвійним тарифом</p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    const autoExpand = <?= !empty($_GET['usluga']) ? 'true' : 'false' ?>;
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtns = document.querySelectorAll('.toggle-btn');

        toggleBtns.forEach(function (btn) {
            const next = btn.nextElementSibling;

            if (!next || !next.classList.contains('group-content')) return;

            // Якщо пошук — одразу розгортаємо
            if (typeof autoExpand !== 'undefined' && autoExpand) {
                next.style.display = 'block';
            }

            // Ручне згортання/розгортання
            btn.addEventListener('click', function () {
                const isVisible = next.style.display === 'block';
                next.style.display = isVisible ? 'none' : 'block';
            });
        });
    });
</script>


<?php get_footer(); ?>
