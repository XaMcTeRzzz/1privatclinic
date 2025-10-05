document.addEventListener('DOMContentLoaded', function () {
	$(document).on('click', '.wrapper', function (e) {
		const target = $(e.target);
		if (!target.is('.c-table__body-cell-action *')) {
			$('.c-table__body-cell-action ul').removeAttr('style');
			$('.c-table__body-cell-action-mob').removeClass('open');
		}
	})

	$(document).on('click', '#js-cabinet-sidebar-mob-toggle, .c-sidebar-mob-wrap-cross', function (e) {
		e.preventDefault();
		const elem = $('.c-sidebar-mob-wrap');
		elem.toggleClass('open');

		if (!elem.hasClass('open')) {
			elem.toggle(true).fadeToggle(150);
		} else {
			elem.toggle(false).fadeToggle(150);
		}
	});

	$(document).on('click', '.c-table__body-cell-action-mob', function (e) {
		e.preventDefault();
		$('.c-table__body-cell-action ul').removeAttr('style');
		$('.c-table__body-cell-action-mob').removeClass('open');
		const button = $(this);
		button.toggleClass('open');

		const action = button.parents('.c-table__body-cell-action').find('ul');

		if (!button.hasClass('open')) {
			action.toggle(true).fadeToggle(150);
		} else {
			action.toggle(false).fadeToggle(150);
		}
	})


	$(document).on('click', '.c-table__body-title-toggle', function (e) {
		e.preventDefault();
		const button = $(this);
		button.toggleClass('active');

		const table = $(this).parents('.c-table').find('.c-table__wrap');

		if (!button.hasClass('active')) {
			table.toggle(true).slideToggle(150);
		} else {
			table.toggle(false).slideToggle(150);
		}
	});

	$(document).on('click', '.c-table__body-cell-toggle', function (e) {
		e.preventDefault();
		const button = $(this);

		button.toggleClass('active');
		const row = $(this).parents('.c-table__body-row');
		const service = row.find('.c-table__body-row-service');

		if (!button.hasClass('active')) {
			row.toggleClass('open');
			service.toggle(true).slideToggle(150);
		} else {
			row.toggleClass('open');
			service.toggle(false).slideToggle(150);
		}
	});

	initCalendar();


	$(document).on('click', '#js-cabinet-cancel-appointment-button', function (e) {
		e.preventDefault();
		if (is_cabinet_form_sending) return false;

		const form = document.getElementById('js-cabinet-cancel-appointment-form');
		const data = new FormData(form);
		const preloader = form.querySelector('.preloader-modal-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		cabinetRequest('cancel_appointment', data).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				// showCodeConfirmationModal('cancel_appointment', response.data.message);
				$.fancybox.close();
				return;
			}
			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_cabinet_form_sending = false;
			getAppointments();
		});
	})

	$(document).on('click', '#js-cabinet-move-appointment-button', function (e) {
		e.preventDefault();
		if (is_cabinet_form_sending) return false;

		const form = document.getElementById('js-cabinet-move-appointment-form');
		const data = new FormData(form);
		const preloader = form.querySelector('.preloader-modal-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		const validator = new CabinetFormValidator('js-cabinet-move-appointment-form');
		validator.clearErrors();

		cabinetRequest('move_appointment', data).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				showCodeConfirmationModal('move_appointment', response.data.message);
				return;
			}
			if (response.success === false && response.data.code === 'validation_error') {
				validator.showErrors(response.data.errors);
				return;
			}
			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_cabinet_form_sending = false;
		});
	})

	$(document).on('click', '#js-cabinet-patient-data-button', function (e) {
		e.preventDefault();
		if (is_cabinet_form_sending) return false;

		const form = document.getElementById('js-cabinet-patient-data-form');
		const data = new FormData(form);
		const preloader = form.querySelector('.preloader-modal-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		const validator = new CabinetFormValidator('js-cabinet-patient-data-form');
		validator.clearErrors();

		cabinetRequest('edit_patient_info', data).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				showSuccessfulModal('edit_patient_info', response.data.message);
				togglePatientInfo();
				return;
			}
			if (response.success === false && response.data.code === 'validation_error') {
				validator.showErrors(response.data.errors);
				return;
			}
			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_cabinet_form_sending = false;
		});
	})

	$(document).on('click', '#js-cabinet-exit-button', function (e) {
		e.preventDefault();

		if (is_cabinet_form_sending) return false;

		const form = document.getElementById('js-cabinet-exit-form');
		const preloader = form.querySelector('.preloader-modal-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		cabinetRequest('cabinet_exit', []).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				const locale = document.documentElement.lang === 'ru' ? 'ru' : 'ua';
				location.href = `${location.protocol}//${location.host}/${locale}'`;
				return;
			}
			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_cabinet_form_sending = false;
		});
	})

	$(document).on('click', '#js-cabinet-send-document-button', function (e) {
		e.preventDefault();

		if (is_cabinet_form_sending) return false;

		const form = document.getElementById('js-cabinet-send-document-form');
		const data = new FormData(form);
		const preloader = form.querySelector('.preloader-modal-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		cabinetRequest('send_document', data).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				showSuccessfulModal('send_document', response.data.message);
				return;
			}
			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_cabinet_form_sending = false;
		});
	})

	$(document).on('click', '#js-show-more-button', function (e) {
		e.preventDefault();

		const target = $(e.target);
		const list = target.parent().nextAll();
		target.parent().remove();
		list.each((index, item) => {
			$(item).css({'opacity': '0',}).show().animate({opacity: 1});
			if ($(item).hasClass('show-more-row')) return false;
		})
	})

	//График врача
	$(document).on('click', function(e) {
		if (e.target.classList.contains('add-button') ||
			e.target.classList.contains('add-vacation-button') ||
			e.target.classList.contains('add-individual-day-button')) {

			e.preventDefault();

			const dayBlock = e.target.closest('.select-day-block');
			const day = dayBlock.dataset.day;
			const cloneContainer = document.getElementById(`${day}-fields-clone`) || dayBlock.querySelector(`#${day}-fields-clone`);

			let newBlockHTML = '';

			if (e.target.classList.contains('add-button')) {
				newBlockHTML = `
                <div class="select-day-block-fields">
                    <div class="select-day-block-fields-time">
                        <label class="input-form">
                            <?php _e("Початок", 'mz') ?>
                            <input type="time" name="${day}_start" placeholder="Оберіть час">
                        </label>
                        <label class="input-form">
                            <?php _e("Кінець", 'mz') ?>
                            <input type="time" name="${day}_end" placeholder="Оберіть час">
                        </label>
                    </div>
                    <div class="select-day-block-fields-type">
                        <label class="input-form">
                            <?php _e("Тип", 'mz') ?>
                            <div class="select-wrap" style="visibility: visible;">
                                <select class="type-select">
                                    <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="break">Перерва</option>
                                </select>
                            </div>
                        </label>
                        <label class="input-form">
                            <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                        </label>
                    </div>
                </div>
            `;
			} else if (e.target.classList.contains('add-vacation-button')) {
				const generateSelectOptions = (labelText, name) => `
                <label class="input-form">
                    <?php _e("${labelText}", 'mz') ?>
                    <div class="select-wrap" style="visibility: visible;">
                        <select class="type-select" name="${name}">
                            <option value="undefined" data-placeholder="true">${labelText}</option>
                            ${Array.from({ length: 31 }, (_, i) => `<option>${String(i + 1).padStart(2, '0')}</option>`).join('')}
                        </select>
                    </div>
                </label>
            `;

				newBlockHTML = `
                <div class="select-day-block-fields">
                    <div class="select-day-block-fields-dates">
                        ${generateSelectOptions("Початок", "vacation_start")}
                        ${generateSelectOptions("Кінець", "vacation_end")}
                    </div>
                    <div class="select-day-block-fields-btn">
                        <label class="input-form">
                            <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                        </label>
                    </div>
                </div>
            `;
			} else if (e.target.classList.contains('add-individual-day-button')) {
				newBlockHTML = `
                <div class="select-day-block-fields">
                    <div class="select-day-block-fields-dates">
                        <label class="input-form">
                            <?php _e("День", 'mz') ?>
                            <div class="select-wrap" style="visibility: visible;">
                                <select class="type-select">
                                    <option value="undefined" data-placeholder="true">Виберіть день</option>
                                    ${Array.from({ length: 31 }, (_, i) => `<option>${String(i + 1).padStart(2, '0')}</option>`).join('')}
                                </select>
                            </div>
                        </label>
                    </div>
                    <div class="select-day-block-fields-time">
                        <label class="input-form">
                            <?php _e("Початок", 'mz') ?>
                            <input type="time" name="${day}_start" placeholder="Оберіть час">
                        </label>
                        <label class="input-form">
                            <?php _e("Кінець", 'mz') ?>
                            <input type="time" name="${day}_end" placeholder="Оберіть час">
                        </label>
                    </div>
                    <div class="select-day-block-fields-type">
                        <label class="input-form">
                            <?php _e("Тип", 'mz') ?>
                            <div class="select-wrap" style="visibility: visible;">
                                <select class="type-select" name="${day}_type">
                                    <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="break">Перерва</option>
                                </select>
                            </div>
                        </label>
                        <label class="input-form">
                            <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                        </label>
                    </div>
                </div>
            `;
			}

			// Добавление нового блока в нужный контейнер
			cloneContainer.insertAdjacentHTML('beforeend', newBlockHTML);

			// Инициализация SlimSelect для нового select
			if (e.target.classList.contains('add-individual-day-button')) {
				const lastSelectDayBlockFields = cloneContainer.querySelector('.select-day-block-fields:last-child');
				const newSelects = lastSelectDayBlockFields.querySelectorAll('.type-select');

				newSelects.forEach(select => {
					if (select.ssm) {
						select.ssm.destroy();
					}
					new SlimSelect({
						select: select,
						placeholder: true,
						showSearch: false,
					});
				});
			} else if (e.target.classList.contains('add-vacation-button')) {
				const newSelects = cloneContainer.querySelectorAll('.select-day-block-fields:last-child .type-select');

				newSelects.forEach(select => {
					if (!select.slim) { // Проверяем, не инициализирован ли уже SlimSelect
						new SlimSelect({
							select: select,
							placeholder: true,
							showSearch: false,
						});
					}
				});
			} else {
				const newSelect = cloneContainer.querySelector('.select-day-block-fields:last-child .type-select');

				if (newSelect.ssm) {
					newSelect.ssm.destroy();
				}

				new SlimSelect({
					select: newSelect,
					placeholder: true,
					showSearch: false,
				});
			}
		}

		if (e.target.classList.contains('remove-button')) {
			e.preventDefault();
			const blockToRemove = e.target.closest('.select-day-block-fields');
			blockToRemove.remove();
		}
	});

	$(document).on('click', '#check-doctor-shedule', function (e) {
		window.scrollTo({
			top: 0,
			behavior: 'smooth',
		});
		e.preventDefault(); // Предотвращаем отправку формы
		console.log('func');

		const formData = {};

		// Получаем выбранный месяц и год
		const monthSelect = document.getElementById('month-select');
		const selectedMonth = parseInt(monthSelect.value, 10); // месяц в формате 01, 02 и т.д.
		const selectedYear = new Date().getFullYear(); // например, можно выбрать текущий год

		// Определяем количество дней в месяце
		const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

		// Составляем список дней месяца
		const monthDays = Array.from({ length: daysInMonth }, (_, i) => i + 1);

		// Получаем данные для каждого дня
		const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
		const weeklySchedule = {};

		days.forEach(day => {
			const dayBlocks = document.querySelectorAll(`div[data-day="${day}"] .select-day-block-fields`);
			const dayDataArray = [];

			dayBlocks.forEach(block => {
				const start = block.querySelector(`input[name^="${day}_start"]`).value;
				const end = block.querySelector(`input[name^="${day}_end"]`).value;
				const type = block.querySelector('.type-select').value;

				dayDataArray.push({
					start: start,
					end: end,
					type: type === 'break' ? 'перерва' : type
				});
			});

			weeklySchedule[day] = dayDataArray;
		});

		//общие поля
		formData['common'] = {
			month: selectedMonth,
			year: selectedYear
		};

		// Собираем данные для всех отпусков
		const vacationDataArray = [];
		const vacationBlocks = document.querySelectorAll('#vacation-template .select-day-block-fields');

		vacationBlocks.forEach(block => {
			const vacationStart = block.querySelector('select[name^="vacation_start"]').value;
			const vacationEnd = block.querySelector('select[name^="vacation_end"]').value;

			vacationDataArray.push({
				start: vacationStart,
				end: vacationEnd
			});
		});

		formData['vacation'] = vacationDataArray;

		// Получаем данные для індивідуальних днів (если есть)
		const individualDaysArray = [];
		const individualDayBlocks = document.querySelectorAll('#individual-day-template .select-day-block-fields');

		individualDayBlocks.forEach(block => {
			const daySelect = block.querySelector('select.type-select').value;
			const individualStart = block.querySelector('input[name="individual-day_start"]').value;
			const individualEnd = block.querySelector('input[name="individual-day_end"]').value;
			const individualType = block.querySelector('select[name="individual-day_type"]').value;

			individualDaysArray.push({
				day: parseInt(daySelect, 10),
				start: individualStart,
				end: individualEnd,
				type: individualType
			});
		});

		formData['individual_days'] = individualDaysArray;

		// Формируем итоговый график для месяца
		const monthSchedule = {};


		// 1. Заполняем индивидуальный график по числам
		individualDaysArray.forEach(schedule => {
			const dayOfMonth = schedule.day;

			// Пропускаем итерацию, если dayOfMonth является NaN
			if (isNaN(dayOfMonth)) {
				return; // Прерываем текущую итерацию и переходим к следующей
			}

			// Если для этого дня уже есть расписание, добавляем новое в массив
			if (!monthSchedule[dayOfMonth]) {
				monthSchedule[dayOfMonth] = [];
			}

			// Добавляем новое расписание в массив
			monthSchedule[dayOfMonth].push({
				start: schedule.start,
				end: schedule.end,
				type: schedule.type === 'break' ? 'перерва' : schedule.type
			});
		});


		// 2. Заполняем дни отпусков
		vacationDataArray.forEach(vacation => {
			const vacationStart = parseInt(vacation.start, 10);
			const vacationEnd = parseInt(vacation.end, 10);

			for (let day = vacationStart; day <= vacationEnd; day++) {
				monthSchedule[day] = {
					start: null,
					end: null,
					type: 'Vacation'
				};
			}
		});

		// 3. Заполняем оставшиеся дни общим графиком
		monthDays.forEach(day => {
			if (!monthSchedule[day]) {
				const date = new Date(selectedYear, selectedMonth - 1, day);
				const weekDayIndex = (date.getDay() + 6) % 7; // Преобразуем 0 (воскресенье) в 6 и 1 (понедельник) в 0
				const weekDay = days[weekDayIndex]; // Получаем день недели в вашем формате

				monthSchedule[day] = weeklySchedule[weekDay] || [];
			}
		});


		// Выводим итоговый график
		formData['month_schedule'] = monthSchedule;

		// 4. Создание таблицы на основе month_schedule
		const scheduleTable = document.createElement('table');
		scheduleTable.classList.add('c-doctor-shedule-wrap-tab-table');

		const tableHeader = `
        <tr>
            <th>День</th>
            <th>Початок</th>
            <th>Кінець</th>
            <th>Тип</th>
        </tr>`;
		scheduleTable.innerHTML = tableHeader;

		const dayAbbreviations = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'нд'];

		Object.keys(formData['month_schedule']).forEach(day => {
			const daySchedules = formData['month_schedule'][day];
			const dayNumber = parseInt(day, 10);

			// Создаём объект Date для получения дня недели
			const date = new Date(selectedYear, selectedMonth - 1, dayNumber);
			// Получаем индекс дня недели (0 - воскресенье, 1 - понедельник, и т.д.)
			let weekDayIndex = date.getDay();
			// Преобразуем индекс, чтобы 0 соответствовал понедельнику
			weekDayIndex = (weekDayIndex + 6) % 7;
			const weekDayAbbr = dayAbbreviations[weekDayIndex];

			const dayCell = `${dayNumber} (${weekDayAbbr})`;

			if (Array.isArray(daySchedules)) {
				daySchedules.forEach(schedule => {
					const row = document.createElement('tr');
					row.innerHTML = `
                    <td>${dayCell}</td>
                    <td>${schedule.start || '—'}</td>
                    <td>${schedule.end || '—'}</td>
                    <td>${schedule.type !== 'undefined' && schedule.type !== null && schedule.type !== '' ? schedule.type : '—'}</td>
                `;
					scheduleTable.appendChild(row);
				});
			} else {
				const row = document.createElement('tr');
				row.innerHTML = `
                <td>${dayCell}</td>
                <td colspan="3" class="text-center">Відпустка</td>
            `;
				scheduleTable.appendChild(row);
			}
		});

		//Очистка контейнера и вставка таблицы
		// const scheduleContainer = document.querySelector('.c-doctor-shedule-wrap');
		// scheduleContainer.innerHTML = ''; // Очистка перед вставкой
		// scheduleContainer.appendChild(scheduleTable);

		// Скрываем исходный контейнер с формой
		const inputFormContainer = document.querySelector('.c-doctor-shedule-wrap');
		inputFormContainer.style.display = 'none';

		// Проверяем, существует ли уже outputContainer
		let outputContainer = document.querySelector('.c-doctor-shedule-wrap-tab');

		if (!outputContainer) {
			// Если outputContainer не существует, создаём его
			outputContainer = document.createElement('div');
			outputContainer.classList.add('c-doctor-shedule-wrap-tab');

			// Добавляем новый контейнер в DOM после скрытого исходного контейнера
			inputFormContainer.parentElement.appendChild(outputContainer);
		} else {
			// Если существует, очищаем его содержимое
			outputContainer.innerHTML = '';
			outputContainer.style.display = 'block'; // Показываем контейнер, если он был скрыт
		}

		// Создаем інфо блок
		var infoBlock = document.createElement('div');
		infoBlock.classList.add('info-block');

		// Создаем элемент svg и добавляем его в блок
		var svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
		svgElement.setAttribute('class', 'info-icon');
		svgElement.setAttribute('width', '24');
		svgElement.setAttribute('height', '24');
		svgElement.setAttribute('viewBox', '0 0 20 20');
		svgElement.setAttribute('fill', 'none');
		svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');

		// Добавляем path в svg
		var pathElement = document.createElementNS('http://www.w3.org/2000/svg', 'path');
		pathElement.setAttribute('d', 'M10.0022 20C7.68857 20.0005 5.4464 19.1988 3.65767 17.7314C1.86895 16.2641 0.644355 14.2219 0.192549 11.9528C-0.259257 9.68381 0.0896814 7.32832 1.17991 5.28771C2.27013 3.24711 4.03419 1.64766 6.1715 0.761905C8.30881 -0.123853 10.6871 -0.241117 12.9012 0.430093C15.1153 1.1013 17.0281 2.51946 18.3138 4.44292C19.5995 6.36637 20.1784 8.67612 19.952 10.9786C19.7256 13.2811 18.7079 15.4338 17.0722 17.07C15.1972 18.9455 12.6541 19.9994 10.0022 20ZM10.0022 1.9C8.80485 1.90065 7.62257 2.16673 6.54043 2.67908C5.45828 3.19142 4.50318 3.9373 3.74385 4.86303C2.98453 5.78875 2.43987 6.8713 2.14908 8.03276C1.85829 9.19422 1.8286 10.4057 2.06215 11.58C2.37883 13.1483 3.1512 14.5883 4.28253 15.7196C5.41387 16.851 6.85386 17.6233 8.42215 17.94C9.5323 18.164 10.6771 18.1526 11.7826 17.9068C12.8881 17.6609 13.9297 17.1859 14.8403 16.5125C15.7508 15.8392 16.5101 14.9823 17.069 13.9973C17.6278 13.0123 17.974 11.9211 18.085 10.794C18.196 9.66695 18.0695 8.52915 17.7135 7.45404C17.3575 6.37892 16.7801 5.3904 16.0184 4.55229C15.2567 3.71418 14.3278 3.0451 13.2915 2.58826C12.2552 2.13141 11.1347 1.89695 10.0022 1.9ZM10.0022 15.15C9.8774 15.1507 9.7538 15.1262 9.6387 15.0781C9.52359 15.03 9.41934 14.9592 9.33215 14.87C9.15816 14.6896 9.05824 14.4505 9.05215 14.2V9.88C9.05573 9.626 9.15584 9.38288 9.33215 9.2C9.41934 9.11078 9.52359 9.04001 9.6387 8.99191C9.7538 8.9438 9.8774 8.91935 10.0022 8.92C10.2674 8.92 10.5217 9.02536 10.7093 9.2129C10.8968 9.40043 11.0022 9.65479 11.0022 9.92V14.2C10.9893 14.4565 10.8783 14.6981 10.6922 14.875C10.506 15.0519 10.2589 15.1503 10.0022 15.15ZM10.0022 7.73C9.81325 7.73235 9.6282 7.67649 9.47215 7.57C9.31476 7.46968 9.19245 7.32291 9.12215 7.15C9.05228 6.97196 9.03492 6.77761 9.07215 6.59C9.11512 6.41034 9.207 6.24609 9.33762 6.11547C9.46824 5.98485 9.63249 5.89297 9.81215 5.85C9.99129 5.79455 10.183 5.79455 10.3622 5.85C10.5398 5.91665 10.6908 6.03956 10.7922 6.2C10.8986 6.35605 10.9545 6.5411 10.9522 6.73C10.954 6.85679 10.9302 6.98265 10.8822 7.1C10.8311 7.21498 10.76 7.31995 10.6722 7.41C10.5843 7.49806 10.4786 7.56626 10.3622 7.61C10.2448 7.65805 10.1189 7.68187 9.99215 7.68L10.0022 7.73Z');
		pathElement.setAttribute('fill', '#0075FF');
		svgElement.appendChild(pathElement);

		var title = document.createElement('p');
		title.classList.add('info-text');
		title.textContent = 'Графік за ' + getMonthName(selectedMonth);

		// Вставляем svg и заголовок в блок infoBlock
		infoBlock.appendChild(svgElement);
		infoBlock.appendChild(title);

		// Добавляем блок
		outputContainer.appendChild(infoBlock);

		// Добавляем таблицу в новый контейнер
		outputContainer.appendChild(scheduleTable);

		// Итоговые кнопки и форма
		const formElement = document.createElement('form');
		formElement.classList.add('form-default');
		formElement.id = 'form-send-doctor-schedule';

		// Добавляем скрытое поле для передачи данных formData
		const hiddenInput = document.createElement('input');
		hiddenInput.type = 'hidden';
		hiddenInput.name = 'scheduleData';
		hiddenInput.value = JSON.stringify(formData); // Преобразуем объект formData в строку JSON

		formElement.appendChild(hiddenInput);

		// Создаем интерактивный блок перед кнопками
		const interactiveContainer = document.createElement('div');
		interactiveContainer.classList.add('c-modal__body-interactive');
		interactiveContainer.innerHTML = `
            <span class="error-msg"></span>
        `;


		formElement.appendChild(interactiveContainer);

		// Создаем новый div для загрузочной рамки
		const loadingFrame = document.createElement('div');
		loadingFrame.classList.add('loading-frame', 'loading-frame-select-download-send', 'd-none');
		loadingFrame.innerHTML = `
            <svg width="32px" height="24px">
                <polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
                <polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
            </svg>
        `;

		// Добавляем загрузочную рамку в formElement
		formElement.appendChild(loadingFrame);

		const buttonsContainer = document.createElement('div');
		buttonsContainer.classList.add('button-container');
		buttonsContainer.innerHTML = `
            <button class="btn btn-secondary" id="cancel-button" style="margin-top: 20px;">скасувати</a>
            <button class="btn btn-confirm" id="check-doctor-shedule-send">Так, все вірно!</button>
        `;

		formElement.appendChild(buttonsContainer);
		// scheduleContainer.appendChild(formElement);
		outputContainer.appendChild(formElement);

		// Добавляем новый контейнер в DOM после скрытого исходного контейнера
		inputFormContainer.parentElement.appendChild(outputContainer);

		// Добавляем обработчик события для кнопки "скасувати"
		document.getElementById('cancel-button').addEventListener('click', function (e) {
			e.preventDefault();
			outputContainer.style.display = 'none'; // Скрываем контейнер с таблицей
			inputFormContainer.style.display = 'block'; // Показываем исходный контейнер с формой
		});
	});

	$(document).on('click', '#check-doctor-shedule-send', function (e) {
		e.preventDefault();

		document.querySelector('.loading-frame-select-download-send').classList.remove('d-none');

		const scheduleData = $('input[name="scheduleData"]').val();

		const parsedScheduleData = JSON.parse(scheduleData);

		jQuery.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: "POST",
			cache: false,
			data: {
				action: 'send_doctor_schedule',
				formData: parsedScheduleData
			},
			success: function (response) {
				if (response.success === true) {
					const locale = document.documentElement.lang === 'ru' ? 'ru' : 'ua';
					location.href = `${location.protocol}//${location.host}/${locale}/cabinet/doctor-shedule/`;
					document.querySelector('.loading-frame-select-download-send').classList.add('d-none');
					return;
				}
				console.log(response);
				const form = document.getElementById('form-send-doctor-schedule');
				const error = form.querySelector('.error-msg');
				error.innerHTML = response.data.message;
				document.querySelector('.loading-frame-select-download-send').classList.add('d-none');
			}

		})
	});

	$(document).on('click', '#download-last-doctor-shedule', function (e) {
		e.preventDefault();

		document.querySelector('.loading-frame-select-download').classList.remove('d-none');

		jQuery.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: "POST",
			cache: false,
			data: {
				action: 'get_doctor_schedule'
			},
			success: function (response) {
				if (response.success === true) {
					const data = response.data;

					// Извлекаем месяц и год
					const selectedMonth = parseInt(data.month, 10);
					const selectedYear = parseInt(data.year, 10);

					// Получаем количество дней в месяце
					const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
					const monthDays = Array.from({ length: daysInMonth }, (_, i) => i + 1);

					// Инициализируем объекты для хранения расписаний и отпусков
					const scheduleItemsPerDay = {};
					const vacationDays = [];

					// Разбираем расписания и отпуска для каждого дня
					monthDays.forEach(day => {
						const dayKey = 'day' + String(day).padStart(2, '0'); // Пример: day01, day02

						if (data.hasOwnProperty(dayKey)) {
							const dayData = data[dayKey]; // Массив строк

							if (Array.isArray(dayData) && dayData.length > 0) {
								if (dayData[0] === 'Vacation') {
									// Отмечаем как отпуск
									vacationDays.push(day);
								} else if (dayData[0] !== '') {
									// Парсим каждое расписание
									const scheduleItems = dayData.map(item => JSON.parse(item));

									// Сохраняем расписания для этого дня
									scheduleItemsPerDay[day] = scheduleItems;
								}
							}
						}
					});

					// Соответствие дней месяца дням недели
					const scheduleByDayOfWeek = {
						monday: [],
						tuesday: [],
						wednesday: [],
						thursday: [],
						friday: [],
						saturday: [],
						sunday: []
					};

					const individualDays = [];

					monthDays.forEach(day => {
						const date = new Date(selectedYear, selectedMonth - 1, day);
						const weekDayIndex = date.getDay(); // 0=Воскресенье, 1=Понедельник, ..., 6=Суббота
						const daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
						const weekDay = daysOfWeek[weekDayIndex];

						if (vacationDays.includes(day)) {
							// Пропускаем дни отпуска
							return;
						}

						if (scheduleItemsPerDay.hasOwnProperty(day)) {
							const scheduleItems = scheduleItemsPerDay[day];

							// Добавляем расписание в соответствующий день недели
							scheduleByDayOfWeek[weekDay].push({
								day: day,
								schedule: scheduleItems
							});
						}
					});

					// Определяем еженедельные расписания и индивидуальные дни
					const weeklySchedule = {};

					for (const [weekDay, daySchedules] of Object.entries(scheduleByDayOfWeek)) {
						if (daySchedules.length === 0) {
							continue;
						}

						// Получаем расписания для дней
						const schedulesList = daySchedules.map(ds => ds.schedule);

						// Проверяем, все ли расписания идентичны
						const firstScheduleJSON = JSON.stringify(schedulesList[0]);
						const isConsistent = schedulesList.every(sch => JSON.stringify(sch) === firstScheduleJSON);

						if (isConsistent && daySchedules.length > 1) {
							// Считаем как еженедельное расписание
							weeklySchedule[weekDay] = daySchedules[0].schedule;
						} else {
							// Добавляем в индивидуальные дни
							daySchedules.forEach(ds => {
								individualDays.push({
									day: ds.day,
									schedule: ds.schedule
								});
							});
						}
					}

					// Устанавливаем выбранный месяц в селекте
					const monthSelect = document.getElementById('month-select');
					if (monthSelect) {
						monthSelect.value = String(selectedMonth).padStart(2, '0');
					}

					// Инициализируем SlimSelect для month-select
					if (monthSelect.slim) {
						monthSelect.slim.set(String(selectedMonth).padStart(2, '0'));
					} else {
						new SlimSelect({
							select: monthSelect,
							placeholder: true,
							showSearch: false,
						});
					}

					// Заполняем еженедельные расписания
					for (const [weekDay, scheduleItems] of Object.entries(weeklySchedule)) {
						const dayBlock = document.querySelector(`.select-day-block[data-day="${weekDay}"]`);
						if (dayBlock) {
							const fieldsContainer = dayBlock.querySelector('.select-day-block-fields');
							const cloneContainer = dayBlock.querySelector(`#${weekDay}-fields-clone`);

							// Очищаем существующие клонированные поля
							if (cloneContainer) {
								cloneContainer.innerHTML = '';
							}

							if (scheduleItems.length > 1) {
								// Заполняем первые поля
								const firstItem = scheduleItems[0];
								fieldsContainer.querySelector(`input[name="${weekDay}_start"]`).value = firstItem.start;
								fieldsContainer.querySelector(`input[name="${weekDay}_end"]`).value = firstItem.end;
								const typeSelect = fieldsContainer.querySelector('.type-select');
								typeSelect.value = firstItem.type;

								if (typeSelect.slim) {
									typeSelect.slim.set(firstItem.type);
								} else {
									new SlimSelect({
										select: typeSelect,
										placeholder: true,
										showSearch: false,
									});
								}

								// Клонируем остальные расписания
								for (let i = 1; i < scheduleItems.length; i++) {
									const item = scheduleItems[i];
									const newBlockHTML = `
                                <div class="select-day-block-fields">
                                    <div class="select-day-block-fields-time">
                                        <label class="input-form">
                                            Початок
                                            <input type="time" name="${weekDay}_start" value="${item.start}" placeholder="Оберіть час">
                                        </label>
                                        <label class="input-form">
                                            Кінець
                                            <input type="time" name="${weekDay}_end" value="${item.end}" placeholder="Оберіть час">
                                        </label>
                                    </div>
                                    <div class="select-day-block-fields-type">
                                        <label class="input-form">
                                            Тип
                                            <div class="select-wrap" style="visibility: visible;">
                                                <select class="type-select">
                                                    <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                                    <option value="online">Online</option>
                                                    <option value="offline">Offline</option>
                                                    <option value="break">Перерва</option>
                                                </select>
                                            </div>
                                        </label>
                                        <label class="input-form">
                                            <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                                        </label>
                                    </div>
                                </div>
                                `;
									cloneContainer.insertAdjacentHTML('beforeend', newBlockHTML);

									// Инициализируем SlimSelect для нового select
									const lastFields = cloneContainer.querySelector('.select-day-block-fields:last-child');
									const newSelect = lastFields.querySelector('.type-select');
									newSelect.value = item.type;

									if (newSelect.slim) {
										newSelect.slim.set(item.type);
									} else {
										new SlimSelect({
											select: newSelect,
											placeholder: true,
											showSearch: false,
										});
									}
								}
							} else {
								// Заполняем первые поля
								const item = scheduleItems[0];
								fieldsContainer.querySelector(`input[name="${weekDay}_start"]`).value = item.start;
								fieldsContainer.querySelector(`input[name="${weekDay}_end"]`).value = item.end;
								const typeSelect = fieldsContainer.querySelector('.type-select');
								typeSelect.value = item.type;

								if (typeSelect.slim) {
									typeSelect.slim.set(item.type);
								} else {
									new SlimSelect({
										select: typeSelect,
										placeholder: true,
										showSearch: false,
									});
								}

								// Очищаем клонированные поля
								if (cloneContainer) {
									cloneContainer.innerHTML = '';
								}
							}
						}
					}

					// Заполняем индивидуальные дни
					const individualDayTemplate = document.getElementById('individual-day-template');
					const individualDayFieldsContainer = individualDayTemplate.querySelector('.select-day-block-fields');
					const individualDayCloneContainer = individualDayTemplate.querySelector('#individual-day-fields-clone');

					// Очищаем существующие клонированные поля
					individualDayCloneContainer.innerHTML = '';

					if (individualDays.length > 0) {
						// Если есть индивидуальные дни, заполняем первое поле
						const firstDaySchedule = individualDays[0];
						const firstScheduleItem = firstDaySchedule.schedule[0];

						// Заполняем поля
						const daySelect = individualDayFieldsContainer.querySelector('.select-day-block-fields-dates .type-select');
						daySelect.value = String(firstDaySchedule.day).padStart(2, '0');

						if (daySelect.slim) {
							daySelect.slim.set(String(firstDaySchedule.day).padStart(2, '0'));
						} else {
							new SlimSelect({
								select: daySelect,
								placeholder: true,
								showSearch: false,
							});
						}

						individualDayFieldsContainer.querySelector('input[name="individual-day_start"]').value = firstScheduleItem.start;
						individualDayFieldsContainer.querySelector('input[name="individual-day_end"]').value = firstScheduleItem.end;

						const typeSelect = individualDayFieldsContainer.querySelector('.select-day-block-fields-type .type-select');
						typeSelect.value = firstScheduleItem.type;

						if (typeSelect.slim) {
							typeSelect.slim.set(firstScheduleItem.type);
						} else {
							new SlimSelect({
								select: typeSelect,
								placeholder: true,
								showSearch: false,
							});
						}

						// Если есть больше индивидуальных дней, добавляем их
						for (let i = 1; i < individualDays.length; i++) {
							const daySchedule = individualDays[i];
							daySchedule.schedule.forEach(item => {
								const newBlockHTML = `
                            <div class="select-day-block-fields">
                                <div class="select-day-block-fields-dates">
                                    <label class="input-form">
                                        День
                                        <div class="select-wrap" style="visibility: visible;">
                                            <select class="type-select">
                                                <option value="undefined" data-placeholder="true">Виберіть день</option>
                                                ${Array.from({ length: 31 }, (_, idx) => `<option ${daySchedule.day === (idx + 1) ? 'selected' : ''}>${String(idx + 1).padStart(2, '0')}</option>`).join('')}
                                            </select>
                                        </div>
                                    </label>
                                </div>
                                <div class="select-day-block-fields-time">
                                    <label class="input-form">
                                        Початок
                                        <input type="time" name="individual-day_start" value="${item.start}" placeholder="Оберіть час">
                                    </label>
                                    <label class="input-form">
                                        Кінець
                                        <input type="time" name="individual-day_end" value="${item.end}" placeholder="Оберіть час">
                                    </label>
                                </div>
                                <div class="select-day-block-fields-type">
                                    <label class="input-form">
                                        Тип
                                        <div class="select-wrap" style="visibility: visible;">
                                            <select class="type-select" name="individual-day_type">
                                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                                <option value="online" ${item.type === 'online' ? 'selected' : ''}>Online</option>
                                                <option value="offline" ${item.type === 'offline' ? 'selected' : ''}>Offline</option>
                                                <option value="break" ${item.type === 'break' ? 'selected' : ''}>Перерва</option>
                                            </select>
                                        </div>
                                    </label>
                                    <label class="input-form">
                                        <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                                    </label>
                                </div>
                            </div>
                            `;

								individualDayCloneContainer.insertAdjacentHTML('beforeend', newBlockHTML);

								// Инициализируем SlimSelect для новых select
								const lastFields = individualDayCloneContainer.querySelector('.select-day-block-fields:last-child');
								const daySelect = lastFields.querySelector('.select-day-block-fields-dates .type-select');
								const typeSelect = lastFields.querySelector('.select-day-block-fields-type .type-select');

								if (daySelect.slim) {
									daySelect.slim.set(String(daySchedule.day).padStart(2, '0'));
								} else {
									new SlimSelect({
										select: daySelect,
										placeholder: true,
										showSearch: false,
									});
								}

								if (typeSelect.slim) {
									typeSelect.slim.set(item.type);
								} else {
									new SlimSelect({
										select: typeSelect,
										placeholder: true,
										showSearch: false,
									});
								}
							});
						}
					} else {
						// Если нет индивидуальных дней, очищаем первое поле
						individualDayFieldsContainer.querySelector('input[name="individual-day_start"]').value = '';
						individualDayFieldsContainer.querySelector('input[name="individual-day_end"]').value = '';
						const daySelect = individualDayFieldsContainer.querySelector('.select-day-block-fields-dates .type-select');
						if (daySelect.slim) {
							daySelect.slim.set('undefined');
						} else {
							new SlimSelect({
								select: daySelect,
								placeholder: true,
								showSearch: false,
							});
						}
						const typeSelect = individualDayFieldsContainer.querySelector('.select-day-block-fields-type .type-select');
						if (typeSelect.slim) {
							typeSelect.slim.set('undefined');
						} else {
							new SlimSelect({
								select: typeSelect,
								placeholder: true,
								showSearch: false,
							});
						}
					}

					// Обрабатываем отпуска
					if (vacationDays.length > 0) {
						// Функция для нахождения непрерывных периодов
						function findContinuousRanges(arr) {
							const ranges = [];
							arr.sort((a, b) => a - b);
							let start = arr[0];
							let end = arr[0];

							for (let i = 1; i < arr.length; i++) {
								if (arr[i] === end + 1) {
									end = arr[i];
								} else {
									ranges.push({ start, end });
									start = arr[i];
									end = arr[i];
								}
							}
							ranges.push({ start, end });
							return ranges;
						}

						const vacationRanges = findContinuousRanges(vacationDays);

						const vacationTemplate = document.getElementById('vacation-template');
						const vacationFieldsContainer = vacationTemplate.querySelector('.select-day-block-fields');
						const vacationCloneContainer = vacationTemplate.querySelector('#vacation-fields-clone');

						// Очищаем существующие клонированные поля
						vacationCloneContainer.innerHTML = '';

						if (vacationRanges.length > 0) {
							// Заполняем первое поле
							const firstRange = vacationRanges[0];

							const startSelect = vacationFieldsContainer.querySelector('select[name="vacation_start"]');
							const endSelect = vacationFieldsContainer.querySelector('select[name="vacation_end"]');

							startSelect.value = String(firstRange.start).padStart(2, '0');
							endSelect.value = String(firstRange.end).padStart(2, '0');

							if (startSelect.slim) {
								startSelect.slim.set(String(firstRange.start).padStart(2, '0'));
							} else {
								new SlimSelect({
									select: startSelect,
									placeholder: true,
									showSearch: false,
								});
							}

							if (endSelect.slim) {
								endSelect.slim.set(String(firstRange.end).padStart(2, '0'));
							} else {
								new SlimSelect({
									select: endSelect,
									placeholder: true,
									showSearch: false,
								});
							}

							// Если есть больше отпусков, добавляем их
							for (let i = 1; i < vacationRanges.length; i++) {
								const range = vacationRanges[i];
								const newBlockHTML = `
                            <div class="select-day-block-fields">
                                <div class="select-day-block-fields-dates">
                                    <label class="input-form">
                                        Початок
                                        <div class="select-wrap" style="visibility: visible;">
                                            <select class="type-select" name="vacation_start">
                                                <option value="undefined" data-placeholder="true">Початок</option>
                                                ${Array.from({ length: 31 }, (_, idx) => `<option ${range.start === (idx + 1) ? 'selected' : ''}>${String(idx + 1).padStart(2, '0')}</option>`).join('')}
                                            </select>
                                        </div>
                                    </label>
                                    <label class="input-form">
                                        Кінець
                                        <div class="select-wrap" style="visibility: visible;">
                                            <select class="type-select" name="vacation_end">
                                                <option value="undefined" data-placeholder="true">Кінець</option>
                                                ${Array.from({ length: 31 }, (_, idx) => `<option ${range.end === (idx + 1) ? 'selected' : ''}>${String(idx + 1).padStart(2, '0')}</option>`).join('')}
                                            </select>
                                        </div>
                                    </label>
                                </div>
                                <div class="select-day-block-fields-btn">
                                    <label class="input-form">
                                        <a href="#" class="btn c-sidebar-mob-button remove-button">видалити</a>
                                    </label>
                                </div>
                            </div>
                            `;

								vacationCloneContainer.insertAdjacentHTML('beforeend', newBlockHTML);

								// Инициализируем SlimSelect для новых select
								const lastFields = vacationCloneContainer.querySelector('.select-day-block-fields:last-child');
								const startSelect = lastFields.querySelector('select[name="vacation_start"]');
								const endSelect = lastFields.querySelector('select[name="vacation_end"]');

								if (startSelect.slim) {
									startSelect.slim.set(String(range.start).padStart(2, '0'));
								} else {
									new SlimSelect({
										select: startSelect,
										placeholder: true,
										showSearch: false,
									});
								}

								if (endSelect.slim) {
									endSelect.slim.set(String(range.end).padStart(2, '0'));
								} else {
									new SlimSelect({
										select: endSelect,
										placeholder: true,
										showSearch: false,
									});
								}
							}
						}
					} else {
						// Если нет отпусков, очищаем первое поле
						const vacationTemplate = document.getElementById('vacation-template');
						const vacationFieldsContainer = vacationTemplate.querySelector('.select-day-block-fields');

						const startSelect = vacationFieldsContainer.querySelector('select[name="vacation_start"]');
						const endSelect = vacationFieldsContainer.querySelector('select[name="vacation_end"]');

						startSelect.value = 'undefined';
						endSelect.value = 'undefined';

						if (startSelect.slim) {
							startSelect.slim.set('undefined');
						} else {
							new SlimSelect({
								select: startSelect,
								placeholder: true,
								showSearch: false,
							});
						}

						if (endSelect.slim) {
							endSelect.slim.set('undefined');
						} else {
							new SlimSelect({
								select: endSelect,
								placeholder: true,
								showSearch: false,
							});
						}

						// Очищаем клонированные поля
						const vacationCloneContainer = vacationTemplate.querySelector('#vacation-fields-clone');
						vacationCloneContainer.innerHTML = '';
					}

					// Теперь все поля формы заполнены на основе полученных данных
					const form = document.getElementById('js-cabinet-load-page-content');
					const error = form.querySelector('.error-msg');
					error.innerHTML = '';
					document.querySelector('.loading-frame-select-download').classList.add('d-none');
					return;
				}
				// Обработка ошибок
				console.log(response);
				const form = document.getElementById('js-cabinet-load-page-content');
				const error = form.querySelector('.error-msg');
				error.innerHTML = response.data.message;
				document.querySelector('.loading-frame-select-download').classList.add('d-none');
			}
		});
	});
})

