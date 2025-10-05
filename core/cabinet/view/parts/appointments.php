<?php
$appointments = $args['data'];
?>
<div class="page-title-mobile">
	<h1><?php _e('Візити до лікаря', 'mz'); ?></h1>
</div>
<div class="c-table appointments">
	<?php
	if ($appointments):
		?>
		<div class="c-table__header desktop">
			<div class="c-table__header-row">
				<div class="c-table__header-cell-date"><?php _e('Дата', 'mz'); ?></div>
				<div class="c-table__header-cell-time"><?php _e('Час', 'mz'); ?></div>
				<div class="c-table__header-cell-doc"><?php _e('Лікар', 'mz'); ?></div>
				<div class="c-table__header-cell-spec"><?php _e('Спеціалізація', 'mz'); ?></div>
				<div class="c-table__header-cell-action"></div>
			</div>
		</div>
	<?php
	endif;
	?>
	<div class="c-table__body-title">
		<div class="d-flex">
				<span class="c-table__body-title-toggle active">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8 10L12 14L16 10" stroke="#57596B" stroke-width="2" stroke-linecap="round"
						      stroke-linejoin="round"/>
					</svg>
				</span>
			<span class="c-table__body-title-name"><?php _e('Заплановані', 'mz'); ?></span>
		</div>
	</div>
	<div class="c-table__wrap">
		<?php
		if ($appointments):
			?>
			<div class="c-table__header mobile">
				<div class="c-table__header-row">
					<div class="c-table__header-cell-date"><?php _e('Дата', 'mz'); ?></div>
					<div class="c-table__header-cell-time"><?php _e('Час', 'mz'); ?></div>
					<div class="c-table__header-cell-doc"><?php _e('Лікар', 'mz'); ?></div>
					<div class="c-table__header-cell-spec"><?php _e('Спеціалізація', 'mz'); ?></div>
					<div class="c-table__header-cell-action"></div>
				</div>
			</div>
		<?php
		endif;
		?>
		<div class="c-table__body">
			<div class="c-table__body-wrap">
				<?php if (!$appointments):
					?>
					<div class="c-table__body-wrap-noitems">
						<?php echo __('Поки немає запланованих візитів', 'mz'); ?>
					</div>
				<?php
				else:
					get_template_part('core/cabinet/view/parts/appointments-row', null, ['data' => $appointments]);
				endif;
				?>
			</div>
		</div>
	</div>
</div>