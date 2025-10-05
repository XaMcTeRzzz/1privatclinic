<div class="c-modal move-appointment" id="js-cabinet-move-appointment-modal">
	<div class="c-modal__wrap">
		<div class="c-modal__body">
			<div class="c-modal__body-title"><?php _e("Перенести запис на прийом", 'mz') ?></div>

			<form id="js-cabinet-move-appointment-form" class="form-default">

				<div class="c-modal__body-fields">
					<div class="input-form">
						<span class="show-value" id="js-move-appointment-form__SpecialityName"></span>
					</div>
					<div class="input-form">
						<span class="show-value" id="js-move-appointment-form__PhysicianName"></span>
					</div>
					<label class="input-form"><?php _e("Оберіть бажану дату", 'mz') ?>*
						<input type="date"
						       name="appointmentDate"
						       required="">
					</label>
					<label class="input-form"><?php _e("Оберіть бажаний час", 'mz') ?>*
						<input type="time"
						       name="appointmentTime"
						       required="">
					</label>
					<div class="input-form">
						<span class="show-value" id="js-move-appointment-form__EventName"></span>
					</div>

					<input type="hidden" name="appointmentId">
				</div>

				<div class="c-modal__body-interactive">
					<span class="error-msg"></span>
					<div class="indicator preloader-modal-send">
						<svg width="32px" height="24px">
							<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
							<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
						</svg>
					</div>
				</div>

				<div class="c-modal__body-buttons">
					<button class="btn btn-cancel"
					        type="reset"
					        onclick="$.fancybox.close()"><?php _e("скасувати", 'mz') ?></button>
					<button class="btn"
					        id="js-cabinet-move-appointment-button"><?php _e("перенести запис", 'mz') ?></button>
				</div>
			</form>
		</div>
		<div class="c-modal__footer">
			<?php $contacts = pods('header_contacts'); ?>
			<div class="modal-footer__top">
				<svg width="14" height="20" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg"
				     class="icon-pin">
					<path
						d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
						fill="#707E98">
					</path>
				</svg>
				<?php echo $contacts->field('header_address_' . LOCALE); ?>
			</div>
			<div class="modal-footer__row">
				<div class="modal-footer__column">
					<svg class="svg-sprite-icon icon-phoneTalk">
						<use
							xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#phoneTalk"></use>
					</svg>
					<div class="modal-footer__text">
						<a href="tel:<?= '+' . preg_replace('/[^0-9]/', '', $contacts->field('header_phone')) ?>" class="">
							<?php echo $contacts->field('header_phone'); ?>
						</a>
						<small>(Viber, Telegram, Whatsapp)</small>
						<a href="tel:<?= '+' . preg_replace('/[^0-9]/', '', $contacts->field('header_phone_5')) ?>" class="">
							<?php echo $contacts->field('header_phone_5'); ?>
						</a>
					</div>
				</div>
				<div class="modal-footer__column">
					<div class="modal-footer__text">
						<a href="tel:<?= '+' . preg_replace('/[^0-9]/', '', $contacts->field('header_phone_2')) ?>" class="">
							<?php echo $contacts->field('header_phone_2'); ?>
						</a>
						<a href="tel:<?= '+' . preg_replace('/[^0-9]/', '', $contacts->field('header_phone_3')) ?>" class="">
							<?php echo $contacts->field('header_phone_3'); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>