//на бэкенде если пустые то выводим за последний месяц
function getArchiveAppointments(dates) {
	if (is_cabinet_form_sending) return false;

	const table = document.querySelector('.c-table.archive .c-table__body-wrap');
	table.style.opacity = '0.4';

	const data = _creatingDateRange(dates);

	cabinetRequest('get_archive_appointments', data).then(
		resp => resp.json()
	).then(response => {
		if (response.success === false) {
			return;
		}
		table.innerHTML = response.data;
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		table.style.opacity = '1';
		is_cabinet_form_sending = false;
	});
}

function getDocuments(dates) {

	if (is_cabinet_form_sending) return false;

	const table = document.querySelector('.c-table.analysis .c-table__body-wrap');
	table.style.opacity = '0.4';

	const data = _creatingDateRange(dates);

	cabinetRequest('get_documents', data).then(
		resp => resp.json()
	).then(response => {
		if (response.success === false) {
			return;
		}
		table.innerHTML = response.data;
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		table.style.opacity = '1';
		is_cabinet_form_sending = false;
	});
}

function getAppointments() {
	if (is_cabinet_form_sending) return false;

	const table = document.querySelector('.c-table.appointments .c-table__body-wrap');
	table.style.opacity = '0.4';

	cabinetRequest('get_appointments', []).then(
		resp => resp.json()
	).then(response => {
		if (response.success === false) {
			return;
		}
		table.innerHTML = response.data;
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		table.style.opacity = '1';
		is_cabinet_form_sending = false;
	});
}

