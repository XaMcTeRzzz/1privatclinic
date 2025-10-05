<?php get_header(); ?>

<main role="main" class="content">
    <div class="grafik">
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
            <div class="rowFlex">
                <div class="colFlex col-md-7">
                    <div class="title wow" data-wow-delay="5s">
                        <div class="title-wrap">
                            <h1><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="colFlex col-md-5">
                    <div class="form-sm">
                        <form class="search-bar search-bar--lg" action="/">
                            <input type="text" name="search" class="search-input" placeholder="поиск..." required>
                            <button type="submit" class="search-icon"><svg class="svg-sprite-icon icon-searchForm">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#searchForm"></use>
                                </svg></button>
                            <button class="search-close" type="reset"><svg class="svg-sprite-icon icon-crossM">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#crossM"></use>
                                </svg></button>
                        </form>
                    </div>
                </div>
                <div class="colFlex col-lg-10">
                    <div class="work-schedule d-none d-sm-block">
                        <table class="work-schedule-table">
                            <thead>
                            <tr>
                                <th>анализы</th>
                                <th>пн</th>
                                <th>вт</th>
                                <th>ср</th>
                                <th>чт</th>
                                <th>пт</th>
                                <th>сб</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $graphic = CFS()->get('lab_graphic');
                            foreach ($graphic as $item) {
                            ?>
                            <tr>
                                <?php
                                $lab_graphic_name = $item['lab_graphic_name_' . LOCALE];
                                if ($lab_graphic_name == '') {
                                    $lab_graphic_name = $item['lab_graphic_name_ru'];
                                }
                                ?>
                                <th><?php echo $lab_graphic_name; ?></th>
                                <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                <td><?php echo $item['lab_graphic_tue_time'] ?></td>
                                <td><?php echo $item['lab_graphic_wed_time'] ?></td>
                                <td><?php echo $item['lab_graphic_thur_time'] ?></td>
                                <td><?php echo $item['lab_graphic_fri_time'] ?></td>
                                <td><?php echo $item['lab_graphic_sat_time'] ?></td>
                            </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="work-schedule-mob">

                        <?php
                        foreach ($graphic as $item) {
                        ?>
                        <div class="accordion-schedule">
                            <?php
                            $lab_graphic_name = $item['lab_graphic_name_' . LOCALE];
                            if ($lab_graphic_name == '') {
                                $lab_graphic_name = $item['lab_graphic_name_ru'];
                            }
                            ?>
                            <div class="accordion-schedule-title"><?php echo $lab_graphic_name; ?></div>

                            <div class="accordion-schedule-content">
                                <table class="accordion-schedule-content-table">
                                    <tbody>
                                    <tr>
                                        <th>пн</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>вт</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>ср</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>чт</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>пт</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>сб</th>
                                        <td><?php echo $item['lab_graphic_mon_time'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

<?php get_footer(); ?>
