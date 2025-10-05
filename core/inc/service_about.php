<?php
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$service_about_arr = get_field('service_about', $term);
?>
<?php if(!empty($service_about_arr)): ?>
<div class="product-accordion">
    <?php  foreach ($service_about_arr as $item): ?>
    <div class="product-accordion-item">
        <div class="product-accordion-title"><?= $item['title']?><span class="close"></span></div>
        <div class="product-accordion-decr all-text"><?= $item['content']?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>