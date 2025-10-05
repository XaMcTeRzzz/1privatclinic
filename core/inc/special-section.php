<?php

    $featured_posts = get_field('object_special', 1976);
?>

<?php if ($featured_posts): ?>
    <section class="special">
        <div class="container-fluid">
            <div class="title"><?php echo _('Специальные предложения') ?></div>
            <div class="rowFlex">
                <?php foreach ($featured_posts as $post):
                    // Setup this post for WP functions (variable must be named $post).
                    setup_postdata($post);

                    $doctors = CFS()->get('services_add_doctors', $post->ID);

                    if (!empty($doctors)) {
                        $arrDoctors = [];
                        $arrDoctors[] = [
                            'text' => '',
                            'placeholder' => 'true'
                        ];
                        foreach ($doctors as $doctor) {
                            $arrDoctors[] = [
                                'value' => esc_html(get_the_title($doctor)),
                                'text' => esc_html(get_the_title($doctor))
                            ];
                        }
                        $selectValue = wp_json_encode($arrDoctors, JSON_UNESCAPED_UNICODE);
                    }

                    ?>
                    <div class="col-sm-6  col-lg-4 colFlex">
                        <div class="special-card">
                            <a href="<?php the_permalink(); ?>" class="special-card__img">
                                <img src="<?php the_post_thumbnail_url($post->ID); ?>" alt="<?php esc_html(the_title()) ?>">
                            </a>
                            <div class="special-card__main">
                                <div class="special-card__title"><?php esc_html(the_title())?></div>
                                <div class="special-card__content decr">
                                    <?php echo the_excerpt(); ?>
                                </div>
                                <div class="special-card__cost-row">
                                    <div class="special-card__new-price"><?php the_field('new_price') ?></div>
                                    <div class="special-card__old-price"><?php the_field('old_price') ?></div>
                                </div>
                            </div>
                            <div class="special-card__footer">
                                <a href="<?php the_permalink(); ?>" class="link-bubbles"><?php _e('подробнее','mz') ?></a>
                                <?php if (!empty($doctors)): ?>
                                    <a class="btn js__setToSelectDoctors"
                                       data-fancybox=""
                                       data-src="#sign-up-modal-doctors"
                                       data-doctors-json='<?php echo $selectValue ?>'
                                       href="javascript:;">
                                        <?php _e('записаться на приём','mz') ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- // Reset the global post object so that the rest of the page works correctly.-->
                <?php wp_reset_postdata(); ?>
            </div>
        </div>

    </section>
<?php endif; ?>


<?php get_template_part('core/inc/modal-doctors') ?>