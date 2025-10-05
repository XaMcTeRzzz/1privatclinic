<?php
$blog_menu = get_categories(['taxonomy' => 'blog', 'hide_empty' => 0]);
$terms = get_the_terms(get_the_ID(), 'blog');
$term_id = $terms[0]->term_id;


if ($blog_menu) {
?>

<ul class="list-doctors">
    <?php
    foreach ($blog_menu as $menu) {
    ?>
    <li class="list-doctors__item">
        <a href="<?php echo get_term_link($menu->term_id, 'blog') ?>"
           class="list-doctors__item-link <?php if (stristr($_SERVER['REQUEST_URI'], $menu->slug) || $menu->term_id == $term_id) echo 'active'; ?>"><?php echo strip_tags(apply_filters('the_content', $menu->name)); ?>
        </a>
    </li>
    <?php } ?>
</ul>

<?php } ?>