function moveAppointment(appointment_id, physician_name, speciality_name, event_name) {
	clearFormInModal('js-cabinet-move-appointment-modal');

	const form = document.getElementById('js-cabinet-move-appointment-form');
	form.appointmentId.value = appointment_id;
	form.querySelector('#js-move-appointment-form__PhysicianName').innerHTML = physician_name;
	form.querySelector('#js-move-appointment-form__SpecialityName').innerHTML = speciality_name;
	form.querySelector('#js-move-appointment-form__EventName').innerHTML = event_name;

	$.fancybox.open({
		src: '#js-cabinet-move-appointment-modal',
		type: 'inline',
		opts: {
			smallBtn: false,
			toolbar: false,
			touch: false,
			keyboard: false
		}
	});
}

function changeAppointment(speciality_id, api_id, EmpId, AppointmentId, appointment_date) {
	const locale = document.documentElement.lang === 'ru' ? '' : 'ua/';
	const link = `${location.protocol}//${location.host}/${locale}schedule/?cancel_speciality_id=${speciality_id}&cancel_api_id=${api_id}&cancel_emp_id=${EmpId}&cancel_appointment_id=${AppointmentId}&cancel_appointment_date=${appointment_date}`;
	if (window.open(link, '_blank') === null) {
		cabinet_open_file(link);
	}
}

