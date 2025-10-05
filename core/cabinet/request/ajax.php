<?php

if (!defined('ABSPATH')) {
	die('-1');
}

//должно быть на оперциях внутри кабинета
function guard_ajax_query(): void
{
	$cabinet_user = new Cabinet_User();
	if (!$cabinet_user->isLogin()) {
		$cabinet_user->logout();
		wp_send_json_error(['code'    => 'forbidden',
		                    'message' => __('Access Denied!', 'mz')]);
	}
}

add_action('wp_ajax_check_cabinet_user', 'check_cabinet_user');
add_action('wp_ajax_nopriv_check_cabinet_user', 'check_cabinet_user');
function check_cabinet_user(): void
{
	if (!session_id()) {
		session_start();
	}

	$errors = Cabinet_Request_Logic::cabinet_validation_form($_POST, ['PhoneNumber', 'birthDate', 'agreement1',
	                                                                  'agreement2']);

	if ($errors) {
		wp_send_json_error([
			'code'   => 'validation_error',
			'errors' => $errors,
		]);
	}

	$PhoneNumber = str_replace([' ', '(', ')', '-', '+'], '', $_POST['PhoneNumber']);

	$token = Cabinet_Request_Logic::init_token();
	if (is_wp_error($token)) {
		wp_send_json_error([
			'code'    => $token->get_error_code(),
			'message' => $token->get_error_message(),
		]);
	}

	$is_sms_sent = Cabinet_Request_Logic::send_sms_with_confirmation_code($PhoneNumber, $_POST['birthDate']);
	if (is_wp_error($is_sms_sent)) {
		wp_send_json_error([
			'code'    => $is_sms_sent->get_error_code(),
			'message' => $is_sms_sent->get_error_message(),
		]);
	}

//	$_SESSION['cabinet_confirmation_code'] = $code['code'];
	$_SESSION['cabinet_confirmation_code_valid_until'] = time() + 60;
	$_SESSION['temp_cabinet_user_birth_date'] = $_POST['birthDate'];
	$_SESSION['temp_cabinet_user_phone'] = $PhoneNumber;

	wp_send_json_success(['message' => $PhoneNumber]);
}

add_action('wp_ajax_registration_cabinet_user', 'registration_cabinet_user');
add_action('wp_ajax_nopriv_registration_cabinet_user', 'registration_cabinet_user');
function registration_cabinet_user(): void
{
	$errors = Cabinet_Request_Logic::cabinet_validation_form($_POST, [
		'firstName',
		'middleName',
		'lastName',
		'birthDate',
		'PhoneNumber',
		'email',
	]);

	if ($errors) {
		wp_send_json_error([
			'code'   => 'validation_error',
			'errors' => $errors,
		]);
	}

	$subject = __('Реєстрація на сайті medzdrav.com.ua', 'mz');
	$is_sent = Cabinet_Request_Logic::send_patient_data($_POST, $subject);

	if (is_wp_error($is_sent)) {
		wp_send_json_error([
			'code'    => $is_sent->get_error_code(),
			'message' => $is_sent->get_error_message(),
		]);
	}

	wp_send_json_success(['process' => 'registration',
	                      'message' => __('Дякую! Ваші дані успішно надіслано менеджеру для перевірки. Дочекайтесь з Вами зв\'яжуться.', 'mz')]);
}

add_action('wp_ajax_repeat_confirmation_code', 'repeat_confirmation_code');
add_action('wp_ajax_nopriv_repeat_confirmation_code', 'repeat_confirmation_code');
function repeat_confirmation_code()
{
	$process = $_POST['process'];

	if ($process === 'login') {
		if (empty($_SESSION['temp_cabinet_user_phone'])) wp_send_json_error(['message' => __(DEFAULT_AJAX_ERROR_MESSAGE, 'mz')]);
		if (empty($_SESSION['temp_cabinet_user_birth_date'])) wp_send_json_error(['message' => __(DEFAULT_AJAX_ERROR_MESSAGE, 'mz')]);

		$is_sms_sent = Cabinet_Request_Logic::send_sms_with_confirmation_code(
			$_SESSION['temp_cabinet_user_phone'],
			$_SESSION['temp_cabinet_user_birth_date']
		);

		if (is_wp_error($is_sms_sent)) {
			wp_send_json_error([
				'code'    => $is_sms_sent->get_error_code(),
				'message' => $is_sms_sent->get_error_message(),
			]);
		}

		$_SESSION['cabinet_confirmation_code_valid_until'] = time() + 60;
		wp_send_json_success();
	}
	elseif ($process === 'registration') {
		wp_send_json_success();
	}
	elseif ($process === 'cancel_appointment') {
		wp_send_json_success();
	}
	elseif ($process === 'move_appointment') {
		wp_send_json_success();
	}
	wp_send_json_error(['message' => __(DEFAULT_AJAX_ERROR_MESSAGE, 'mz')]);
}

