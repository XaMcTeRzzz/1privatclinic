let is_cabinet_form_sending = false;

const cabinetRequest = async (action, data) => {
	is_cabinet_form_sending = true;
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

window.cabinetFormValidatorInputListener = function removeInputListener() {
	this.classList.remove('c-error-field');
	this.parentNode.querySelectorAll('.c-error-label').forEach(label => {
		label.remove();
	});
}

class CabinetFormValidator {
	constructor(form) {
		this.form = form

		const inputs = document.getElementById(this.form).getElementsByTagName('input');

		inputs.forEach(function (input) {
			input.removeEventListener('input', window.cabinetFormValidatorInputListener);
			input.addEventListener('input', window.cabinetFormValidatorInputListener);
		});
	}

	showErrors(fields) {
		fields.forEach(field => {
			const input = document.getElementById(this.form).querySelector(`[name="${field.name}"]`);
			if (!input) return;
			this.showError(input, field.message);
		})
	}

	showError(input, message) {
		input.classList.add('c-error-field');
		if (message) {
			input.insertAdjacentHTML('afterend', `<span class="c-error-label">${message}</span>`);
		}
	}

	clearErrors() {
		const inputs = document.getElementById(this.form).getElementsByTagName('input');
		inputs.forEach(input => {
			this.clearError(input);
		})
	}

	clearError(input) {
		input.classList.remove('c-error-field');
		// input.parentNode.querySelector('.c-error-label')?.remove();
		input.parentNode.querySelectorAll('.c-error-label').forEach(label => {
			label.remove();
		});
	}
}

function get_cookie_value(name) {
	return document.cookie
		.split("; ")
		.find((row) => row.startsWith(name))// + "="
		?.split("=")[1];
}

/*
* Change cabinet header and mobile link because of wp cache
* */
if (!location.pathname.includes('cabinet')) {
	document.addEventListener('DOMContentLoaded', function () {

		const link = document.querySelector('.c-header-link__wrap a.c-header-link__link');
		const icon = document.querySelector('.c-header-link__wrap svg path');
		const link_mobile = document.getElementsByClassName('c-header-link__mob-wrap');
		const icon_mobile = document.getElementsByClassName('c-header-link__mob-wrap');// svg path
		const locale = document.documentElement.lang === 'ru' ? 'ru' : 'ua';

		if (!link || !link_mobile) return;

		is_cabinet_logged_in().then(data => {
			if (!data) {
				link.id = 'js-open-cabinet-login-modal-header';
				link.href = 'javascript:;';
				link_mobile.forEach(function (link) {
					if (!link) return;
					link.getElementsByTagName('a')[0].href = 'javascript:document.getElementById(\'js-open-cabinet-login-modal-header\').click();';
				})
				if (icon) icon.style.fill = '#95c53d';//change to button #707E98
				icon_mobile.forEach(function (icon) {
					if (!icon) return;

					const svg = icon.getElementsByTagName('svg')[0];
					if (!svg) return;

					const paths = svg.getElementsByTagName('path');

					paths.forEach(function (path) {
						if (!path) return;
						path.style.fill = '#707E98';
					})
				})
			} else {
				link.id = '';
				link.href = `/${locale}/cabinet/`;
				link_mobile.forEach(function (link) {
					if (!link) return;
					link.getElementsByTagName('a')[0].href = `/${locale}/cabinet/`;
				})
				if (icon) icon.style.fill = '#95c53d';
				icon_mobile.forEach(function (icon) {
					if (!icon) return;

					const svg = icon.getElementsByTagName('svg')[0];
					if (!svg) return;

					const paths = svg.getElementsByTagName('path');

					paths.forEach(function (path) {
						if (!path) return;
						path.style.fill = '#95c53d';
					})
				})
			}
		}).catch(e => {
			console.log(e);
		})
	})
}

function is_cabinet_logged_in() {
	return cabinetRequest('is_cabinet_logged_in', []).then(
		resp => resp.json()
	).then(response => {
		if (response.success === false) {
			return false;
		}
		return response.data;
	}).catch(e => {
		console.log(e);
	}).finally(() => {
		is_cabinet_form_sending = false;
	})
}
