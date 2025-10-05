<?php
get_header();
$employee_blocks = CFS()->get('employee_blocks');
?>

<main role="main" class="content">

    <div>
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

                <li class="breadcrumb-item"><span><?php
                        if (LOCALE == 'ru') {
                            echo 'Медицинские работники';
                        } else if (LOCALE == 'ua') {
                            echo 'Медичні працівники';
                        } else {
                            echo 'Medical workers';
                        }
                        ?></span></li>
            </ol>
            <div class="title wow" data-wow-delay="5s">
                <div class="title-wrap">
                    <h1><?php
                        if (LOCALE == 'ru') {
                            echo 'Медицинские работники';
                        } else if (LOCALE == 'ua') {
                            echo 'Медичні працівники';
                        } else {
                            echo 'Medical workers';
                        }
                        ?></h1>
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
            <div class="employee">

                    <?php
                    if ($employee_blocks) {
                        foreach ($employee_blocks as $block) {
                            ?>
                                <div class="colPad-sm-10 employee__item wow">
                                    <div class="employee__item-img">
                                        <img src="<?php echo $block['employee_img'] ?>" alt="<?php echo $block['employee_fio_' . LOCALE] ?>">
                                    </div>
                                    <div class="employee__item-text">
                                        <?php
                                        $name = $block['employee_fio_' . LOCALE];
                                        if ($name == '') {
                                            $name = $block['employee_fio_ru'];
                                        }
                                        $name_array = explode(" ", $name, 2);
                                        $name = ' <div class="employee__item-text-title">' . $name_array[0] . '</div>';
                                        $name .= '<div class="employee__item-text-title">' . $name_array[1] . '</div>';
                                        echo $name;
                                        ?>
                                        <?php
                                        $position = $block['employee_position_' . LOCALE];
                                        if ($position == '') {
                                            $position = $block['employee_position_ru'];
                                        }
                                        ?>
                                        <div class="employee__item-text-text-decr"><?php echo $position ?></div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                    ?>
            </div>

        </div>
    </div>


</main>

<?php get_footer(); ?>
