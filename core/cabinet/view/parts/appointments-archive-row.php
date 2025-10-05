<?php
$appointments_archive = $args['data'];
?>
<?php
if (!$appointments_archive):
	?>
	<div class="c-table__body-wrap-noitems">
		<?php echo __('За вашим запитом архівних візитів не знайдено', 'mz'); ?>
	</div>
<?php
else:
	$key = 1;
	foreach ($appointments_archive as $appointment_archive):
		?>
		<div
			class="c-table__body-row" <?php if ($key > ITEMS_FOR_ONE_SHOW) echo 'style="display: none;"'; ?>>
			<div class="c-table__body-row-wrap">
				<div class="c-table__body-cell-toggle">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
					     xmlns="http://www.w3.org/2000/svg">
						<path d="M8 10L12 14L16 10" stroke="#57596B" stroke-width="2" stroke-linecap="round"
						      stroke-linejoin="round"/>
					</svg>
				</div>
				<div class="c-table__body-cell-date">
									<span
										class="c-table__body-cell-date-format-desktop"><?php echo date_i18n(__('d F Y'), strtotime($appointment_archive['Date'])) ?></span>
					<span
						class="c-table__body-cell-date-format-mob"><?php echo date_format(date_create($appointment_archive['Date']), 'd-m-Y');
						echo date_format(date_create($appointment_archive['Start']), ' H:i'); ?></span>
				</div>
				<div
					class="c-table__body-cell-time"><?php echo date_format(date_create($appointment_archive['Start']), 'H:i') ?></div>
				<div class="c-table__body-cell-doc"><?php echo $appointment_archive['PhysicianName'] ?></div>
				<div class="c-table__body-cell-spec">---</div>
			</div>
			<div class="c-table__body-row-service">
				<div class="c-table__body-row-service-name"><?php _e('Послуга:', 'mz'); ?></div>
				<div
					class="c-table__body-row-service-value"><?php echo $appointment_archive['EventName'] ?></div>
			</div>
		</div>
		<div class="c-table__body-row-gap" <?php if ($key > ITEMS_FOR_ONE_SHOW) echo 'style="display: none;"'; ?>></div>
		<?php if ($key % ITEMS_FOR_ONE_SHOW == 0): ?>
		<div
			class="c-table__body-row show-more-row" <?php if ($key > ITEMS_FOR_ONE_SHOW) echo 'style="display: none;"'; ?>>
			<span id="js-show-more-button"><?php _e('Показати ще +', 'mz'); ?></span>
		</div>
	<?php endif; ?>
		<?php
		$key++;
	endforeach;
endif;
?>