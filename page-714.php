<?php get_header(); ?>

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


                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="rowFlex mb-20-40">
                <div class="colFlex col-md-6">
                    <div class="title wow" data-wow-delay="5s">
                        <div class="title-wrap">
                            <h1><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="colFlex col-md-6">
                    <div class="title-sm"><?php the_excerpt(); ?></div>
                </div>
            </div>

            <div class="rowFlex jcc">
                <div class="colFlex col-md-6">
                    <div class="price-block price-block--page">
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-pin">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#pin"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <?php
                                $call_address = CFS()->get('call_address_' . LOCALE);
                                if ($call_address == '') {
                                    $call_address = CFS()->get('call_address_ru');
                                }
                                ?>
                                <div class="title-sm"><?php echo $call_address; ?></div>
                                <div class="decr"></div>
                            </div>
                        </div>
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-clock">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#clock"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <div class="title-sm"><?php
                                    echo get_the_title(714);
                                    ?>:</div>
                                <div class="decr"></div>
                                <table class="price-table">
                                    <?php
                                    $shedule = CFS()->get('call_shedule');
                                    foreach ($shedule as $item) {
                                    ?>
                                    <tr>
                                        <?php
                                        $call_shedule_week = $item['call_shedule_week_' . LOCALE];
                                        if ($call_shedule_week == '') {
                                            $call_shedule_week = $item['call_shedule_week_ru'];
                                        }

                                        $call_shedule_time = $item['call_shedule_time_' . LOCALE];
                                        if ($call_shedule_time == '') {
                                            $call_shedule_time = $item['call_shedule_time_ru'];
                                        }
                                        ?>
                                        <th><?php echo $call_shedule_week; ?></th>
                                        <td><?php echo $call_shedule_time; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-phone">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#phone"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <div class="title-sm"><?php
                                    if (LOCALE == 'ru') {
                                        echo 'Телефоны';
                                    } else if (LOCALE == 'ua') {
                                        echo 'Телефони';
                                    } else {
                                        echo 'Phones';
                                    }
                                    ?>:</div>
                                <div class="decr"></div>
                                <ul class="telList">
                                    <?php
                                    $phones = CFS()->get('call_phones');
                                    foreach ($phones as $phone) {
                                    ?>
                                    <li><a href="tel:<?php echo $phone['call_phones_phone']; ?>"><?php echo $phone['call_phones_phone']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="colFlex col-md-6 mb-20-40">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </div>
                <div class="colFlex col-md-8 mb-65-85">
                    <div class="decr">
                        <?php the_post(); the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>