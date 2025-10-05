<?php get_header(); ?>
<?php
$s    = get_search_query();
$args = array(
  's' => $s
);
// The Query
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
  ?>
  <main role="main" class="content">
    <div class="search-page">
      <div class="container-fluid">
        <div class="rowFlex">
          <div class="colFlex col-md-12">
            <div class="title-sm-bolt">Результаты поиска: <?php echo get_query_var('s'); ?></div>
            <ol>
              <?php
              while ($the_query->have_posts()) {
                $the_query->the_post();
                ?>
                <li>
                  <a style="color: #000;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
              <?php } ?>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php
  wp_reset_postdata();
} else {
  ?>
  <main role="main" class="content">
    <div class="search-page">
      <div class="container-fluid">
        <div class="rowFlex">
          <div class="colFlex col-md-6">
            <div class="title-sm-bolt">Извините, по вашему запросу ничего не найдено</div>
  
            <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
            
<!--            <form class="search-bar search-bar--lg" action="/">-->
<!--              <input type="text" name="s" class="search-input" placeholder="поиск..." required>-->
<!--              <button type="submit" class="search-icon">-->
<!--                <svg class="svg-sprite-icon icon-searchForm">-->
<!--                  <use-->
<!--                    xlink:href="--><?php //echo get_template_directory_uri() . '/core/' ?><!--images/svg/symbol/sprite.svg#searchForm"></use>-->
<!--                </svg>-->
<!--              </button>-->
<!--              <button class="search-close" type="reset">-->
<!--                <svg class="svg-sprite-icon icon-crossM">-->
<!--                  <use-->
<!--                    xlink:href="--><?php //echo get_template_directory_uri() . '/core/' ?><!--images/svg/symbol/sprite.svg#crossM"></use>-->
<!--                </svg>-->
<!--              </button>-->
<!--            </form>-->
            <div class="search-page__row">
              <?php
              $hints = CFS()->get('hints', 1127);
              foreach ($hints as $hint) {
                  $value = $hint['hint_' . LOCALE];
                  if (empty($value) || $value == '') {
                      $value = $hint['hint_ru'];
                  }
              ?>
              <a class="link-back hint-link" href="javascript:void(0);"><?php echo $value; ?></a>
              <?php } ?>
            </div>
          </div>
          <div class="colFlex col-md-6 d-none d-md-block">
            <div class="search-page-img">
              <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/search-bg.svg"
                   alt="Извините, по вашему запросу ничего не найден">
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php } ?>
<?php get_footer(); ?>