add_action('wp_ajax_check_confirmation_code', 'check_confirmation_code');
add_action('wp_ajax_nopriv_check_confirmation_code', 'check_confirmation_code');
function check_confirmation_code()
{
	if (!session_id()) {
		session_start();
	}

	/*
	 * $_POST
	 *  Array
(
    [code] => Array
        (
            [0] => 2
            [1] => 2
            [2] => 2
            [3] => 2
        )

    [action] => check_confirmation_code
)
	$_SESSION
Array
(
    [cabinet_user] => 111
    [cabinet_token] => eyJhbGciOiJSUzI1NiIsImtpZCI6Ijc2ZGM1YTgzNWFiODIwNjYyNTAx...
    [cabinet_token_expires_in] => 1696996460
    [cabinet_confirmation_code] => 1234
   */

	if (!preg_match("/^\d$/", $_POST['code'][0])
	    || !preg_match("/^\d$/", $_POST['code'][1])
	    || !preg_match("/^\d$/", $_POST['code'][2])
	    || !preg_match("/^\d$/", $_POST['code'][3])
	) {
		wp_send_json_error(['message' => __('Будь ласка, заповніть усі поля', 'mz')]);
	}

	$code = implode($_POST['code']);

	$process = $_POST['process'];//login, registration, cancel_appointment, move_appointment
	//@todo нужно будет передавть тип запроса, откуда была вызвана модалка с таймером и от этого будет зависить действия здесь
	//@todo это может быть:
	/*
	- логин
	- регистрация ???
	- перенос записи
	- отмена записи
	 * */
	//@todo так же нужно будет сделать чтоб для каждого процесса был отдельный код и время валидности под своим именем в $_SESSION

	if ($process === 'login') {
		if ($_SESSION['cabinet_confirmation_code_valid_until'] < time()) {
			wp_send_json_error(['message' => __('Код більше не валідний', 'mz')]);
		}

		$emc = Cabinet_Request_Logic::check_confirmation_code($code);

		if (is_wp_error($emc)) {
			wp_send_json_error([
				'code'    => $emc->get_error_code(),
				'message' => $emc->get_error_message(),
			]);
		}

//		if ($code != $_SESSION['cabinet_confirmation_code']) {
//			wp_send_json_error(['message' => __('Невірно введено код! Залишилося X спроби.', 'mz')]);
//		}

		$cabinet_user = new Cabinet_User();
		$data = Cabinet_Request_Logic::get_patient_info_by_emc($emc);

		if (is_wp_error($data)) {
			wp_send_json_error([
				'code'    => $data->get_error_code(),
				'message' => $data->get_error_message(),
			]);
		}

		$token = Cabinet_Request_Logic::get_session_token();

		if (is_wp_error($token)) {
			wp_send_json_error([
				'code'    => $token->get_error_code(),
				'message' => $token->get_error_message(),
			]);
		}

		unset($_SESSION['cabinet_api_token']);
		unset($_SESSION['cabinet_api_token_expires_in']);

		$cabinet_user->login($data, $token);
		Cabinet_Library::send_login_notification_to_crm($emc);

//		unset($_SESSION['temp_cabinet_user_id']);
//		unset($_SESSION['temp_cabinet_user_phone']);
//		unset($_SESSION['cabinet_confirmation_code']);
		unset($_SESSION['temp_cabinet_user_phone']);
		unset($_SESSION['temp_cabinet_user_birth_date']);
		unset($_SESSION['cabinet_confirmation_code_valid_until']);
		unset($_SESSION['archive_appointments_start_date']);
		unset($_SESSION['archive_appointments_end_date']);
		unset($_SESSION['documents_start_date']);
		unset($_SESSION['documents_end_date']);

		wp_send_json_success(['process' => 'login']);
	}
	elseif ($process === 'registration') {
		wp_send_json_success(['process' => 'registration',
		                      'message' => __('Дякую! Ваші дані успішно надіслано менеджеру для перевірки. Дочекайтесь з Вами зв\'яжуться.', 'mz')]);
	}
	elseif ($process === 'cancel_appointment') {
		wp_send_json_success(['process' => 'cancel_appointment', 'message' => __('Ваш запис успішно видалено!', 'mz')]);
	}
	elseif ($process === 'move_appointment') {
		wp_send_json_success(['process' => 'move_appointment', 'message' => __('Ваш запис успішно змінено!', 'mz')]);
	}
}

