<div class="c-modal confirm exit" id="js-cabinet-exit-modal">
	<div class="c-modal__wrap">
		<div class="c-modal__body">
			<div class="c-modal__body-info">
				<span><?php _e("Бажаєте вийти з особистого кабінету?", 'mz') ?></span>
			</div>

			<form id="js-cabinet-exit-form" class="form-default">

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
					        onclick="$.fancybox.close()"><?php _e("ні", 'mz') ?></button>
					<button class="btn"
					        id="js-cabinet-exit-button"><?php _e("вийти", 'mz') ?></button>
				</div>
			</form>

		</div>
	</div>
</div>