function cancelAppointment(appointment_id, appointment_date, doctor_id) {
	clearFormInModal('js-cabinet-cancel-appointment-modal');

	const form = document.getElementById('js-cabinet-cancel-appointment-form');
	form.appointmentId.value = appointment_id;
	form.appointmentDate.value = appointment_date;
	form.doctorId.value = doctor_id;

	$.fancybox.open({
		src: '#js-cabinet-cancel-appointment-modal',
		type: 'inline',
		opts: {
			smallBtn: false,
			toolbar: false,
			touch: false,
			keyboard: false
		}
	});
}

function cabinetExit() {
	clearFormInModal('js-cabinet-exit-modal');

	$.fancybox.open({
		src: '#js-cabinet-exit-modal',
		type: 'inline',
		opts: {
			smallBtn: false,
			toolbar: false,
			touch: false,
			keyboard: false
		}
	});
}

function sendDocument(document_name, document_url) {
	clearFormInModal('js-cabinet-send-document-modal');

	const form = document.getElementById('js-cabinet-send-document-form');
	form.documentUrl.value = document_url;
	form.documentName.value = document_name;

	$.fancybox.open({
		src: '#js-cabinet-send-document-modal',
		type: 'inline',
		opts: {
			smallBtn: false,
			toolbar: false,
			touch: false,
			keyboard: false
		}
	});
}

