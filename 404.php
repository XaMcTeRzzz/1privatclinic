<?php get_header(); ?>

<main role="main" class="content">
    <div class="container-fluid">
        <div class="rowFlex jcc">
            <div class="colFlex col-md-8">
                <div class="oops-new">
                    <div class="oops-new-text">
                        <div class="oops-new-text__title">404</div>
                        <div class="oops-new-text__decr">
                            К сожалению, страница, которую Вы запрашиваете, не существует…
                            Чтобы продолжить работу перейдите на <a class="anim-link" href="/">главную</a>
                        </div>
                        <div class="oops-new-text__img">
                            <img src="<?php echo get_template_directory_uri() . '/core/' ?>images/general/b-dock.svg" alt="oops">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
