<?php
$appointments = $args['data'];
?>
<?php if (!$appointments):
	?>
	<div class="c-table__body-wrap-noitems">
		<?php echo __('Поки немає запланованих візитів', 'mz'); ?>
	</div>
<?php
else:
	$key = 1;
	foreach ($appointments as $appointment):
		?>
		<div class="c-table__body-row" <?php if ($key > ITEMS_FOR_ONE_SHOW) echo 'style="display: none;"'; ?>>
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
										class="c-table__body-cell-date-format-desktop"><?php echo date_i18n(__('d F Y'), strtotime($appointment['Date'])) ?></span>
					<span
						class="c-table__body-cell-date-format-mob"><?php echo date_format(date_create($appointment['Date']), 'd-m-Y');
						echo date_format(date_create($appointment['Start']), ' H:i'); ?></span>
				</div>
				<div
					class="c-table__body-cell-time"><?php echo date_format(date_create($appointment['Start']), 'H:i') ?></div>
				<div class="c-table__body-cell-doc"><?php echo $appointment['PhysicianName'] ?><?php
					if (!empty($appointment['Speciality'])): ?><span>
						(<?php echo $appointment['Speciality'] ?>)</span>
					<?php endif; ?>
				</div>
				<div class="c-table__body-cell-spec"><?php echo $appointment['Speciality'] ?: '---' ?></div>
				<div class="c-table__body-cell-action">
					<div class="c-table__body-cell-action-mob">
						<svg width="6" height="13" viewBox="0 0 3 13" fill="none"
						     xmlns="http://www.w3.org/2000/svg">
							<circle cx="1.49997" cy="1.5" r="1.5" fill="#90A8BE"/>
							<circle cx="1.49997" cy="6.5" r="1.5" fill="#90A8BE"/>
							<circle cx="1.49997" cy="11.5" r="1.5" fill="#90A8BE"/>
						</svg>
					</div>
					<ul>
						<li onclick='changeAppointment(<?php
						echo $appointment['speciality_id'] ?: '' ?>,<?php
						echo $appointment['api_id'] ?: '' ?>,<?php
						echo $appointment['EmpId'] ?: '' ?>,<?php
						echo $appointment['AppointmentId'] ?>,<?php
						echo '"' . date_format(date_create($appointment['Date']), 'Y-m-d') . '"'; ?>)'>
							<span><?php _e('Перенести', 'mz'); ?></span>
							<p><?php _e('Перенести', 'mz'); ?></p>
						</li>
						<li
							onclick="cancelAppointment(<?php echo $appointment['AppointmentId'] ?>,'<?php echo date_format(date_create($appointment['Date']), 'Y-m-d'); ?>',<?php echo $appointment['api_id'] ?>)">
							<span><?php _e('Скасувати', 'mz'); ?></span>
							<p><?php _e('Скасувати', 'mz'); ?></p>
						</li>
					</ul>
				</div>
			</div>
			<div class="c-table__body-row-service">
				<div class="c-table__body-row-service-name"><?php _e('Послуга:', 'mz'); ?></div>
				<div class="c-table__body-row-service-value"><?php echo $appointment['EventName'] ?></div>
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