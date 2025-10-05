<?php
$appointments_archive = $args['data'];

if (!session_id()) {
	session_start();
}
?>
<div class="c-table archive">
	<div class="c-table__body-title">
		<div class="d-flex">
				<span class="c-table__body-title-toggle active">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8 10L12 14L16 10" stroke="#57596B" stroke-width="2" stroke-linecap="round"
						      stroke-linejoin="round"/>
					</svg>
				</span>
			<span class="c-table__body-title-name"><?php _e('Архів', 'mz'); ?></span>
		</div>
		<div class="c-table__body-title-sort">
			<span><?php _e('Фільтрувати:', 'mz'); ?></span>
			<label class="input-form">
				<input
					type="date"
					name="cabinetDateRange"
					placeholder="від __/__/____ - до__/__/____"
					data-lang="<?php echo str_replace('ua', 'uk', LOCALE) ?>"
					data-page="appointments"
					data-default-date="<?= $_SESSION['archive_appointments_start_date'] ?>-<?= $_SESSION['archive_appointments_end_date'] ?>"
					id="cabinetDateRange">
			</label>
		</div>
	</div>
	<div class="c-table__wrap">
		<div class="c-table__body">
			<div class="c-table__body-wrap">
				<?php
				if (!$appointments_archive):
					?>
					<div class="c-table__body-wrap-noitems">
						<?php echo __('За вашим запитом архівних візитів не знайдено', 'mz'); ?>
					</div>
				<?php
				else:
					get_template_part('core/cabinet/view/parts/appointments-archive-row', null, ['data' => $appointments_archive]);
				endif;
				?>
			</div>
		</div>
	</div>
</div>