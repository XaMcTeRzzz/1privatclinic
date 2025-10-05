document.addEventListener('DOMContentLoaded', function () {

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-cabinet-login-button') {
			event.preventDefault();

			if (is_cabinet_form_sending) return false;

			const form = document.getElementById('js-cabinet-login-form');
			const data = new FormData(form);
			const preloader = form.querySelector('.preloader-modal-send');
			const error = form.querySelector('.error-msg');
			error.innerHTML = '';
			preloader.style.display = 'block';
			const validator = new CabinetFormValidator('js-cabinet-login-form');
			validator.clearErrors();

			cabinetRequest('check_cabinet_user', data).then(
				resp => resp.json()
			).then(response => {
				if (response.success === true) {
					showCodeConfirmationModal('login', response.data.message);
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
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-cabinet-registration-button') {
			event.preventDefault();

			if (is_cabinet_form_sending) return false;

			const form = document.getElementById('js-cabinet-registration-form');
			const data = new FormData(form);
			const preloader = form.querySelector('.preloader-modal-send');
			const error = form.querySelector('.error-msg');
			error.innerHTML = '';
			preloader.style.display = 'block';
			const validator = new CabinetFormValidator('js-cabinet-registration-form');
			validator.clearErrors();

			cabinetRequest('registration_cabinet_user', data).then(
				resp => resp.json()
			).then(response => {
				if (response.success === true) {
					showSuccessfulModal(response.data.process, response.data.message);
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
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-cabinet-confirmation-code-button') {
			event.preventDefault();

			if (is_cabinet_form_sending) return false;

			const form = document.getElementById('js-cabinet-confirmation-code-form');
			const data = new FormData(form);
			const preloader = form.querySelector('.preloader-modal-send');
			const error = form.querySelector('.error-msg');
			error.innerHTML = '';
			preloader.style.display = 'block';

			cabinetRequest('check_confirmation_code', data).then(
				resp => resp.json()
			).then(response => {
				if (response.success === true) {
					//@todo нужна разная логика в зависимости от process и нужно возвращать этот process
					if (response.data.process === 'login') {
						const locale = document.documentElement.lang === 'ru' ? 'ru' : 'ua';
						location.href = `${location.protocol}//${location.host}/${locale}/cabinet/analysis/'`;
					} else if (response.data.process === 'registration'
						|| response.data.process === 'cancel_appointment'
						|| response.data.process === 'move_appointment') {
						showSuccessfulModal(response.data.process, response.data.message);
					}
					return;
				}
				error.innerHTML = response.data.message;
			}).catch(e => {
				console.log(e);
			}).finally(() => {
				preloader.style.display = 'none';
				is_cabinet_form_sending = false;
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-cabinet-confirmation-code-repeat') {
			event.preventDefault();

			if (is_cabinet_form_sending) return false;

			const form = document.getElementById('js-cabinet-confirmation-code-form');
			const preloader = form.querySelector('.preloader-modal-send');
			const error = form.querySelector('.error-msg');
			const data = new FormData();
			data.append('process', form.process.value)

			form.querySelector('#js-cabinet-confirmation-code-timer').innerHTML = '';
			error.innerHTML = '';
			preloader.style.display = 'block';
			clearFormInModal('js-cabinet-confirmation-code-modal');

			const timer_id = window.sessionStorage.getItem('cabinet_confirmation_code_timer_id');
			clearInterval(timer_id);

			cabinetRequest('repeat_confirmation_code', data).then(
				resp => resp.json()
			).then(response => {
				if (response.success === true) {
					startTimer();
					return;
				}
				error.innerHTML = response.data.message;
			}).catch(e => {
				console.log(e);
			}).finally(() => {
				preloader.style.display = 'none';
				is_cabinet_form_sending = false;
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-open-cabinet-registration-modal') {
			event.preventDefault();
			$.fancybox.close({
				src: '#js-cabinet-login-modal'
			})
			$.fancybox.open({
				src: '#js-cabinet-registration-modal',
				type: 'inline',
				opts: {
					smallBtn: false,
					toolbar: false,
					touch: false,
					keyboard: false
				}
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-open-cabinet-login-modal') {
			event.preventDefault();
			$.fancybox.close({
				src: '#js-cabinet-registration-modal'
			})
			$.fancybox.open({
				src: '#js-cabinet-login-modal',
				type: 'inline',
				opts: {
					smallBtn: false,
					toolbar: false,
					touch: false,
					keyboard: false
				}
			})
		}
	})

	document.addEventListener('click', function (event) {
		if (event.target.id === 'js-open-cabinet-login-modal-header') {
			event.preventDefault();
			clearFormInModal('js-cabinet-login-modal');
			clearFormInModal('js-cabinet-registration-modal');
			new CabinetFormValidator('js-cabinet-registration-form').clearErrors();
			new CabinetFormValidator('js-cabinet-login-form').clearErrors();
			$.fancybox.open({
				src: '#js-cabinet-login-modal',
				type: 'inline',
				opts: {
					smallBtn: false,
					toolbar: false,
					touch: false,
					keyboard: false,
					afterShow(instance, slide) {
						document.getElementById('js-cabinet-login-modal').querySelector('[name=PhoneNumber]').focus();
					}
				}
			})
		}
	})

	//sms code confirmation start
	const form = document.querySelector('#js-cabinet-confirmation-code-form')
	const inputs = form.querySelectorAll('input')
	const KEYBOARDS = {
		backspace: 8,
		arrowLeft: 37,
		arrowRight: 39,
	}

	form.addEventListener('input', handleInput)

	inputs.forEach(input => {
		input.addEventListener('focus', e => {
			e.preventDefault();
			setTimeout(() => {
				e.target.select()
			}, 0)
		})

		input.addEventListener('keydown', e => {
			switch (e.keyCode) {
				case KEYBOARDS.backspace:
					handleBackspace(e)
					break
				case KEYBOARDS.arrowLeft:
					handleArrowLeft(e)
					break
				case KEYBOARDS.arrowRight:
					handleArrowRight(e)
					break
				default:
					handleKeyCode(e)
			}
		})
	})
	//sms code confirmation end
})

function showCodeConfirmationModal(process, message) {
	clearFormInModal('js-cabinet-confirmation-code-modal');

	const modal = document.getElementById('js-cabinet-confirmation-code-modal');
	const form = document.getElementById('js-cabinet-confirmation-code-form');
	modal.querySelector('.js-info-msg b').innerHTML = ` ${message}`;
	form.querySelector('#js-cabinet-confirmation-code-timer').innerHTML = '';
	form.process.value = process;

	startTimer();

	$.fancybox.close();
	$.fancybox.open({
		src: '#js-cabinet-confirmation-code-modal',
		type: 'inline',
		opts: {
			smallBtn: false,
			toolbar: false,
			touch: false,
			keyboard: false,
			afterClose: function (instance, current) {
				const timer_id = window.sessionStorage.getItem('cabinet_confirmation_code_timer_id');
				clearInterval(timer_id);
			}
		}
	});
}

function startTimer() {
	const elem = document.getElementById('js-cabinet-confirmation-code-form').querySelector('#js-cabinet-confirmation-code-timer');
	const countdown_time = (new Date().getTime()) + 60000;

	const t = setInterval(function () {

		const now = new Date().getTime();
		const distance = countdown_time - now;

		let seconds = Math.floor((distance % (1000 * 60)) / 1000);
		if (seconds < 10) seconds = `0${seconds}`;
		elem.innerHTML = `00:${seconds}`;

		if (distance < 0) {
			clearInterval(t);
			elem.innerHTML = "00:00";
		}
	}, 1000);

	window.sessionStorage.setItem('cabinet_confirmation_code_timer_id', JSON.stringify(t));
}

function showSuccessfulModal(process, message) {

	const modal = document.getElementById('js-cabinet-successful-modal');
	const msg = modal.querySelector('.c-modal__body-info span');
	msg.innerHTML = message;

	$.fancybox.close();
	//@todo после переноса или отмены записи нужно сделать обновление на странице
	$.fancybox.open({
		src: '#js-cabinet-successful-modal',
		type: 'inline',
		opts: {
			smallBtn: true,
			toolbar: false,
			touch: false,
			keyboard: false,
			afterClose: function (instance, current) {
				if (process === 'move_appointment' || process === 'cancel_appointment') {
					updateAppointments();
				}
			}
		}
	});
}

function updateAppointments() {
	try {
		getAppointments();
	} catch (e) {
		console.log(e);
	}
}

function clearFormInModal(modal_id) {
	const modal = document.getElementById(modal_id);
	const form = modal.querySelector('form');
	modal.querySelector('.error-msg').innerHTML = '';
	form.reset();
}

function handleInput(e) {
	e.preventDefault();
	const input = e.target
	const nextInput = input.nextElementSibling
	if (nextInput && input.value) {
		nextInput.focus()
		if (nextInput.value) {
			nextInput.select()
		}
	}
}

function handleBackspace(e) {
	e.preventDefault();
	const input = e.target
	if (input.value) {
		input.value = ''
		return
	}
	if (input.previousElementSibling) input.previousElementSibling.focus()
}

function handleArrowLeft(e) {
	e.preventDefault();
	const previousInput = e.target.previousElementSibling
	if (!previousInput) return
	previousInput.focus()
}

function handleArrowRight(e) {
	e.preventDefault();
	const nextInput = e.target.nextElementSibling
	if (!nextInput) return
	nextInput.focus()
}

function handleKeyCode(e) {
	if (
		(e.keyCode < 48 && e.keyCode !== 13)
		|| (e.keyCode > 57 && e.keyCode < 96)
		|| e.keyCode > 105
	) {
		e.preventDefault();
		return false;
	}
}