add_action('wp_ajax_get_archive_appointments', 'get_archive_appointments');
add_action('wp_ajax_nopriv_get_archive_appointments', 'get_archive_appointments');
function get_archive_appointments()
{
	guard_ajax_query();
	$startDate = $_POST['startDate'] ?: '';
	$endDate = $_POST['endDate'] ?: '';

	$_SESSION['archive_appointments_start_date'] = $startDate ? date('d. m. Y', strtotime($startDate)) : '';
	$_SESSION['archive_appointments_end_date'] = $endDate ? date('d. m. Y', strtotime($endDate)) : '';

	$appointments = Cabinet_Request_Logic::get_appointments($startDate, $endDate);
	if (is_wp_error($appointments)) {
		wp_send_json_error(['code'    => $appointments->get_error_code(),
		                    'message' => $appointments->get_error_message()]);
	}
	$appointments_archive = Cabinet_Request_Logic::get_past_appointments($appointments);

	ob_start();
	get_template_part('core/cabinet/view/parts/appointments-archive-row', null, ['data' => $appointments_archive]);
	$content = ob_get_clean();

	wp_send_json_success($content);
}

add_action('wp_ajax_get_documents', 'get_documents');
add_action('wp_ajax_nopriv_get_documents', 'get_documents');
function get_documents()
{
	guard_ajax_query();
	$startDate = $_POST['startDate'] ?: '';
	$endDate = $_POST['endDate'] ?: '';

	$_SESSION['documents_start_date'] = $startDate ? date('d. m. Y', strtotime($startDate)) : '';
	$_SESSION['documents_end_date'] = $endDate ? date('d. m. Y', strtotime($endDate)) : '';

	$documents = Cabinet_Request_Logic::get_documents($startDate, $endDate);
	if (is_wp_error($documents)) {
		wp_send_json_error(['code'    => $documents->get_error_code(),
		                    'message' => $documents->get_error_message()]);
	}

	ob_start();
	get_template_part('core/cabinet/view/parts/analysis-row', null, ['data' => $documents]);
	$content = ob_get_clean();

	wp_send_json_success($content);
}

add_action('wp_ajax_get_appointments', 'get_appointments');
add_action('wp_ajax_nopriv_get_appointments', 'get_appointments');
function get_appointments()
{
	guard_ajax_query();
	$appointments = Cabinet_Request_Logic::get_appointments();
	if (is_wp_error($appointments)) {
		wp_send_json_error(['code'    => $appointments->get_error_code(),
		                    'message' => $appointments->get_error_message()]);
	}
	$appointments = Cabinet_Request_Logic::get_future_appointments($appointments);

	ob_start();
	get_template_part('core/cabinet/view/parts/appointments-row', null, ['data' => $appointments]);
	$content = ob_get_clean();

	wp_send_json_success($content);
}

add_action('wp_ajax_cancel_appointment', 'cancel_appointment');
add_action('wp_ajax_nopriv_cancel_appointment', 'cancel_appointment');
function cancel_appointment()
{
	guard_ajax_query();
	if (empty($_POST['appointmentId'])) {
		wp_send_json_error(['code'    => 'cancel_appointment',
		                    'message' => __('appointmentId має бути визначено', 'mz')]);
	}

	$result = Cabinet_Request_Logic::cancel_appointment($_POST['appointmentId']);

	if (is_wp_error($result)) {
		wp_send_json_error(['code'    => $result->get_error_code(),
		                    'message' => __($result->get_error_message(), 'mz')]);
	}

	Cabinet_Library::update_doctor_day_schedule($_POST['doctorId'], $_POST['appointmentDate']);

	wp_send_json_success();
	//@todo здесь нужно генерировать в $_SESSION свой проверочный код, время действия кода и какой о код для отмены записи
	//	wp_send_json_success(['message' => '+380951234567']);
}

