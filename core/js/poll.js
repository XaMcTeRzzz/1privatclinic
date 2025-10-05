let is_poll_form_sending = false;

const pollRequest = async (action, data) => {
	is_poll_form_sending = true;
	if (!action) return;
	if (data.length === 0) data = new FormData();
	data.append('action', action);
	// const data = new URLSearchParams(params);
	// const data = params;
	try {
		return fetch('/wp-admin/admin-ajax.php', {
			method: "POST",
			cache: "no-cache",
			credentials: 'same-origin',
			// headers: {
			// 	// "Content-Type": "application/json",
			// 	// 'Content-Type': 'application/x-www-form-urlencoded'
			// 	// 'Content-Type': 'multipart/form-data'
			// },
			body: data
		});
	} catch (e) {
		console.log(e)
	}
}

function getPollDataById() {
	setTimeout(() => {
		if (is_poll_form_sending) return false;

		const data = new FormData();
		data.append('pathname', window.location.pathname);
		const page_content = document.querySelector('.questions-wrap');
		const bread_title = document.querySelector('.breadcrumb-item span');
		const title = document.querySelector('.container-fluid h1')
		const preloader = document.querySelector('.poll-send-interactive-first-load .preloader-poll-send');
		const error = document.querySelector('.poll-send-interactive-first-load .error-msg');
		// error.innerHTML = '';
		// preloader.style.display = 'block';

		pollRequest('get_poll_data_by_id', data).then(
			resp => resp.json()
		).then(response => {

			if (response.success === true) {
				document.querySelector('.poll-send-interactive-first-load').remove();
				page_content.innerHTML = response.data.data;
				bread_title.innerHTML = response.data.title;
				title.innerHTML = response.data.title;
				document.getElementById('js-poll-send-form').style.display = 'block';
				console.log('success');
				return;
			}
			// preloader.style.display = 'none';
			error.innerHTML = response?.data?.message ? response.data.message : 'Server Error';
		}).catch(e => {
			console.log(e);
			error.innerHTML = e;
		}).finally(() => {
			preloader.style.display = 'none';
			is_poll_form_sending = false;
		});
	}, 0)
}

document.addEventListener('DOMContentLoaded', function () {
	$(document).on('click', '#js-poll-send-button', function (e) {
		e.preventDefault();
		if (is_poll_form_sending) return false;

		const form = document.getElementById('js-poll-send-form');
		const data = new FormData(form);
		data.append('pathname', window.location.pathname);
		const preloader = form.querySelector('.preloader-poll-send');
		const error = form.querySelector('.error-msg');
		error.innerHTML = '';
		preloader.style.display = 'block';

		pollRequest('send_poll_data', data).then(
			resp => resp.json()
		).then(response => {

			if (response.success === true) {
				console.log('success');
				document.getElementById('js-poll-send-form').remove();
				document.querySelector('.questions').innerHTML = response.data.message;
				document.querySelector('.questions').scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
				return;
			}

			if (response.success === false && response?.data?.code === 'validation_error') {
				const validator = new PollFormValidator('js-poll-send-form');
				validator.clearErrors();
				validator.showErrors(response.data.errors);
				return;
			}

			error.innerHTML = response.data.message;
		}).catch(e => {
			console.log(e);
		}).finally(() => {
			preloader.style.display = 'none';
			is_poll_form_sending = false;
		});
	})

	getPollDataById();
})


window.pollFormValidatorInputListener = function removeInputListener() {
	this.closest('.question')?.querySelector('.question-error-message')?.remove();
}

class PollFormValidator {
	constructor(form) {
		const inputs = document.getElementById(form).getElementsByTagName('input');

		inputs.forEach(function (input) {
			input.removeEventListener('input', window.pollFormValidatorInputListener);
			input.addEventListener('input', window.pollFormValidatorInputListener);
		});
	}

	showErrors(errors) {
		const err = Object.entries(errors);

		for (const [poll_id, message] of err) {
			const question = document.getElementById(poll_id);
			if (!question) return;
			this.showError(question, message);
		}
		document.getElementById(err[0][0]).scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
	}

	showError(question, message) {
		question.insertAdjacentHTML('beforeend', `<span class="question-error-message">${message}</span>`);
	}

	clearErrors() {
		document.querySelectorAll('.question-error-message').forEach(error => {
			error.remove();
		});
	}
}