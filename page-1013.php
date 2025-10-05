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
            <div class="rowFlexPad jc-sb-md">
                <div class="colPad-sm-4 colPadDef colPad-lg-3">
                    <div class="sandbar-sticky">

                    </div>
                </div>
                <div class="colPad-sm-12 colPadDef">

                    <div class="blog-all-text">
                        <?php the_post(); the_content(); ?>
                    </div>
                </div>

            </div>
        </div>
    </main>

<?php get_footer(); ?>