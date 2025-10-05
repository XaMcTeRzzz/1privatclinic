<?php get_header(); ?>

    <main role="main" class="content">

        <div class="price-block-container">
            <div class="price-block-container-img">
                <picture>
                    <source media="(min-width: 576px)" srcset="<?php echo get_template_directory_uri() . '/core/' ?>images/general/y-1.jpg">
                    <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/y-1-m.jpg" alt="logo">
                </picture>
            </div>
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">главная</a></li>


                    <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                </ol>
                <div class="rowFlex">
                    <div class="col-md-5 colFlex">
                        <div class="title wow" data-wow-delay="5s">
                            <div class="title-wrap">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 colFlex ">
                        <div class="price-block ">
                            <div class="price-block-item">
                                <a href="/uslugi/stoimost-uslug/" class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-dollars">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#dollars"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php echo get_the_title(758) ?></div>
                                    <a class="link-bubbles" href="/uslugi/stoimost-uslug/"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'подробнее';
                                        } else if (LOCALE == 'ua') {
                                            echo 'докладніше';
                                        } else {
                                            echo 'more';
                                        }
                                        ?></a>
                                </div>
                            </div>
                            <div class="price-block-item">
                                <a href="/specials/" class="price-block-item-icon">
                                    <svg class="svg-sprite-icon icon-sale">
                                        <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#sale"></use>
                                    </svg>
                                </a>
                                <div class="price-block-item-text">
                                    <div class="title-sm"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'Акции, спец. предложения';
                                        } else if (LOCALE == 'ua') {
                                            echo 'Акції, спец. пропозиції';
                                        } else {
                                            echo 'Promotions, special offers';
                                        }
                                        ?></div>
                                    <a class="link-bubbles" href="/specials/"><?php
                                        if (LOCALE == 'ru') {
                                            echo 'подробнее';
                                        } else if (LOCALE == 'ua') {
                                            echo 'докладніше';
                                        } else {
                                            echo 'more';
                                        }
                                        ?></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>




        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

        <script >
            function burgerMenu(selector) {
                let menu = $(selector);
                let button = menu.find('.burger-menu_button', '.burger-menu_lines');
                let links = menu.find('.burger-menu_link');
                let overlay = menu.find('.burger-menu_overlay');

                button.on('click', (e) => {
                    e.preventDefault();
                    toggleMenu();
                });

                links.on('click', () => toggleMenu());
                overlay.on('click', () => toggleMenu());

                function toggleMenu(){
                    menu.toggleClass('burger-menu_active');

                    if (menu.hasClass('burger-menu_active')) {
                        $('body').css('overlow', 'hidden');
                    } else {
                        $('body').css('overlow', 'visible');
                    }
                }
            }

            burgerMenu('.burger-menu');
        </script>
    </main>

<?php get_footer(); ?>