add_action('wp_ajax_move_appointment', 'move_appointment');
add_action('wp_ajax_nopriv_move_appointment', 'move_appointment');
function move_appointment()
{
	guard_ajax_query();
	if (empty($_POST['appointmentId'])) {
		wp_send_json_error(['code'    => 'move_appointment',
		                    'message' => __('appointmentId має бути визначено', 'mz')]);
	}

	$errors = Cabinet_Request_Logic::cabinet_validation_form($_POST, ['appointmentDate', 'appointmentTime']);

	if ($errors) {
		wp_send_json_error([
			'code'   => 'validation_error',
			'errors' => $errors,
		]);
	}
	//@todo здесь нужно генерировать в $_SESSION свой проверочный код, время действия кода и какой о код для переноса записи
	wp_send_json_success(['message' => '+380951234567']);
}

add_action('wp_ajax_edit_patient_info', 'edit_patient_info');
add_action('wp_ajax_nopriv_edit_patient_info', 'edit_patient_info');
function edit_patient_info()
{
	guard_ajax_query();
	$errors = Cabinet_Request_Logic::cabinet_validation_form($_POST, [
		'firstName',
		'middleName',
		'lastName',
		'gender',
		'birthDate',
		'PhoneNumber',
		'email',
	]);

	if ($errors) {
		wp_send_json_error([
			'code'   => 'validation_error',
			'errors' => $errors,
		]);
	}

	$subject = __('Зміна даних пацієнта на сайті medzdrav.com.ua', 'mz');
	$is_sent = Cabinet_Request_Logic::send_patient_data($_POST, $subject);

	if (is_wp_error($is_sent)) {
		wp_send_json_error([
			'code'    => $is_sent->get_error_code(),
			'message' => $is_sent->get_error_message(),
		]);
	}

	wp_send_json_success(['process' => 'edit_patient_info',
	                      'message' => __('Дякую! Дані успішно надіслано. Очікуйте на зміни.', 'mz')]);
}

add_action('wp_ajax_is_cabinet_logged_in', 'is_cabinet_logged_in');
add_action('wp_ajax_nopriv_is_cabinet_logged_in', 'is_cabinet_logged_in');
function is_cabinet_logged_in()
{
	$user = new Cabinet_User();
	$is_logged_in = $user->isLogin();
	if (!$is_logged_in) wp_send_json_success(0);

	$user_data = $user->get_user_data();
	wp_send_json_success($user_data);
}

add_action('wp_ajax_cabinet_exit', 'cabinet_exit');
add_action('wp_ajax_nopriv_cabinet_exit', 'cabinet_exit');
function cabinet_exit()
{
	Cabinet_Request_Logic::cabinet_exit();
	wp_send_json_success();
}

add_action('wp_ajax_send_document', 'send_document');
add_action('wp_ajax_nopriv_send_document', 'send_document');
function send_document()
{
	guard_ajax_query();
	if (empty($_POST['documentUrl'])) {
		wp_send_json_error(['code'    => 'send_document',
		                    'message' => __('documentUrl має бути визначено', 'mz')]);
	}

	if (empty($_POST['documentName'])) {
		wp_send_json_error(['code'    => 'send_document',
		                    'message' => __('documentUrl має бути визначено', 'mz')]);
	}

	$patient_data = (new Cabinet_User())->get_user_data();

	if (empty($patient_data['Email'])) {
		wp_send_json_error(['code'    => 'send_document',
		                    'message' => __('Помилка! Будь ласка, вкажіть ваш е-mail на сторінці Особиста інформація', 'mz')]);
	}

	if (!filter_var($patient_data['Email'], FILTER_VALIDATE_EMAIL)) {
		wp_send_json_error(['code'    => 'send_document',
		                    'message' => __('Помилка! Будь ласка, перевірте ваш е-mail на сторінці Особиста інформація', 'mz')]);
	}

	$result = Cabinet_Request_Logic::send_document($patient_data['Email'], $_POST['documentUrl'], $_POST['documentName']);

	if (is_wp_error($result)) {
		wp_send_json_error(['code'    => $result->get_error_code(),
		                    'message' => __($result->get_error_message(), 'mz')]);
	}

	if (empty($result)) {
		wp_send_json_error(['code'    => 'send_document',
		                    'message' => __('Помилка! Неможливо завантажити файл', 'mz')]);
	}

	wp_send_json_success(['message' => __('Файл успішно надіслано на') . ' ' . $patient_data['Email']]);
}

