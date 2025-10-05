<?php get_header(); ?>

    <main role="main" class="content">

        <div class="about-bg" data-type="background" data-speed="5" style="background-image: url('<?php echo get_template_directory_uri() . '/core/' ?>images/content/lab.jpg')">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">главная</a></li>


                    <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                </ol>
                <div class="rowFlex jc-sb-md aic-md">
                    <div class="colFlex col-sm-5">
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
                    <div class="colFlex col-sm-6 mb-40-64">
                        <div class="title-sm-bolt"><?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="specials">
                <div class="specials__card rowFlexPad  mb-65-85">
                    <div class="specials__card-img colPadDef colPad-md-6">
                        <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/content/lab-1.jpg" alt="">
                    </div>
                    <div class="specials__card-text colPadDef colPad-md-6">
                        <div class="specials__card-text-decr decr">
                            <?php the_post(); the_content(); ?>
                        </div>
                    </div>
                </div>

                <?php
                $blocks = CFS()->get('lab_block');
                if ($blocks) {
                    foreach ($blocks as $block) {
                ?>
                <div class="specials__card rowFlexPad  mb-65-85">
                    <div class="specials__card-img colPadDef colPad-md-6">
                        <img src="<?php echo $block['lab_block_img']; ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="specials__card-text colPadDef colPad-md-6">
                        <?php
                        $title = $block['lab_block_title_' . LOCALE];
                        if ($title == '') {
                            $title = $block['lab_block_title_ru'];
                        }
                        if ($title && !empty($title) && $title != "") {
                        ?>
                        <div class="specials__card-text-title title-sm-bolt"><?php echo $title; ?></div>
                        <?php } ?>
                        <?php
                        $text = $block['lab_block_desc'];
                        $text = apply_filters('the_content', $text);
                        if ($text && !empty($text) && $text != "") {
                        ?>
                        <div class="specials__card-text-decr decr">
                           <?php echo $text; ?>
                        </div>
                        <?php } ?>

                        <?php
                        $accordion = $block['lab_accordion'];
                        if ($accordion) {
                            ?>

                            <div class="product-accordion">
                                <?php foreach ($accordion as $item) { ?>
                                    <div class="product-accordion-item">
                                        <div class="product-accordion-title">
                                            <?php
                                            $acc_title = $item['lab_accordion_title_' . LOCALE];
                                            if ($acc_title == '') {
                                                $acc_title = $item['lab_accordion_title_ru'];
                                            }
                                            ?>
                                            <?php echo $acc_title; ?>
                                            <span class="close"></span>
                                        </div>
                                        <div class="product-accordion-decr all-text">
                                            <?php
                                            $content = apply_filters('the_content', $item['lab_accordion_desc']);
                                            echo $content;
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>

        </div>
    </main>

<?php get_footer(); ?>