function openDocument(document_name, document_url) {
	const data = new FormData();
	data.append('documentUrl', document_url);
	data.append('documentName', document_name);

	cabinetRequest('open_document', data).then(
		resp => resp.json()
	).then(response => {
		if (response.success === false) {
			showSuccessfulModal('open_document', response.data.message);
			return;
		}
		if (!response.data) {
			return;
		}
		if (window.open(response.data, '_blank') === null) {
			cabinet_open_file(response.data);
		}
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		is_cabinet_form_sending = false;
	});
}

function downloadDocument(document_name, document_url) {
	const data = new FormData();
	data.append('documentUrl', document_url);

	cabinetRequest('download_document', data).then(
		resp => resp.blob()
	).then(response => {
		if (!response) {
			showSuccessfulModal('download_document', 'Помилка! Неможливо завантажити файл');
			return;
		}

		// const blob = new Blob([response]);//, {type: 'application/pdf;charset=utf-8'}
		// window.saveAs(blob, document_name);
		saveDownloadedFile(document_name, response);

		// saveDownloadedFile(document_name, response).then(() => {
		// 	// showSuccessfulModal('download_document', 'Файл буде завантажено');
		// })
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		is_cabinet_form_sending = false;
	});
}

function togglePatientInfo() {
	const info = document.querySelector('.c-patient .c-patient__info');
	$(info).toggle();
	const form = document.querySelector('.c-patient .c-patient__form');
	$(form).toggle();
	if (form.offsetParent === null) {
		document.querySelector('.c-patient').scrollIntoView({block: "center"});//{behavior: "smooth", block: "center"}
	} else {
		new CabinetFormValidator('js-cabinet-patient-data-form').clearErrors();
	}
}