add_action('wp_ajax_download_document', 'download_document');
add_action('wp_ajax_nopriv_download_document', 'download_document');
function download_document()
{
	guard_ajax_query();
	if (empty($_POST['documentUrl'])) {
		wp_send_json_error(['code'    => 'download_document',
		                    'message' => __('documentUrl має бути визначено', 'mz')]);
	}

	$file = Cabinet_Request_Logic::get_document_file($_POST['documentUrl']);

	if (is_wp_error($file)) {
		wp_send_json_error(['code'    => $file->get_error_code(),
		                    'message' => __($file->get_error_message(), 'mz')]);
	}

	if (empty($file)) {
		wp_send_json_error(['code'    => 'download_document',
		                    'message' => __('Помилка! Неможливо завантажити файл', 'mz')]);
	}

	header("Content-type: application/pdf");
//	header("Content-disposition: attachment;filename=downloaded.pdf");
	echo $file;
	wp_die();
}

add_action('wp_ajax_open_document', 'open_document');
add_action('wp_ajax_nopriv_open_document', 'open_document');
function open_document()
{
	guard_ajax_query();
	if (empty($_POST['documentUrl'])) {
		wp_send_json_error(['code'    => 'open_document',
		                    'message' => __('documentUrl має бути визначено', 'mz')]);
	}
	if (empty($_POST['documentName'])) {
		wp_send_json_error(['code'    => 'open_document',
		                    'message' => __('documentName має бути визначено', 'mz')]);
	}

	$path = Cabinet_Request_Logic::open_document($_POST['documentName'], $_POST['documentUrl']);

	if (is_wp_error($path)) {
		wp_send_json_error(['code'    => $path->get_error_code(),
		                    'message' => __($path->get_error_message(), 'mz')]);
	}

	if (empty($path)) {
		wp_send_json_error(['code'    => 'open_document',
		                    'message' => __('Помилка! Неможливо завантажити файл', 'mz')]);
	}

	wp_send_json_success($path . '?timestamp=' . microtime(true));
}

add_action('wp_ajax_get_page_content', 'get_page_content');
add_action('wp_ajax_nopriv_get_page_content', 'get_page_content');
function get_page_content()
{
	guard_ajax_query();
	$page = $_POST['page'];
	$page = str_replace(LOCALE . '/', '', trim($page, '/'));

	$page_content = Cabinet_Request_Page_Content::get_page_content($page);

	if (is_wp_error($page_content)) {
		wp_send_json_error(['code'    => $page_content->get_error_code(),
		                    'message' => __($page_content->get_error_message(), 'mz')]);
	}

	wp_send_json_success($page_content);
}

add_action('wp_ajax_send_doctor_schedule', 'sendDoctorSchedule');
add_action('wp_ajax_nopriv_send_doctor_schedule', 'sendDoctorSchedule');
function sendDoctorSchedule()
{
    $patient_info = (new Cabinet_User())->get_user_data();

    $_POST['formData']['common']['emp_id'] = $patient_info['EmpPosId'];
    $schedule_id_in_crm = false;
    $isset_schedule = Cabinet_Library::check_doctor_month_schedule($_POST['formData']);
    if ($isset_schedule['total']){
        $schedule_id_in_crm = isset($isset_schedule['list'][0]['id']) ? $isset_schedule['list'][0]['id'] : false;
    }

    //проверяем наступило ли 20 число предыдущего месяца за какой отправляют график
    $month = $_POST['formData']['common']['month'];
    $year = $_POST['formData']['common']['year'];
    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");
    $date->sub(new DateInterval('P1M'));
    $previousMonth20th = $date->format('Y-m-20');
    $currentDate = new DateTime();
    $isPreviousMonth20thReached = $currentDate >= new DateTime($previousMonth20th);
    if($isPreviousMonth20thReached){
        wp_send_json_error(['code'    => 'forbidden',
            'message' => __('Термін відправки розкладу ' . date('d.m.Y', strtotime($previousMonth20th)) . ' вийшов!', 'mz')]);
    }

    Cabinet_Library::send_doctor_month_schedule($_POST['formData'], $schedule_id_in_crm);

    wp_send_json_success();
}

add_action('wp_ajax_get_doctor_schedule', 'getDoctorSchedule');
add_action('wp_ajax_nopriv_get_doctor_schedule', 'getDoctorSchedule');
function getDoctorSchedule()
{
    $patient_info = (new Cabinet_User())->get_user_data();

    $_POST['emp_id'] = $patient_info['EmpPosId'];

    $get_schedule = Cabinet_Library::get_doctor_month_schedule($_POST['emp_id']);

    if($get_schedule['total']){
        wp_send_json_success($get_schedule['list'][0]);
    } else {
        wp_send_json_error(['code'    => 'error',
            'message' => __('Розклад не знайдено', 'mz')]);
    }
}