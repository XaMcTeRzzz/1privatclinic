<?php
$documents = $args['data'];

if (!session_id()) {
	session_start();
}
?>
<div class="page-title-mobile page-container">
	<h1><?php _e('Результати аналізів', 'mz'); ?></h1>
</div>
<div class="c-table analysis">
	<div class="c-table__header desktop">
		<div class="c-table__header-row">
			<div class="c-table__header-cell-date"><?php _e('Дата', 'mz'); ?></div>
			<div class="c-table__header-cell-operate"><?php _e('Послуга', 'mz'); ?></div>
			<div class="c-table__header-cell-document"><?php _e('Документ', 'mz'); ?></div>
			<div class="c-table__header-cell-action"></div>
		</div>
	</div>

	<div class="c-table__body-title">
		<div class="d-flex"></div>
		<div class="c-table__body-title-sort">
			<span><?php _e('Фільтрувати:', 'mz'); ?></span>
			<label class="input-form">
				<input
					type="date"
					name="cabinetDateRange"
					placeholder="від __/__/____ - до__/__/____"
					data-lang="<?php echo str_replace('ua', 'uk', LOCALE) ?>"
					data-page="analysis"
					data-default-date="<?=$_SESSION['documents_start_date']?>-<?=$_SESSION['documents_end_date']?>"
					id="cabinetDateRange">
			</label>
		</div>
	</div>
	<div class="c-table__wrap">
		<?php
		if ($documents):
			?>
			<div class="c-table__header mobile">
				<div class="c-table__header-row">
					<div class="c-table__header-cell-date"><?php _e('Дата', 'mz'); ?></div>
					<div class="c-table__header-cell-operate"><?php _e('Послуга', 'mz'); ?></div>
					<div class="c-table__header-cell-document"><?php _e('Документ', 'mz'); ?></div>
					<div class="c-table__header-cell-action"></div>
				</div>
			</div>
		<?php
		endif;
		?>
		<div class="c-table__body">
			<div class="c-table__body-wrap">
				<?php if (!$documents):
					?>
					<div class="c-table__body-wrap-noitems">
						<?php echo __('За вашим запитом результатів аналізів не знайдено', 'mz'); ?>
					</div>
				<?php
				else:
					get_template_part('core/cabinet/view/parts/analysis-row', null, ['data' => $documents]);
				endif;
				?>
			</div>
		</div>
	</div>
</div>