function initInputMask() {
	const inputTels = document.querySelectorAll('input[type="tel"]');

	if (inputTels != null) {
		inputTels.forEach(inputTel => {
			Inputmask({
				"mask": "+38 (999) 99 99 999"
			}).mask(inputTel);
		});
	}
}

function initCalendar() {
	flatpickr.defaultConfig.prevArrow = `<svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.19329 9.07846L6.63424 7.51941L0 14.1537L6.63424 20.7879L8.19329 19.2288L3.12915 14.1537L8.19329 9.07846Z" fill="black" fill-opacity="0.6"/>
</svg>`;
	flatpickr.defaultConfig.nextArrow = `<svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M2.35934 7.51953L0.800293 9.07858L5.86443 14.1538L0.800293 19.229L2.35934 20.788L8.99358 14.1538L2.35934 7.51953Z" fill="black" fill-opacity="0.6"/>
</svg>`;
	const cabinetDateRange = $('#cabinetDateRange');
	const fp_buttons = `<button class="btn btn-cancel">скасувати</button><button class="btn btn-confirm">застосувати</button>`;

	const default_dates = cabinetDateRange?.data('default-date')?.split('-');
	const defaultDate = (default_dates && default_dates[0] && default_dates[1]) ? [default_dates[0], default_dates[1]] : '';

	flatpickr(cabinetDateRange, {
		mode: 'range',
		maxDate: 'today',
		closeOnSelect: false,
		locale: cabinetDateRange.data('lang'),
		dateFormat: 'd. m. Y',
		defaultDate: defaultDate,
		// disableMobile: true,
		// static: true,
		onReady: function () {
			const fp = this;
			// fp.currentYearElement.setAttribute('type', 'text');
			// fp.currentYearElement.setAttribute('autofocus', 'false');
			// fp.currentYearElement.setAttribute('readonly', 'true');
			fp.l10n.rangeSeparator = ' - ';
			fp.calendarContainer.classList.add('cabinet');
			const buttons = document.createElement('div');
			buttons.classList.add('buttons-wrap');
			buttons.innerHTML = fp_buttons;
			const page = cabinetDateRange.data('page');
			buttons.querySelector('.btn-cancel').addEventListener('click', function () {
				// if (page === 'appointments') {
				// 	getArchiveAppointments();
				// }
				// if (page === 'analysis') {
				// 	getDocuments();
				// }
				// fp.clear();
				fp.close();
			});
			buttons.querySelector('.btn-confirm').addEventListener('click', function () {
				// fp.setDate(fp.selectedDates);
				// fp.isSetManually = true;

				if (fp.selectedDates[0] && !fp.selectedDates[1]) {
					fp.selectedDates.push(fp.selectedDates[0]);
					fp.set(fp.selectedDates);
					fp.redraw();
				}

				if (!fp.selectedDates[0] && !fp.selectedDates[1]) {
					const date = new Date(), y = date.getFullYear(), m = date.getMonth();
					fp.selectedDates.push(new Date(y, m, 1));
					fp.selectedDates.push(new Date());
					fp.set(fp.selectedDates);
					fp.redraw();
				}

				if (page === 'appointments') {
					getArchiveAppointments(fp.selectedDates);
				}
				if (page === 'analysis') {
					getDocuments(fp.selectedDates);
				}
				fp.close();
			});
			fp.calendarContainer.appendChild(buttons);
			fp.redraw();
		}
	});
}

