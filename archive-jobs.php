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

            <li class="breadcrumb-item"><span><?php
					if (LOCALE == 'ru') {
						echo 'Вакансии';
					} else if (LOCALE == 'ua') {
						echo 'Вакансії';
					} else {
						echo 'Jobs';
					}
					?></span></li>
        </ol>
        <div class="rowFlex mb-20-40">
            <div class="colFlex col-md-6">
                <div class="title wow" data-wow-delay="5s">
                    <div class="title-wrap">
						<h1><?php
						if (LOCALE == 'ru') {
							echo 'Вакансии';
						} else if (LOCALE == 'ua') {
							echo 'Вакансії';
						} else {
							echo 'Jobs';
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
                </div>        </div>
            <div class="colFlex col-md-6">
                <div class="title-sm">
					<?php
					$args = array(
						'p'         => 635, // ID of a page, post, or custom type
						'post_type' => 'any'
					);
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							the_excerpt();
						}
					}
					// Возвращаем оригинальные данные поста. Сбрасываем $post.
					wp_reset_postdata();
					?>
                </div>
            </div>



        </div>
        <div class="specials">
            <div class="specials__card rowFlex mb-65-85">
                <div class="specials__card-img colFlex col-md-6">
                    <img src="<?php echo get_the_post_thumbnail_url(635) ?>" alt="Вакансии">
                </div>
                <div class="specials__card-text colFlex col-md-6">
                    <div class="blog-all-text">
						<?php
						$content = get_post( 635 );
						$content = $content->post_content;
						$content = apply_filters('the_content', $content);
						echo $content;
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray pt-48-88">
        <div class="container-fluid">
            <div class="rowFlex mb-40-64">

				<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
                    <div class="col-md-6 colFlex">
                        <div class="product-accordion-item product-accordion-item--job">
                            <div class="product-accordion-title js__not-next-ub">
                                <div class="product-accordion-title-job"><?php the_title() ?></div>
                                <div class="product-accordion-text">
                                    <div class="product-accordion-text__data"><?php
										$date = get_the_date("d M Y");
										echo $date;
										?></div>
									<?php
									$tags = CFS()->get('job_tags');
									if ($tags) {
										foreach ($tags as $tag) {
											if ($tag['job_tag_' . LOCALE] != '') {
												$tag_item = $tag['job_tag_' . LOCALE];
											} else {
												$tag_item = $tag['job_tag_ru'];
											}
											echo '<div class="product-accordion-text__har">'. $tag_item .'</div>';
										}
									}
									?>
                                </div>
                                <span class="close"></span>
                            </div>
                            <div class="product-accordion-decr all-text">
								<?php the_content(); ?>
                            </div>
                            <div class="product-accordion-row">
								<?php
								$job_rabotaua = CFS()->get('job_rabotaua');
								if ($job_rabotaua && $job_rabotaua != "") {
									?>
                                    <a href="<?php echo $job_rabotaua; ?>" class="product-accordion-row__link">rabota.ua</a>
								<?php } ?>
								<?php
								$job_workua = CFS()->get('job_workua');
								if ($job_workua && $job_workua != "") {
									?>
                                    <a href="<?php echo $job_workua; ?>" class="product-accordion-row__link">work.ua</a>
								<?php } ?>
                                <button class="btn-t btn send-cv__bottom"><?php _e( "отправить резюме", 'mz' ) ?></button>
                            </div>
                        </div>
                    </div>
				<?php } /* конец while */ ?>
				<?php } /* конец if */ ?>

            </div>
            <div class="text-center title-sm pb-65-85">
                <?php _e( "Благодарим Вас за интерес, проявленный к нашей компании!", 'mz' ) ?>
            </div>
        </div>
    </div>
</main>

