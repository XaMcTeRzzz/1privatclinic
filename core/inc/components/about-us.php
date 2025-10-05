<div class="container-fluid">
    <div class="rowFlex mb-48-30">
        <div class="colFlex col-md-7">
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?php _e('Перша приватна лікарня', 'mz') ?></h1>
                </div>
                <div class="title-decor">
                    <svg width="70" height="20" viewBox="0 0 70 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="strokeGradient" x1="0" y1="0" x2="70" y2="0" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#04B8FE"/>
                                <stop offset="100%" stop-color="#00DBA1"/>
                            </linearGradient>
                        </defs>

                        <path d="M0 10H28L33 5L38 14L43 9H70" stroke="url(#strokeGradient)" stroke-width="2"/>

                        <path d="M0 8H28L33 3L38 12L43 7H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.6"/>
                        <path d="M0 12H28L33 7L38 16L43 11H70" stroke="url(#strokeGradient)" stroke-width="1.5" opacity="0.4"/>
                    </svg>
                </div>
            </div>
            <div class="decr">
                <?php echo apply_filters('the_content', CFS()->get('home_about_text_' . LOCALE, 883)); ?>
            </div>
        </div>
    </div>
    <div class="rowFlex">
        <?php
        if (1==2):
        $why_us_blocks = CFS()->get('why_us', 531);
        ?>
        <?php foreach ($why_us_blocks as $block):
            $img = $block['why_us_img'];
            $text = $block['why_us_text_' . LOCALE];
            ?>

            <div class="col-xxs-6 col-lg-3 colFlex">
                <div class="why-card">
                    <div class="why-card__img">
                        <img src='<?php echo $img ?>' alt='<?php echo $text ?>'>
                    </div>
                    <div class="why-card__text">
                        <?php echo $text ?>
                    </div>
                </div>
            </div>

        <?php endforeach;
        endif;
        ?>
    </div>
</div>