function _creatingDateRange(dates) {
	const form_data = new FormData();
	if (dates) {
		if (dates[0] && dates[0] !== undefined) {
			const set_date = `${new Date(dates[0]).getFullYear()}-${new Date(dates[0]).getMonth() + 1}-${new Date(dates[0]).getDate()}`;
			form_data.append('startDate', set_date)
		}
		if (dates[1] && dates[1] !== undefined) {
			const set_date = `${new Date(dates[1]).getFullYear()}-${new Date(dates[1]).getMonth() + 1}-${new Date(dates[1]).getDate()}`;
			form_data.append('endDate', set_date)
		}
	}
	return form_data;
}

document.addEventListener('click', (event) => {
	const routelink = event.target.getAttribute('data-routelink');

	if (routelink) event.preventDefault();

	if (routelink && !is_cabinet_form_sending) {
		event.preventDefault();

		set_active_menu_item_and_breadcrumb(routelink);
		get_page_content(routelink);
	}
});

function set_active_menu_item_and_breadcrumb(routelink) {
	let current_menu_item;
	const menu = document.querySelectorAll('.c-sidebar__menu-item a[data-routelink]');
	menu.forEach((item) => {
		if (routelink === item.getAttribute('data-routelink')) {
			item.classList.add("active");
			current_menu_item = item;
		} else {
			item.classList.remove("active");
		}
	})

	//for mobile menu
	document.querySelector('.c-sidebar-mob-wrap').classList.remove('open');
	document.querySelector('.c-sidebar-mob-wrap').style.display = 'none';

	//for breadcrumbs
	const locale = document.documentElement.lang === 'ru' ? '' : 'ua/';
	if (routelink === `/${locale}cabinet/`) {
		document.querySelector('.breadcrumb-item.page')?.remove();

		const breadcrumb_item_index = document.querySelector('.breadcrumb-item.index');
		const span = document.createElement('span');
		span.innerText = document.querySelector('.c-sidebar__menu').firstElementChild.textContent.trim();//'Особистий кабінет';
		breadcrumb_item_index.innerHTML = '';
		breadcrumb_item_index.appendChild(span);
	} else {
		const breadcrumb_item_index = document.querySelector('.breadcrumb-item.index');
		const a = document.createElement('a');
		a.innerText = document.querySelector('.c-sidebar__menu').firstElementChild.textContent.trim();//'Особистий кабінет';
		a.href = `/${locale}cabinet/`;
		a.dataset.routelink = `/${locale}cabinet/`;
		breadcrumb_item_index.innerHTML = '';
		breadcrumb_item_index.appendChild(a);

		const breadcrumb_item_page = document.querySelector('.breadcrumb-item.page span');
		if (breadcrumb_item_page) {
			breadcrumb_item_page.innerHTML = current_menu_item.innerText;
		} else {
			const breadcrumb = document.querySelector('.cabinet ol.breadcrumb');
			if (breadcrumb) {
				const li = document.createElement('li');
				li.classList.add('breadcrumb-item');
				li.classList.add('page');
				li.innerHTML = `<span>${current_menu_item.innerText}</span>`;
				breadcrumb.appendChild(li);
			}
		}
	}
}