<div class="modal-with-footer" id="sign-up-modal">
    <div class="modal modal-xl">
        <div class="modal__title"><?php _e( "Отправка резюме", 'mz' ) ?></div>
        <form method="POST" class="form-default" enctype="multipart/form-data">
            <input type="hidden" name="action" value="send_mail_two">
            <input type="hidden" name="cv" value="cv">
            <label class="input-form"><?php _e( 'Имя', 'mz' ) ?>*
                <input type="text" name="name" required="">
            </label>

            <label class="input-form"><?php _e( 'Телефон', 'mz' ) ?>*
                <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
            </label>

            <label class="input-form"><?php _e( 'Файл', 'mz' ) ?>*
                <input name="cv" type="file" id="field__file-2" class="field field__file">
                <label class="field__file-wrapper" for="field__file-2">
                    <div class="field__file-fake"><?php _e('Файл не выбран', 'mz') ?></div>
                    <div class="field__file-button"><?php _e('Выбрать', 'mz') ?></div>
                </label>
            </label>

            <div class="text-center">
                <button type="submit" class="btn w-100"><?php _e( "отправить резюме", 'mz' ) ?></button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <?php $contacts = pods( 'header_contacts' ); ?>
        <div class="modal-footer__top">
            <svg width="14" height="20" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                      fill="#707E98">
                </path>
            </svg>
            <?php echo $contacts->field( 'header_address_' . LOCALE ); ?>
        </div>
        <div class="modal-footer__row">
            <div class="modal-footer__column">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.31375 2.68804C10.8288 1.68297 13.7583 1.75246 16.2063 2.91984C15.5087 2.81358 14.7992 2.8937 14.1088 3.01074C12.2335 3.36585 10.4514 4.25054 9.05848 5.56487C7.72285 6.88122 6.78689 8.6278 6.52254 10.4964C6.34769 11.8205 6.50977 13.2092 7.10232 14.4144C7.71294 15.6788 8.78777 16.7159 10.0832 17.2511C11.3315 17.7808 12.7796 17.7749 14.044 17.3022C15.9412 16.6041 17.3043 14.7191 17.4602 12.7052C17.5583 11.3852 17.2381 9.98113 16.3537 8.96878C15.5094 7.97783 14.2746 7.432 13.0389 7.1213C12.9726 5.89936 13.5468 4.69219 14.4573 3.8975C14.963 3.44033 15.5905 3.14893 16.2394 2.96245L16.2887 2.94539C18.1463 3.83858 19.7247 5.31166 20.7304 7.12008C21.5921 8.65973 22.0414 10.4339 21.9969 12.2012C21.9885 14.4866 21.1365 16.7493 19.6761 18.4967C18.2951 20.1632 16.3636 21.3619 14.2584 21.8419C12.1476 22.3302 9.8767 22.1196 7.90125 21.2201C5.9683 20.3545 4.3307 18.8497 3.28894 16.9987C2.42234 15.4605 1.9639 13.687 2.00195 11.9176C2.00608 9.71299 2.78684 7.5254 4.15002 5.80145C5.23889 4.4249 6.68341 3.33036 8.31375 2.68804Z" fill="#707E98"></path>
                    <path d="M14.1088 3.00968C14.7992 2.89264 15.5087 2.81258 16.2063 2.91883L16.3064 2.93583L16.2394 2.96133C15.5905 3.14792 14.963 3.43927 14.4573 3.89649C13.5468 4.69113 12.9726 5.89835 13.0389 7.1203C14.2745 7.43094 15.5094 7.97672 16.3537 8.96771C17.238 9.98007 17.5582 11.3842 17.4602 12.7041C17.3043 14.718 15.9412 16.603 14.044 17.3011C12.7796 17.7739 11.3315 17.7797 10.0832 17.2501C8.78771 16.7148 7.71293 15.6778 7.10232 14.4133C6.50977 13.2082 6.34768 11.8194 6.52259 10.4954C6.78689 8.62674 7.72284 6.88016 9.05852 5.56381C10.4514 4.24947 12.2335 3.36479 14.1088 3.00968Z" fill="white"></path>
                </svg>
                <div class="modal-footer__text">
                    <a href="tel:<?php echo $contacts->field( 'header_phone' ); ?>" class="">
                        <?php echo $contacts->field( 'header_phone' ); ?>
                    </a>
                </div>
            </div>
            <div class="modal-footer__column">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0001 3C12.6515 3 13.1844 3.55677 13.1844 4.23692V8.83518C13.1844 9.51564 12.6515 10.0723 12.0001 10.0723C11.3487 10.0723 10.8159 9.51564 10.8159 8.83518V4.23692C10.8159 3.55677 11.3487 3 12.0001 3Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.05778 9.78417C3.25904 9.1371 3.93042 8.77977 4.54991 8.98998L8.73671 10.411C9.35628 10.6212 9.69832 11.3225 9.49707 11.9696C9.29581 12.6166 8.62429 12.974 8.00487 12.7637L3.81799 11.3428C3.19857 11.1325 2.85639 10.4312 3.05778 9.78417Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.47345 20.764C5.94654 20.3642 5.8287 19.5867 6.21151 19.0364L8.7991 15.3163C9.18184 14.7658 9.92624 14.6426 10.4532 15.0426C10.9802 15.4426 11.098 16.2199 10.7152 16.7703L8.12758 20.4903C7.74477 21.0409 7.00044 21.164 6.47345 20.764Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5269 20.7641C16.9998 21.1639 16.2556 21.0408 15.8726 20.4904L13.2851 16.7704C12.9021 16.2198 13.02 15.4425 13.547 15.0425C14.0739 14.6427 14.8183 14.7659 15.2012 15.3161L17.7887 19.0362C18.1716 19.5866 18.0536 20.3641 17.5269 20.7641Z" fill="#707E98"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.942 9.78416C21.1433 10.4312 20.8012 11.1326 20.1816 11.3428L15.9948 12.7637C15.3753 12.974 14.704 12.6166 14.5026 11.9696C14.3013 11.3226 14.6433 10.6212 15.2629 10.4109L19.4497 8.98997C20.0691 8.77976 20.7406 9.13717 20.942 9.78416Z" fill="#707E98"></path>
                </svg>
                <div class="modal-footer__text">
                    <a href="tel:<?php echo $contacts->field( 'header_phone_2' ); ?>" class="">
                        <?php echo $contacts->field( 'header_phone_2' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
