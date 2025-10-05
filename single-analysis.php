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
                <li class="breadcrumb-item"><a href="<?= get_post_type_archive_link( 'analysis' )?>"><?php
						if (LOCALE == 'ru') {
							echo 'Анализы';
						} else if (LOCALE == 'ua') {
							echo 'Аналізи';
						} else {
							echo 'Analyzes';
						}
						?></a></li>


                <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
            </ol>
            <div class="nav-title">
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
            <div class="specials">

				<?php
				$blocks = CFS()->get('analisys_page_blocks');
				if ($blocks) {
					foreach ($blocks as $block) {
						?>
                        <div class="specials__card rowFlex mb-65-85 jcc">
                            <div class="specials__card-img colFlex col-md-6">
								<?php if ($block['analysys_block_img'] != '') { ?>
                                    <img src="<?php echo $block['analysys_block_img']; ?>" alt="<?php if ($block['analysys_block_title_' . LOCALE] != '') { echo $block['analysys_block_title_' . LOCALE]; } else { echo $block['analysys_block_title_ru']; } ?>">
								<?php } else { ?>
                                    <img src="/wp-content/uploads/no_photo1.png" alt="<?php if ($block['analysys_block_title_' . LOCALE] != '') { echo $block['analysys_block_title_' . LOCALE]; } else { echo $block['analysys_block_title_ru']; } ?>">
								<?php } ?>
                            </div>
                            <div class="specials__card-text colFlex col-md-6">
                                <div class="specials__card-text-title subtitle"><?php if ($block['analysys_block_title_' . LOCALE] != '') { echo $block['analysys_block_title_' . LOCALE]; } else { echo $block['analysys_block_title_ru']; } ?></div>
                                <div class="specials__card-text-decr decr">
									<?php if ($block['analysys_block_desc_' . LOCALE] != '') {echo $block['analysys_block_desc_' . LOCALE];} else { echo $block['analysys_block_desc_ru']; } ?>
                                </div>
                            </div>

							<?php
							if ($block['analysys_block_accoridon'] && !empty($block['analysys_block_accoridon'])) {
								?>
                                <div class="specials__card-accordion colFlex col-md-8">
                                    <div class="product-accordion">
										<?php
										foreach ($block['analysys_block_accoridon'] as $item) {
											?>
                                            <div class="product-accordion-item">
                                                <div class="product-accordion-title">
													<?php if ($item['analysys_block_acc_title_' . LOCALE] != '') {echo $item['analysys_block_acc_title_' . LOCALE]; } else {echo $item['analysys_block_acc_title_ru']; } ?>
                                                    <span class="close"></span>
                                                </div>
                                                <div class="product-accordion-decr all-text">
													<?php echo apply_filters('the_content', $item['analysys_block_acc_desc']); ?>
                                                </div>
                                            </div>
										<?php } ?>
                                    </div>
                                </div>
							<?php } ?>
                        </div>
					<?php } } ?>



                <div class="mb-20-40 row-btn-text">
					<?php
					if (CFS()->get('show_covid_test_button')) {
						?>
                        <a href="javascript:void(0);" style="color: white" class="btn  get-covid-test"><?php
							if (LOCALE == 'ru') {
								echo 'Записаться на тест';
							} else if (LOCALE == 'ua') {
								echo 'Записатися на тестування';
							} else {
								echo 'Sign up for testing';
							}
							?></a>
					<?php } ?>
                    <p class="gray-thin">
						<?php
						if (LOCALE == 'ru') {
							echo 'Если заметили несоответствие цен на услуги — сообщите нам';
						} else if (LOCALE == 'ua') {
							echo 'Якщо помітили невідповідність цін на послуги - повідомте нам';
						} else {
							echo 'If you notice a discrepancy in the price of services - let us know';
						}
						?>: <a class="anim-link" href="">#</a>
                    </p>
                </div>

            </div>

        </div>


		<?php
		if (CFS()->get('seo3_text_title_' . LOCALE) != "" && CFS()->get('seo3_text_' . LOCALE) != "") {
			?>
            <div class="bg-gray">
                <div class="container-fluid all-text">
                    <h4><?php echo CFS()->get('seo3_text_title_' . LOCALE); ?></h4>

                    <div class="all-text-column">
						<?php echo apply_filters('the_content', CFS()->get('seo3_text_' . LOCALE)); ?>
                    </div>

                </div>
            </div>
		<?php } ?>
    </main>

<?php get_footer(); ?>