// Handle forward/back buttons
window.addEventListener('popstate', (event) => {
	setTimeout(() => {
		// if (is_cabinet_form_sending) {
		//     // event.preventDefault();
		//     history.go(1);
		// }

		if (event.state?.routelink) {
			set_active_menu_item_and_breadcrumb(event.state?.routelink);
			get_page_content(event.state?.routelink)
		}
	}, 0)
});

function get_page_content(route) {
	const page_content = document.getElementById('js-cabinet-load-page-content');
	if (route) {
		page_content.innerHTML = `<div class="loading-frame">
<svg width="32px" height="24px">
<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
</svg>
</div>`;
		if (route === location.pathname) {
			history.replaceState({'routelink': route}, "", route);
		} else {
			history.pushState({'routelink': route}, "", route);
		}
	} else {
		history.pushState({'routelink': location.pathname}, "", location.pathname);
	}

	setTimeout(() => {
		if (is_cabinet_form_sending) return false;

		const data = new FormData();
		const page = route || CABINET_PATH;
		data.append('page', page);
		// data.append('page', location.pathname);

		cabinetRequest('get_page_content', data).then(
			resp => resp.json()
		).then(response => {
			if (response.success === true) {
				page_content.innerHTML = response.data;

				if(page.includes('cabinet/doctor-shedule')){
					initializeSheduleDoctorSelect();
				}
				return;
			}
			if (response.success === false && response.data.code === 'forbidden') {
				const locale = document.documentElement.lang === 'ru' ? 'ru' : 'ua';
				location.href = `${location.protocol}//${location.host}/${locale}'`;
				return;
			}
			page_content.innerHTML = `Error: ${response.data.code}. ${response.data.message}`;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			initCalendar();
			initInputMask();
			is_cabinet_form_sending = false;
			if (route && route != location.pathname) {
				set_active_menu_item_and_breadcrumb(route);
				history.replaceState({'routelink': route}, "", route);
			}
		})
	}, 0)
}

function initializeSheduleDoctorSelect() {
	new SlimSelect({
		select: document.querySelector('#month-select'),
		placeholder: true,
		showSearch: false,
	});
	document.querySelectorAll('.type-select').forEach(function(selectElement) {
		new SlimSelect({
			select: selectElement,
			placeholder: true,
			showSearch: false,
		});
	});
}

document.addEventListener('visibilitychange', () => {
	const cabinet_need_appointments_reload = window.localStorage.getItem('cabinet_need_appointments_reload');
	const locale = document.documentElement.lang === 'ru' ? '' : 'ua/';

	if (document.visibilityState === 'visible' && cabinet_need_appointments_reload === '1') {
		if (location.pathname === `/${locale}cabinet/appointments/`) {
			getAppointments();
		}
		window.localStorage.setItem('cabinet_need_appointments_reload', '0');
	}
})

document.addEventListener('DOMContentLoaded', function () {
	get_page_content();
})

function getMonthName(month) {
	const monthNames = {
		'1': 'Січень',
		'2': 'Лютий',
		'3': 'Березень',
		'4': 'Квітень',
		'5': 'Травень',
		'6': 'Червень',
		'7': 'Липень',
		'8': 'Серпень',
		'9': 'Вересень',
		'10': 'Жовтень',
		'11': 'Листопад',
		'12': 'Грудень'
	};

	return monthNames[month] || 'Невідомий місяць';
}