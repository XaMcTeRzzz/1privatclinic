<?php
$patient_data = (new Cabinet_User())->get_user_data();
?>

<div class="c-modal confirm send-document" id="js-cabinet-send-document-modal">
	<div class="c-modal__wrap">
		<div class="c-modal__body">
			<div class="c-modal__body-info">
				<span><?php _e("Надіслати PDF-документ вам електронною поштою", 'mz') ?>
					<?php echo '<b>'; echo $patient_data['Email'] ?? ''; echo '</b>'; ?>
					<?php echo '?' ?>
				</span>
			</div>

			<form id="js-cabinet-send-document-form" class="form-default">

				<div class="c-modal__body-interactive">
					<span class="error-msg"></span>
					<div class="indicator preloader-modal-send">
						<svg width="32px" height="24px">
							<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
							<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
						</svg>
					</div>
				</div>

				<input type="hidden" name="documentUrl">
				<input type="hidden" name="documentName">

				<div class="c-modal__body-buttons">
					<button class="btn btn-cancel"
					        type="reset"
					        onclick="$.fancybox.close()"><?php _e("ні", 'mz') ?></button>
					<button class="btn"
					        id="js-cabinet-send-document-button"><?php _e("надіслати", 'mz') ?></button>
				</div>
			</form>

		</div>
	</div>
</div>