jQuery(document).ready(function ($) {
	is_cabinet_logged_in().then(data => {
		if (data) {
			const params = new URLSearchParams(location.search);
			const cancel_speciality_id = parseInt(params.get('cancel_speciality_id'));
			const cancel_api_id = parseInt(params.get('cancel_api_id'));
			const cancel_emp_id = parseInt(params.get('cancel_emp_id'));
			const cancel_appointment_id = parseInt(params.get('cancel_appointment_id'));
			const cancel_appointment_date = String(params.get('cancel_appointment_date'));

			if (cancel_speciality_id && cancel_api_id && cancel_emp_id && cancel_appointment_id) {
				get_specialists(cancel_speciality_id, cancel_api_id, cancel_emp_id, cancel_appointment_id, cancel_appointment_date);
			} else {
				get_specialists();
			}
		} else {
			get_specialists();
		}
	}).catch(e => {
		console.log(e);
	})
});

if ($(window).width() < 992) {
  // jQuery('.schedule-center-right').hide();
}
jQuery('.schedule-center-right').hide();