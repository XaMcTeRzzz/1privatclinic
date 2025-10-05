<?php

if (!defined('ABSPATH')) {
	die('-1');
}

const ORGANIZATION_ID = 'B86530AD-BFAB-4899-8A0A-2BE5E9AF7852';
const DEFAULT_AJAX_ERROR_MESSAGE = 'Вибачте! Щось пішло не так на сервері!';
const DEFAULT_MAIL_ERROR_MESSAGE = 'Вибачте! Сталася помилка. Лист не відправили.';
const MAX_ITEMS_OF_LIST = 50;
const ITEMS_FOR_ONE_SHOW = 10;

class Cabinet_Request_Logic
{

	public static function generate_confirmation_code(): array
	{
		return [
			'code'        => '1234',
			'valid_until' => time() + 60,
		];
	}

	public static function send_sms_with_confirmation_code($phoneNumber, $birthDate)
	{
		$token = self::get_session_token();

		if (is_wp_error($token)) return $token;

		$token = $token['access_token'];

		$endpoint = API_URL_SERVER . '/Patients/SmsAuthPatientRequest';
		$ch = curl_init();

		$params = ['phoneNumber' => $phoneNumber,
		           'dateOfBirth' => $birthDate];

		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, []);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 || empty($response['Data'])) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response['Data'];
	}

	public static function check_confirmation_code($code)
	{
		$token = self::get_session_token();

		if (is_wp_error($token)) return $token;

		$token = $token['access_token'];

		$endpoint = API_URL_SERVER . '/Patients/SmsAuthPatientResponse';
		$ch = curl_init();

		$params = ['verificationNumber' => $code];

		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, []);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 || $response['Data'] == -1 || empty($response['Data'])) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response['Data'];
	}

	/*
	 * Response Data:
	 *
	 * $data['Data']['Id']
	 * $data['Data']['Email']
	 * $data['Data']['FirstName']
	 * $data['Data']['MiddleName']
	 * $data['Data']['LastName']
	 * $data['Data']['PhoneNumber']
	 * $data['Data']['BirthDate']
	 * $data['Data']['Gender']
	 * $data['Data']['EMC']
	 * $data['Data']['Photo']
	 *
	 * */
	public static function get_patient_by_personal_data($PhoneNumber, $birthDate)
	{
		$token = self::get_token();

		if (is_wp_error($token)) return $token;

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/byPersonal';
		$params = ['phoneNumber' => $PhoneNumber,
		           'birthDate'   => $birthDate];
		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response['Data'];
	}

	/*
		"AppointmentId": 0,
		"EventName": "string",
		"PhysicianName": "string",
		"OrganizationName": "string",
		"Date": "2017-07-26T00:00:00.000Z",
		"Start": "2017-07-26T09:20:11.323Z",
		"End": "2017-07-26T09:30:11.323Z",
		"StatusName": "string",
		"StatusCode": 0
	 * */
	public static function get_appointments($startDate = '', $endDate = '')
	{
		$patient_info = (new Cabinet_User())->get_user_data();
		$patientId = $patient_info['Id'];
		if (empty($patientId)) {
			return new WP_Error(
				'get_appointments',
				__('patientId має бути визначено', 'mz')
			);
		}

		$token = self::get_token();

		if (is_wp_error($token)) return $token;

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/' . $patientId . '/Events';

		$params = [];
		$params['startDate'] = $startDate;
		$params['endDate'] = $endDate;

		if (empty($params['startDate']) || empty($params['endDate'])) {
			$params['startDate'] = date('Y-m-d', strtotime('-1 year'));
			$params['endDate'] = date('Y-m-d', strtotime('+1 year'));
		}

		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response['Data'];
	}

	public static function get_filtering_appointments($appointments, $StatusCode)
	{
		$appointments = array_slice($appointments, 0, MAX_ITEMS_OF_LIST);
		return array_filter($appointments, static function ($appointment) use ($StatusCode) {
//			$utc_timezone = new DateTimeZone('Europe/Kiev');
//			$check_time = date_create($appointment['End'], $utc_timezone) > date_create('now', $utc_timezone);
//			if ($StatusCode == 1) $check_time = !$check_time;

			return $appointment['StatusCode'] == $StatusCode;// && $check_time
		});
	}

	public static function get_future_appointments($appointments)
	{
		return array_slice(array_map(static function ($appointment) {
			if (!empty($appointment['PhysicianName'])) {
				$doctor_data = Cabinet_Library::get_doctor_data_by_name($appointment['PhysicianName']);
				if (!empty($doctor_data)) {
					$appointment = array_merge($appointment, ...$doctor_data);
				}
			}
			return $appointment;
		}, array_filter($appointments, static function ($appointment) {
			return $appointment['StatusCode'] == 0;
		})), 0, MAX_ITEMS_OF_LIST);
	}

	public static function get_past_appointments($appointments)
	{
		return array_slice(array_filter($appointments, static function ($appointment) {
			return $appointment['StatusCode'] != 0;
		}), 0, MAX_ITEMS_OF_LIST);
	}

	public static function get_documents($startDate = '', $endDate = '')
	{
		$patient_info = (new Cabinet_User())->get_user_data();
		$patientId = $patient_info['Id'];
// 		$patientId = $patient_info['Id'] == 896664 ? 917657 : $patient_info['Id'];//$patient_info['Id'];
		if (!$patientId) {
			return new WP_Error(
				'get_documents',
				__('patientId має бути визначено', 'mz')
			);
		}

		$token = self::get_token();
// 		if ($patient_info['Id'] == 896664) {
// 			$token = '';
// 		}

		if (is_wp_error($token)) return $token;

		/*
		 *
			 {
				"Id"  : "1",
				"Name": "Медичні документи"
			},
			{
				"Id"  : "2",
				"Name": "Лабораторні дослідження"
			}
		*/
		$document_categories = [
			[
				'Id'   => 2,
				'Name' => 'Лабораторні дослідження',
			],
		];//self::get_document_categories($patientId);

		if (is_wp_error($document_categories)) return $document_categories;

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/' . $patientId . '/Docs';

		$params = [];
		$params['startDate'] = $startDate;
		$params['endDate'] = $endDate;

		if (empty($params['startDate']) || empty($params['endDate'])) {
			$params['startDate'] = date('Y-m-d', strtotime('-1 year'));
			$params['endDate'] = date("Y-m-d");
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$data = [];
		foreach ($document_categories as $document_category) {
			$params['category'] = $document_category['Id'];

			$url = $endpoint . '?' . http_build_query($params);
			curl_setopt($ch, CURLOPT_URL, $url);

			$response = json_decode(curl_exec($ch), true);

			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
				self::cabinet_exit();
				return new WP_Error(
					'forbidden',
					__('Access Denied!', 'mz')
				);
			}
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
				return new WP_Error(
					curl_getinfo($ch, CURLINFO_HTTP_CODE),
					__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
				);
			}
			$data = array_merge($data, $response['Data']);
		}

		curl_close($ch);
		return array_slice($data, 0, MAX_ITEMS_OF_LIST);
	}

	/*
	 *
	  "Data": [
	    {
	      "Id": "string",
	      "Name": "string"
	    }
	  ]
	 * */
	/*
		 * Array
			(
			    [0] => Array
			        (
			            [Id] => 1
			            [Name] => Медичні документи
			        )

			    [1] => Array
			        (
			            [Id] => 2
			            [Name] => Лабораторні дослідження
			        )

			)
		 * */
	public static function get_document_categories($patientId)
	{
		if (!$patientId) {
			return new WP_Error(
				'get_document_categories',
				__('patientId має бути визначено', 'mz')
			);
		}

		$token = self::get_token();

		if (is_wp_error($token)) return $token;

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/' . $patientId . '/Categories';

		$url = $endpoint;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response['Data'];
	}

	public static function get_patient_info_by_emc($emc = null)
	{
		if ($emc) {
			$token = self::get_session_token();
			if (is_wp_error($token)) return $token;
			$token = $token['access_token'];
		}
		else {
			$token = self::get_token();
		}

		if (is_wp_error($token)) return $token;

		$params = [];
		$patient_info = (new Cabinet_User())->get_user_data();
		$params['emc'] = $emc;
		if (empty($params['emc']) && !empty($patient_info['EMC'])) $params['emc'] = $patient_info['EMC'];

		if (empty($params['emc'])) {
			return new WP_Error(
				'get_patient_info_by_emc',
				__('emc має бути визначено', 'mz')
			);
		}

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/ByEMC';

		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);
		
		unset($response['Data']['Photo']);

		return $response['Data'];
	}

	public static function cancel_appointment($appointmentId)
	{
		$token = self::get_token();

		if (is_wp_error($token)) return $token;

		if (empty($appointmentId)) {
			return new WP_Error(
				'cancel_appointment',
				__('appointmentId має бути визначено', 'mz')
			);
		}

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Appointments/' . $appointmentId . '/Cancel';

		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, []);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 || !empty($response['Errors'])) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return true;
	}

	public static function get_document_file($documentUrl)
	{
		$token = self::get_token();

		if (is_wp_error($token)) return $token;

		$url = pathinfo(base64_decode($documentUrl));
		$documentKey = ltrim($url['extension'], 'pdf?key=');
		$documentName = $url['filename'];

		if (empty($documentKey)) {
			return new WP_Error(
				'get_document_file',
				__('documentKey має бути визначено', 'mz')
			);
		}
		if (empty($documentName)) {
			return new WP_Error(
				'get_document_file',
				__('documentName має бути визначено', 'mz')
			);
		}

		$params = [];
		$params['key'] = $documentKey;
		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Patients/' . ORGANIZATION_ID . '/Docs/' . $documentName . '.pdf';
		$url = $endpoint . '?' . http_build_query($params);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);

		$response = curl_exec($ch);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			self::cabinet_exit();
			return new WP_Error(
				'forbidden',
				__('Access Denied!', 'mz')
			);
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 || !empty($response['Errors'])) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);

		return $response;
	}

	public static function open_document($documentName, $documentUrl)
	{
		$file = self::get_document_file($documentUrl);

		if (is_wp_error($file)) {
			return $file;
		}

		if (empty($file)) {
			return new WP_Error(
				'open_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		$patient_info = (new Cabinet_User())->get_user_data();
		$patientId = $patient_info['Id'];

		if (!$patientId) {
			return new WP_Error(
				'open_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		$temp_folder = 'wp-content/themes/medzdrav/core/cabinet/temp/' . $patientId . '/';

		if (!file_exists(ABSPATH . $temp_folder)) {
			$created = mkdir(ABSPATH . $temp_folder, 0777, true);

			if (!$created) {
				return new WP_Error(
					'open_document',
					__('Не вдалося створити каталог.')
				);
			}
		}

		$path = ABSPATH . $temp_folder . $documentName;

		$is_temp_file_saved = file_put_contents($path, $file);

		if (!$is_temp_file_saved) {
			return new WP_Error(
				'open_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		//		return get_home_url(null, $temp_folder . $documentName);
		return WP_SITEURL . $temp_folder . $documentName;
	}

	public static function send_document($to, $documentUrl, $documentName)
	{
		$subject = __('Лист із сайту medzdrav.com.ua');
		$body = __('Файл з сайту medzdrav.com.ua');
		$site_title = get_bloginfo('name');
		$from_name = empty($site_title) ? 'WordPress' : $site_title;
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = 'From: ' . $from_name . ' <' . get_bloginfo('admin_email') . '>';

		$patient_info = (new Cabinet_User())->get_user_data();
		$patientId = $patient_info['Id'];

		if (!$patientId) {
			return new WP_Error(
				'send_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		$temp_folder = ABSPATH . 'wp-content/themes/medzdrav/core/cabinet/temp/' . $patientId . '/';

		if (!file_exists($temp_folder)) {
			$created = mkdir($temp_folder, 0777, true);

			if (!$created) {
				return new WP_Error(
					'send_document',
					__('Не вдалося створити каталог.')
				);
			}
		}

		$file_name = md5($documentUrl);

		$path = $temp_folder . $file_name;

		$file = self::get_document_file($documentUrl);

		if (is_wp_error($file)) {
			return $file;
		}

		if (!$file) {
			return new WP_Error(
				'send_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		if (!file_put_contents($path, $file)) {
			wp_delete_file($path);
			return new WP_Error(
				'send_document',
				__('Помилка! Неможливо завантажити файл', 'mz')
			);
		}

		$attachments[$documentName] = $path;

		$is_sent = wp_mail($to, $subject, $body, $headers, $attachments);
		wp_delete_file($path);

		if ($is_sent === false) {
			return new WP_Error(
				'wp_mail',
				__('Помилка при надсиланні файлу!', 'mz')
			);
		}

		return true;
	}

	public static function send_patient_data($data, $subject = '')
	{
		$to = get_option('cabinet_manager_email') ?: '';

		if (empty($to)) {
			return new WP_Error(
				'send_patient_data',
				__('Email для адміністрування не встановлено в налаштуваннях', 'mz')
			);
		}

		$body = self::_array_to_html_table($data);
		if (empty($subject)) $subject = __('Лист із сайту medzdrav.com.ua');
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$site_title = get_bloginfo('name');
		$from_name = empty($site_title) ? 'WordPress' : $site_title;
		$headers[] = 'From: ' . $from_name . ' <' . get_bloginfo('admin_email') . '>';

		$is_sent = wp_mail($to, $subject, $body, $headers);

		if ($is_sent === false) {
			return new WP_Error(
				'wp_mail',
				__('Помилка при надсиланні листа!', 'mz')
			);
		}

		return true;
	}

	public static function get_token()
	{
		$user = new Cabinet_User();
		$token = $user->get_token();

		if (empty($token)) {
			return new WP_Error(
				'get_token',
				__('Помилка при отриманні токена', 'mz')
			);
		}

		return $token;
	}

	public static function get_session_token()
	{
		if (!session_id()) {
			session_start();
		}

		$token['access_token'] = $_SESSION['cabinet_api_token'];
		$token['expires_in'] = $_SESSION['cabinet_api_token_expires_in'];

		if (empty($token['access_token']) || time() > $token['expires_in']) {
			return new WP_Error(
				'get_session_token',
				__('Помилка при отриманні токена', 'mz')
			);
		}

		return $token;
	}

	public static function init_token()
	{
		if (!session_id()) {
			session_start();
		}

//		if (!empty($_SESSION['cabinet_api_token']) && $_SESSION['cabinet_api_token_expires_in'] > time()) {
//			return $_SESSION['cabinet_api_token'];
//		}

		$post = [
			'client_id'     => 'api_server_cabinet',
			'client_secret' => 'mapp_cab_d934550_EXPRESS_CAB_sec',
			'scope'         => 'healthcareservices specialities physicians events patients appointments cabinet crm_cabinet simplified sms login account organizations',
			'grant_type'    => 'client_credentials',
		];

		$ch = curl_init(API_URL_AUTHORIZATION . '/connect/token');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		$response = json_decode(curl_exec($ch), true);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return new WP_Error(
				curl_getinfo($ch, CURLINFO_HTTP_CODE),
				__($response['Errors'][0]['Description'] ?: DEFAULT_AJAX_ERROR_MESSAGE, 'mz')
			);
		}

		curl_close($ch);
		if (!empty($response['access_token']) && !empty($response['expires_in'])) {
			$_SESSION['cabinet_api_token'] = $response['access_token'];
			$_SESSION['cabinet_api_token_expires_in'] = time() + $response['expires_in'];
			return true;
		}

		return new WP_Error(
			'init_token',
			__('Помилка при отриманні токена', 'mz')
		);
	}

	public static function cabinet_validation_form($data, $fields): array
	{
		$errors = [];

		foreach ($fields as $field) {
			switch ($field) {
				case 'PhoneNumber':
					$PhoneNumber = str_replace([' ', '(', ')', '-'], "", $data['PhoneNumber']);
					if (empty($PhoneNumber)) {
						$errors[] = ['name' => 'PhoneNumber', 'message' => __('будь ласка, заповніть поле')];
					}
					if (!empty($PhoneNumber) && !preg_match("/^\+380\d{9}$/", $PhoneNumber)) {
						$errors[] = ['name' => 'PhoneNumber', 'message' => __('будь ласка, будьте уважні')];
					}
					break;
				case 'birthDate':
					if (empty($data['birthDate'])) {
						$errors[] = ['name' => 'birthDate', 'message' => __('будь ласка, заповніть поле')];
					}
					break;
				case 'agreement1':
					if (empty($data['agreement1'])) {
						$errors[] = ['name' => 'agreement1', 'message' => ''];
					}
					break;
				case 'agreement2':
					if (empty($data['agreement2'])) {
						$errors[] = ['name' => 'agreement2', 'message' => ''];
					}
					break;
				case 'firstName':
					if (empty($data['firstName'])) {
						$errors[] = ['name' => 'firstName', 'message' => __('будь ласка, заповніть поле')];
					}
					break;
				case 'lastName':
					if (empty($data['lastName'])) {
						$errors[] = ['name' => 'lastName', 'message' => __('будь ласка, заповніть поле')];
					}
					break;
				case 'middleName':
					if (empty($data['middleName'])) {
						$errors[] = ['name' => 'middleName', 'message' => __('будь ласка, заповніть поле')];
					}
					break;
				case 'gender':
					if (empty($data['gender'])) {
						$errors[] = ['name' => 'gender', 'message' => __('будь ласка, заповніть поле')];
					}
					break;
				case 'email':
					if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$errors[] = ['name' => 'email', 'message' => __('будь ласка, будьте уважні')];
					}
					break;
				case 'appointmentDate':
					if (empty($data['appointmentDate'])) {
						$errors[] = ['name' => 'appointmentDate', 'message' => __('будь ласка, заповніть поле')];
					}
//				if (!empty($data['appointmentDate']) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $data['appointmentDate'])) {
//					$errors[] = ['name' => 'appointmentDate', 'message' => __('будь ласка, будьте уважні')];
//				}
					break;
				case 'appointmentTime':
					if (empty($data['appointmentTime'])) {
						$errors[] = ['name' => 'appointmentTime', 'message' => __('будь ласка, заповніть поле')];
					}
//				if (!empty($data['appointmentTime']) && !preg_match("/^\d{2}:\d{2}$/", $data['appointmentTime'])) {
//					$errors[] = ['name' => 'appointmentTime', 'message' => __('будь ласка, будьте уважні')];
//				}
					break;
			}
		}

		return $errors;
	}

	public static function cabinet_exit()
	{
		$cabinet_user = new Cabinet_User();
		$cabinet_user->logout();
	}

	private static function _array_to_html_table($data)
	{
		$rows = [];

		$fields = [
			'firstName'   => __('Ім\'я'),
			'FirstName'   => __('Ім\'я'),
			'lastName'    => __('Прізвище'),
			'LastName'    => __('Прізвище'),
			'middleName'  => __('По-батькові'),
			'MiddleName'  => __('По-батькові'),
			'gender'      => __('Стать'),
			'Gender'      => __('Стать'),
			'birthDate'   => __('Дата народження'),
			'BirthDate'   => __('Дата народження'),
			'PhoneNumber' => __('Телефон'),
			'email'       => 'E-mail',
			'Email'       => 'E-mail',
			'EMC'         => 'EMC',
			'Запис'       => 'Запис',
			'запис'       => 'Запис',
		];

		foreach ($data as $key => $row) {
			if ($key == 'action' || empty($fields[$key])) continue;
			if (($key == 'birthDate' || $key == 'BirthDate') && !empty($fields[$key])) {
				$row = str_replace('T00:00:00', '', $row);
			}

			$td = '<td>' . $fields[$key] . '</td><td>' . $row . '</td>';
			$rows[] = '<tr>' . $td . '</tr>';
		}
		return '<table>' . implode('', $rows) . '</table>';
	}
}