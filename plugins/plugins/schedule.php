<?php
/*
Plugin Name: schedule
Version: 1.0.0
*/
set_time_limit(0);

/*
API_URL_AUTHORIZATION
API_URL_SERVER
В wp-config.php
*/

add_action('wp', 'token_activation');

function token_activation()
{
	if (!wp_next_scheduled('update_token_hook_1')) {
		wp_schedule_event(time(), 'interval_11_h', 'update_token_hook_1');
	}
}

add_action('update_token_hook_1', 'getUpdateToken');

function getUpdateToken()
{
	global $wpdb;
	$table = $wpdb->prefix . 'api_data_cache_token';
	date_default_timezone_set('Europe/Kiev');

	$post = [
		'client_id'     => 'api_server_access',//api_server_access
		'client_secret' => 'mapp_d87_EXPRESS_PUBLIC_sec',//mapp_d87_EXPRESS_PUBLIC_sec
		'scope'         => 'healthcareservices specialities physicians events appointments simplified login account organizations',
		'grant_type'    => 'client_credentials'
	];

//  $ch = curl_init('https://identity.mymedcabinet.com.ua/connect/token');
	$ch = curl_init(API_URL_AUTHORIZATION.'/connect/token');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	$response = json_decode(curl_exec($ch), true);

	curl_close($ch);

	if (!empty($response['access_token']) && !empty($response['expires_in']) && !empty($response['token_type'])) {
		$wpdb->query("TRUNCATE `$table`");

		if (false === $wpdb->insert($table, array(
				'access_token' => $response['access_token'],
				'expires_in'   => $response['expires_in'],
				'token_type'   => $response['token_type'],
				'timestamp'    => date("Y-m-d H:i:s")
			))) {
			return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
		}
	}

}

function getToken()
{
	global $wpdb;
	$table = $wpdb->prefix . 'api_data_cache_token';

	$results = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table`"
	));

	//подстраховка чтоб обновить токен если вдруг он не работает раньше чем по крону, вещь нужная но добавляет знасительно время при запросах. надо или нет?
	$organization    = getOrganizations();
	$organization_id = getOrganizationId();

	$ch  = curl_init();
//  $endpoint = 'https://api.mymedcabinet.com.ua/Specialities';
	$endpoint = API_URL_SERVER.'/Specialities';
	$params   = array('healthcareServiceId' => $organization_id);
	$url      = $endpoint . '?' . http_build_query($params);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization: Bearer " . $results[0]->access_token,
		"Organization: " . $organization
	));

	//curl_exec($ch) == false //выдает 404 если нет такого юзера в базе
//	if (curl_exec($ch) == false && curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
	if (curl_exec($ch) == false) {

		getUpdateToken();

		$results = $wpdb->get_results($wpdb->prepare(
			"
		SELECT * FROM `$table`"
		));
		//{"success":false,"data":"The requested URL returned error: 401 Unauthorized"}
		//wp_send_json_error(curl_error($ch));
	}

	curl_close($ch);


	return $results[0]->access_token;
}

function getOrganizations()
{
	global $wpdb;
	$table   = $wpdb->prefix . 'api_data_cache_organization';
	$results = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table`"
	));

	return $results[0]->organization_id;
}

function getOrganizationId()
{
	global $wpdb;
	$table   = $wpdb->prefix . 'api_data_cache_healthcare_services';
	$results = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table`"
	));

	return $results[0]->api_id;
}


add_action('wp', 'update_specialists_activation');
function update_specialists_activation()
{
	if (!wp_next_scheduled('update_specialists_hook_1')) {
		wp_schedule_event(time(), 'daily', 'update_specialists_hook_1');
	}
}

add_action('update_specialists_hook_1', 'getUpdateSpecialists');
function getUpdateSpecialists()
{
	global $wpdb;
	$table = $wpdb->prefix . 'api_data_cache_specialities';

	$token           = getToken();
	$organization    = getOrganizations();
	$organization_id = getOrganizationId();

	$ch       = curl_init();
//  $endpoint = 'https://api.mymedcabinet.com.ua/Specialities';
	$endpoint = API_URL_SERVER.'/Specialities';
	$params   = array('healthcareServiceId' => $organization_id);
	$url      = $endpoint . '?' . http_build_query($params);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization: Bearer " . $token,
		"Organization: " . $organization
	));
	$response = json_decode(curl_exec($ch), true);
	curl_close($ch);

	if (count($response['Data']) > 0) {
		$wpdb->query("TRUNCATE `$table`");
	}

	foreach ($response['Data'] as $key => $item) {
		if (false === $wpdb->insert($table, array(
				'healthcareServiceId' => $organization_id,
				'api_id'              => $item['Id'],
				'Name'                => $item['Name']
			))) {
			//return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
		}
	}
}

add_action('wp_ajax_get_specialists', 'getSpecialists');
add_action('wp_ajax_nopriv_get_specialists', 'getSpecialists');
function getSpecialists()
{
	global $wpdb;
	$table = $wpdb->prefix . 'api_data_cache_specialities';

	wp_send_json_success(
		$wpdb->get_results($wpdb->prepare(
			"
		SELECT * FROM `$table`"
		)));
}


add_action('wp', 'update_doctors_activation');
function update_doctors_activation()
{
	if (!wp_next_scheduled('update_doctors_hook_1')) {
		wp_schedule_event(time() + 1200, 'daily', 'update_doctors_hook_1');
	}
}

add_action('update_doctors_hook_1', 'getUpdateDoctors');
function getUpdateDoctors()
{
	global $wpdb;
	$table_s             = $wpdb->prefix . 'api_data_cache_specialities';
	$table_d             = $wpdb->prefix . 'api_data_cache_doctors';
	$healthcareServiceId = getOrganizationId();
	$token               = getToken();
	$organization        = getOrganizations();
    $organization_id     = getOrganizationId();

	$specialitys = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table_s` WHERE `healthcareServiceId` = '" . $healthcareServiceId . "'"
	));

	$claen_table = true;
	foreach ($specialitys as $speciality) {
		$ch       = curl_init();
//    $endpoint = 'https://api.mymedcabinet.com.ua/Physicians';
		$endpoint = API_URL_SERVER.'/Physicians';
		$params   = array('specialityId' => $speciality->api_id,
                            'healthcareServiceId' => $organization_id);
		$url      = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $token,
			"Organization: " . $organization
		));
		$response = json_decode(curl_exec($ch), true);
		curl_close($ch);

		if (count($response['Data']) > 0 && $claen_table) {
			$wpdb->query("TRUNCATE `$table_d`");
			$claen_table = false;
		}

		if (!$claen_table) {
			foreach ($response['Data'] as $key => $item) {

				if (false === $wpdb->insert($table_d, array(
						'speciality_id' => $speciality->api_id,
						'api_id'        => $item['Id'],
						'EmpId'         => $item['EmpId'],
						'Name'          => $item['Name'],
						'Speciality'    => $item['Speciality'],
						'Category'      => $item['Category'],
						'SexName'       => $item['SexName'],
						'Photo'         => ($item['Photo']) ? $item['Photo'] : '',
						'IsFavorite'    => $item['IsFavorite'],
						'OrgName'       => ($item['OrgName']) ? $item['OrgName'] : '',
						'JourName'      => ($item['JourName']) ? $item['JourName'] : ''
					))) {
					return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
				}

			}
		}

	}
}


//echo get_the_permalink(1124);
//echo get_the_post_thumbnail_url(69);
//api_doctor_id seo3_text_title_ua
//nyksm_postmeta
//get_doctors
add_action('wp_ajax_get_doctors', 'getDoctors');
add_action('wp_ajax_nopriv_get_doctors', 'getDoctors');
function getDoctors()
{
	global $wpdb;
	$speciality_id = $_POST['speciality_id'];
	$table_d       = $wpdb->prefix . 'api_data_cache_doctors';
	$table_pm      = $wpdb->prefix . 'postmeta';
	$table_p       = $wpdb->prefix . 'posts';


	//запрос для привязки врачей с апи и с сайта. для того что вывести фото и ссылку
	wp_send_json_success(
		$wpdb->get_results($wpdb->prepare(
			"
        SELECT `$table_d`.`id`,`$table_d`.`speciality_id`,`$table_d`.`api_id`,`$table_d`.`EmpId`,`$table_d`.`Name`,`$table_d`.`Speciality`,`$table_d`.`Category`,`$table_d`.`SexName`,`$table_d`.`Photo`,`$table_d`.`IsFavorite`,`$table_d`.`OrgName`,`$table_d`.`JourName`, `$table_pm`.`post_id` as pid,
        (SELECT `$table_p`.`post_name` FROM `$table_p` WHERE `$table_p`.`ID` = pid) as link,
        (SELECT `$table_p`.`guid` FROM `$table_p` WHERE `$table_p`.`ID` = (SELECT  `$table_pm`.`meta_value` FROM `$table_pm` WHERE `$table_pm`.`post_id` = pid AND `$table_pm`.`meta_key` LIKE '_thumbnail_id')) as img
        FROM `$table_d`
        LEFT JOIN `$table_pm`
        ON `$table_pm`.`meta_value` = `$table_d`.`api_id` AND `$table_pm`.`meta_key` LIKE 'api_doctor_id'
        WHERE `$table_d`.`speciality_id` LIKE '" . $speciality_id . "'"
		)));

//  wp_send_json_success(
//    $wpdb->get_results($wpdb->prepare(
//      "
//		SELECT * FROM `$table_d` WHERE `speciality_id` LIKE '" . $speciality_id . "'"
//    )));
}

//get_schedule
add_action('wp_ajax_get_schedule', 'getSchedule');
add_action('wp_ajax_nopriv_get_schedule', 'getSchedule');
function getSchedule()
{
//    getUpdateToken();
//  wp_send_json_success(getEvents());
//  getEvents();
//  wp_send_json_success(getDateSlots());
//  wp_send_json_success(getTimeSlots());//сразу для месяца получаем чтоб построить расписание
//  print_r(getDateSlots());
//  print_r(getTimeSlots());
//  getUpdateLitleSchedule();
//  getUpdateSpecialists();
//  getUpdateDoctors();
//  getUpdateTimeSlots();
//   getUpdateDateSlots();
// getUpdateLitleSchedule();
	$date_slots = getDateSlots();
//  $date_slots = getDateSlotsAPI();
	$time_slots = getTimeSlots();
//  $time_slots = getTimeSlotsAPI($date_slots);

	$arr_schedule = array();

	foreach ($date_slots as $key => $date_slot) {
		$arr_schedule[$date_slot->date]['enabled'] = $date_slot->enabled;

		foreach ($time_slots as $key_ => $time_slot) {
			if ($date_slot->date == $time_slot->date && $date_slot->enabled == 1) {
				$arr_schedule[$date_slot->date]['time'][$key_]['StartTime']     = $time_slot->StartTime;
				$arr_schedule[$date_slot->date]['time'][$key_]['FinalTime']     = $time_slot->FinalTime;
				$arr_schedule[$date_slot->date]['time'][$key_]['eventDuration'] = $time_slot->eventDuration;
				$arr_schedule[$date_slot->date]['time'][$key_]['Reserved']      = $time_slot->Reserved;

				if ($time_slot->StartTime < $arr_schedule[$date_slot->date]['min_time'] || !isset($arr_schedule[$date_slot->date]['min_time'])) {
					$arr_schedule[$date_slot->date]['min_time'] = $time_slot->StartTime;
				}
				if ($time_slot->FinalTime > $arr_schedule[$date_slot->date]['max_time'] || !isset($arr_schedule[$date_slot->date]['max_time'])) {
					$arr_schedule[$date_slot->date]['max_time'] = $time_slot->FinalTime;
				}

				$arr_schedule[$date_slot->date]['all_slot'] = (!isset($arr_schedule[$date_slot->date]['all_slot'])) ? 1 : ++$arr_schedule[$date_slot->date]['all_slot'];

				if ($time_slot->Reserved == 1) {
					$arr_schedule[$date_slot->date]['reserve_slot'] = (!isset($arr_schedule[$date_slot->date]['reserve_slot'])) ? 1 : ++$arr_schedule[$date_slot->date]['reserve_slot'];
				}

			}
		}
		$arr_schedule[$date_slot->date]['free_slot'] = $arr_schedule[$date_slot->date]['all_slot'] - $arr_schedule[$date_slot->date]['reserve_slot'];
	}


	wp_send_json_success($arr_schedule);
}


add_action('wp', 'update_events_activation');
function update_events_activation()
{
	if (!wp_next_scheduled('update_events_hook_1')) {
		wp_schedule_event(time() + 1800, 'daily', 'update_events_hook_1');
	}
}

add_action('update_events_hook_1', 'getUpdateEvents');
function getUpdateEvents()
{
	global $wpdb;
	$table_e = $wpdb->prefix . 'api_data_cache_events';
	$table_d = $wpdb->prefix . 'api_data_cache_doctors';

	$token        = getToken();
	$organization = getOrganizations();

	$doctors = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table_d`"
	));

	$claen_table = true;
	foreach ($doctors as $doctor) {
		$ch       = curl_init();
//    $endpoint = 'https://api.mymedcabinet.com.ua/Events';
		$endpoint = API_URL_SERVER.'/Events';
		$params   = array('physicianId'         => $doctor->api_id,
		                  'physicianEmployeeId' => $doctor->EmpId);
		$url      = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $token,
			"Organization: " . $organization
		));
		$response = json_decode(curl_exec($ch), true);
		curl_close($ch);

		if (count($response['Data']) > 0 && $claen_table) {
			$wpdb->query("TRUNCATE `$table_e`");
			$claen_table = false;
		}

		if (!$claen_table) {
			foreach ($response['Data'] as $key => $item) {

				if (false === $wpdb->insert($table_e, array(
						'doctor_id'     => $doctor->api_id,
						'doctor_emp_id' => $doctor->EmpId,
						'api_id'        => $item['Id'],
						'Name'          => $item['Name'],
						'Duration'      => $item['Duration']
					))) {
					return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
				}
			}
		}
	}
}

function getEvents()
{
	global $wpdb;
	$doctor_id     = $_POST['PhysicianId'];
	$doctor_emp_id = $_POST['EmpId'];
	$table         = $wpdb->prefix . 'api_data_cache_events';

	return $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table` WHERE `doctor_id` = '" . $doctor_id . "' AND `doctor_emp_id` = '" . $doctor_emp_id . "'"
	));
}


add_action('wp', 'date_slot_activation');
function date_slot_activation()
{
	if (!wp_next_scheduled('update_date_slots_hook_1')) {
		wp_schedule_event(time() + 1200, 'interval_11_h', 'update_date_slots_hook_1');
	}
}

add_action('update_date_slots_hook_1', 'getUpdateDateSlots');

function getUpdateDateSlots()
{
	global $wpdb;
	$table_da = $wpdb->prefix . 'api_data_cache_days';
	$table_d  = $wpdb->prefix . 'api_data_cache_doctors';
	date_default_timezone_set('Europe/Kiev');

	$token        = getToken();
	$organization = getOrganizations();

	$doctors     = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table_d`"
	));
	$claen_table = true;
	$sql         = '';
	foreach ($doctors as $doctor) {
		if($doctor->api_id == 472){
			continue;
		}
		$ch       = curl_init();
//    $endpoint = 'https://api.mymedcabinet.com.ua/Physicians/' . $doctor->api_id . '/DaysSchedule';
		$endpoint = API_URL_SERVER.'/Physicians/' . $doctor->api_id . '/DaysSchedule';
//    'startDate' => (date('Y-m-01') <= date("Y-m-d", strtotime('monday this week'))) ? date('Y-m-01') : date("Y-m-d", strtotime('monday this week')),
//    'endDate' => (date('Y-m-t') >= date("Y-m-d", strtotime('sunday this week'))) ? date('Y-m-t') : date("Y-m-d", strtotime('sunday this week')));
		$params = array('startDate' => date("Y-m-d"),
		                'endDate'   => date("Y-m-d", strtotime("+1 month")));
		$url    = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $token,
			"Organization: " . $organization
		));
		$response = json_decode(curl_exec($ch), true);
		curl_close($ch);

		if ((count($response['Data']['EnabledDays']) > 0 || count($response['Data']['DisabledDays']) > 0) && $claen_table) {
//      $wpdb->query("TRUNCATE `$table_da`");
			$claen_table = false;
			$sql         .= $wpdb->prepare(
				"INSERT INTO `" . $table_da . "` (`id`, `id_doctor`, `date`, `enabled`) VALUES ");
		}

		if (!$claen_table) {
			foreach ($response['Data']['EnabledDays'] as $key => $item) {
//        if (false === $wpdb->insert($table_da, array(
//            'id_doctor' => $doctor->api_id,
//            'date'      => date('Y-m-d', strtotime($item)),
//            'enabled'   => 1
//          ))) {
//          return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
//        }
				$day = date('Y-m-d', strtotime($item));
				$sql .= $wpdb->prepare(
					" (NULL,'" . $doctor->api_id . "', '" . $day . "','1'),");
			}

			foreach ($response['Data']['DisabledDays'] as $key => $item) {
//        if (false === $wpdb->insert($table_da, array(
//            'id_doctor' => $doctor->api_id,
//            'date'      => date('Y-m-d', strtotime($item)),
//            'enabled'   => 0
//          ))) {
//          return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
//        }
				$day = date('Y-m-d', strtotime($item));
				$sql .= $wpdb->prepare(
					" (NULL,'" . $doctor->api_id . "', '" . $day . "','0'),");
			}
		}
	}
	$sql = rtrim($sql, ',') . ';';
	if (!$claen_table) {
		$wpdb->query($wpdb->prepare("TRUNCATE `$table_da`"));
		$wpdb->query($sql);
	}
}

function getDateSlotsAPI()
{
	$token        = getToken();
	$organization = getOrganizations();

	$doctor_id = $_POST['api_id'];
	date_default_timezone_set('Europe/Kiev');

	$ch       = curl_init();
//  $endpoint = 'https://api.mymedcabinet.com.ua/Physicians/' . $doctor_id . '/DaysSchedule';
	$endpoint = API_URL_SERVER.'/Physicians/' . $doctor_id . '/DaysSchedule';

	$params = array('startDate' => date("Y-m-d"),
	                'endDate'   => date("Y-m-d", strtotime("+1 month")));
	$url    = $endpoint . '?' . http_build_query($params);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization: Bearer " . $token,
		"Organization: " . $organization
	));

	//если не доступно берем из нашей таблицы
//  if (curl_exec($ch) == false && curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
//    return getDateSlots();
//  }

	$response = json_decode(curl_exec($ch), true);
	curl_close($ch);


	$obj_arr = [];

	foreach ($response['Data']['EnabledDays'] as $key => $item) {
		$obj                                      = new stdClass();
		$obj->id_doctor                           = $doctor_id;
		$obj->date                                = date('Y-m-d', strtotime($item));
		$obj->enabled                             = 1;
		$obj_arr[date('Y-m-d', strtotime($item))] = $obj;
	}

	foreach ($response['Data']['DisabledDays'] as $key => $item) {
		$obj                                      = new stdClass();
		$obj->id_doctor                           = $doctor_id;
		$obj->date                                = date('Y-m-d', strtotime($item));
		$obj->enabled                             = 0;
		$obj_arr[date('Y-m-d', strtotime($item))] = $obj;
	}
	ksort($obj_arr);

	return $obj_arr;
}

function getDateSlots()
{
	global $wpdb;
	$doctor_id = $_POST['api_id'];
	$table     = $wpdb->prefix . 'api_data_cache_days';
	date_default_timezone_set('Europe/Kiev');
	$toady           = date("Y-m-d");//(date('Y-m-01') <= date("Y-m-d", strtotime('monday this week'))) ? date('Y-m-01') : date("Y-m-d", strtotime('monday this week'));//начало месяца
	$today_plus_week = date("Y-m-d", strtotime("+1 month"));//(date('Y-m-t') >= date("Y-m-d", strtotime('sunday this week'))) ? date('Y-m-t') : date("Y-m-d", strtotime('sunday this week'));//конец месяца

	return $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table` WHERE `id_doctor` = '" . $doctor_id . "' AND `date` BETWEEN '" . $toady . "' AND '" . $today_plus_week . "' ORDER BY `date`"
	));
}


add_action('wp', 'time_slot_activation');
function time_slot_activation()
{
	if (!wp_next_scheduled('update_time_slots_hook_1')) {
		wp_schedule_event(time(), 'hourly', 'update_time_slots_hook_1');
	}
}

add_action('update_time_slots_hook_1', 'getUpdateTimeSlots');

function getUpdateTimeSlots()
{
	global $wpdb;
	$table_t = $wpdb->prefix . 'api_data_cache_time';
	$table_e = $wpdb->prefix . 'api_data_cache_events';
	$table_d = $wpdb->prefix . 'api_data_cache_doctors';
	date_default_timezone_set('Europe/Kiev');

	$doctors = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table_d`"
	));

	$token        = getToken();
	$organization = getOrganizations();

	$claen_table = true;

	$period = new DatePeriod(
		new DateTime(date("Y-m-d")),
		new DateInterval('P1D'),
		new DateTime(date("Y-m-d", strtotime("+1 month +1 day")))
	);

	$days = [];

	foreach ($period as $date) {
		$days[] = $date->format('Y-m-d');
	}

	$sql = '';
	foreach ($doctors as $doctor) {
		foreach ($days as $day) {

			$events = $wpdb->get_results($wpdb->prepare(
				"
		    SELECT * FROM `$table_e` WHERE `doctor_id` = '" . $doctor->api_id . "' ORDER BY Duration"
			));

			$ch       = curl_init();
//      $endpoint = 'https://api.mymedcabinet.com.ua/Physicians/' . $doctor->api_id . '/DaySchedule';
			$endpoint = API_URL_SERVER.'/Physicians/' . $doctor->api_id . '/DaySchedule';
            if ($doctor->api_id != 481) {
                $params = array('selectedDate' => $day,
                    'eventDuration' => $events[0]->Duration);
            } else {
                $params = array('selectedDate' => $day,
                    'eventDuration' => 30);
            }
			$url      = $endpoint . '?' . http_build_query($params);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Authorization: Bearer " . $token,
				"Organization: " . $organization
			));
			$response = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if (count($response['Data']['Appointments']) > 0 && $claen_table) {
//        $wpdb->query("TRUNCATE `$table_t`");
				$claen_table = false;
				$sql         .= $wpdb->prepare(
					"INSERT INTO `" . $table_t . "` (`id`, `id_doctor`, `date`, `eventDuration`, `StartTime`, `FinalTime`, `Reserved`) VALUES ");
			}

			if (!$claen_table) {
				foreach ($response['Data']['Appointments'] as $key => $item) {

					$eventDuration = $events[0]->Duration;
					$StartTime     = date('Y-m-d H:i:s', strtotime($item['StartTime']));
					$FinalTime     = date('Y-m-d H:i:s', strtotime($item['FinalTime']));
					$Reserved      = $item['Reserved'];

					$sql .= $wpdb->prepare(
						" (NULL,'" . $doctor->api_id . "', '" . $day . "','" . $eventDuration . "','" . $StartTime . "','" . $FinalTime . "','" . $Reserved . "'),");

//          if (false === $wpdb->insert($table_t, array(
//              'id_doctor'     => $doctor->api_id,
//              'date'          => $day,
//              'eventDuration' => $events[0]->Duration,
//              'StartTime'     => date('Y-m-d H:i:s', strtotime($item['StartTime'])),
//              'FinalTime'     => date('Y-m-d H:i:s', strtotime($item['FinalTime'])),
//              'Reserved'      => $item['Reserved']
//            ))) {
//            return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
//          }
				}
			}
		}
	}
	$sql = rtrim($sql, ',') . ';';
	if (!$claen_table) {
		$wpdb->query($wpdb->prepare("TRUNCATE `$table_t`"));
		$wpdb->query($sql);
	}
//  echo $sql;
}

function getTimeSlotsAPI($date_slots)
{
	global $wpdb;
	$table_e = $wpdb->prefix . 'api_data_cache_events';

	date_default_timezone_set('Europe/Kiev');
	$doctor_id = $_POST['api_id'];

	$token        = getToken();
	$organization = getOrganizations();

	$events = $wpdb->get_results($wpdb->prepare(
		"
		    SELECT * FROM `$table_e` WHERE `doctor_id` = '" . $doctor_id . "' ORDER BY Duration"
	));

	$arr_obg = [];

	foreach ($date_slots as $day) {
		if ($day->enabled == 0) continue;
		$ch       = curl_init();
//    $endpoint = 'https://api.mymedcabinet.com.ua/Physicians/' . $doctor_id . '/DaySchedule';
		$endpoint = API_URL_SERVER.'/Physicians/' . $doctor_id . '/DaySchedule';
		$params   = array('selectedDate'  => $day->date,
		                  'eventDuration' => $events[0]->Duration);
		$url      = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $token,
			"Organization: " . $organization
		));

		//если не доступно берем из нашей таблицы
//    if (curl_exec($ch) == false && curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
//      return getTimeSlots();
//    }

		$response = json_decode(curl_exec($ch), true);
		curl_close($ch);

		foreach ($response['Data']['Appointments'] as $key => $item) {
			$obj                = new stdClass();
			$obj->id_doctor     = $doctor_id;
			$obj->date          = $day->date;
			$obj->eventDuration = $events[0]->Duration;
			$obj->StartTime     = date('Y-m-d H:i:s', strtotime($item['StartTime']));
			$obj->FinalTime     = date('Y-m-d H:i:s', strtotime($item['FinalTime']));
			$obj->Reserved      = $item['Reserved'];
			$arr_obg[]          = $obj;
		}
	}

	return $arr_obg;
}

function getTimeSlots()
{
	global $wpdb;
	$doctor_id = $_POST['api_id'];
	$table     = $wpdb->prefix . 'api_data_cache_time';
	$table_e   = $wpdb->prefix . 'api_data_cache_events';
	date_default_timezone_set('Europe/Kiev');
	$toady           = date("Y-m-d");//(date('Y-m-01') <= date("Y-m-d", strtotime('monday this week'))) ? date('Y-m-01') : date("Y-m-d", strtotime('monday this week'));
	$today_plus_week = date("Y-m-d", strtotime("+1 month"));//(date('Y-m-t') >= date("Y-m-d", strtotime('sunday this week'))) ? date('Y-m-t') : date("Y-m-d", strtotime('sunday this week'));//конец месяца

	//eventDuration в апи его нужно отправлять в запросе
	$events = $wpdb->get_results($wpdb->prepare(
		"
		    SELECT * FROM `$table_e` WHERE `doctor_id` = '" . $doctor_id . "' ORDER BY Duration"
	));

	return $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table` WHERE `id_doctor` = '" . $doctor_id . "' AND `date` BETWEEN '" . $toady . "' AND '" . $today_plus_week . "' AND `eventDuration` = '" . $events[0]->Duration . "'"
	));
}

add_action('wp_ajax_get_query_reserv', 'getQueryReserv');
add_action('wp_ajax_nopriv_get_query_reserv', 'getQueryReserv');
function getQueryReserv()
{
	$user = new Cabinet_User();
	$is_logged_in = $user->isLogin();
	if ($is_logged_in) {
		reserveFromCabinet();
		exit;
	}
	$PhoneNumber = str_replace([' ', '(', ')', '-'], "", $_POST['PhoneNumber']);

	$birthDate   = $_POST['birthDate'];
	$client_data = getIdentificationClient($PhoneNumber, $birthDate);
	if ($client_data['HasErrors'] == 1) {
		wp_send_json_success($client_data);
	}

	//отправляем запрос который отправляет смс на номер клиента
	$answer = sendApprovalSmsCode($client_data['Data']);
	wp_send_json_success($answer);
	//отправляем это смс для подтверждения записи
	//почему вызов здесь?
//  sendReserve();
}

//GET /Patients/byPersonal
function getIdentificationClient($PhoneNumber, $birthDate)
{
	$token        = getToken();
	$organization = getOrganizations();

	$ch       = curl_init();
//  $endpoint = 'https://api.mymedcabinet.com.ua/Patients/byPersonal';
	$endpoint = API_URL_SERVER.'/Patients/byPersonal';
	$params   = array('phoneNumber' => $PhoneNumber,
	                  'birthDate'   => $birthDate);
	$url      = $endpoint . '?' . http_build_query($params);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization: Bearer " . $token,
		"Organization: " . $organization
	));

	//curl_exec($ch) == false //выдает 404 если нет такого юзера в базе
//	if (curl_exec($ch) == false && curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
	if (curl_exec($ch) == false) {

		getUpdateToken();

		wp_send_json_error(curl_error($ch));
		//{"success":false,"data":"The requested URL returned error: 401 Unauthorized"}
		//wp_send_json_error(curl_error($ch));
	}

	$response = json_decode(curl_exec($ch), true);

	curl_close($ch);

	return $response;
}

function sendApprovalSmsCode($client_data)
{
	$token           = getToken();
	$organization    = getOrganizations();
	$organization_id = getOrganizationId();
	$evens           = getEvents();

//
//  print_r($client_data);
//  print_r($_POST);
//  print_r($evens);

//  $_POST['EventId']
//  $_POST['EventDuration']
	$postfield = array(
		'PatientId'           => $client_data['Id'],
		'HealthcareServiceId' => $organization_id,
		'SpecialityId'        => $_POST['SpecialityId'],
		'PhysicianId'         => $_POST['PhysicianId'],
		'EventId'             => $evens[0]->api_id,
		'EventDuration'       => $evens[0]->Duration,
		'PhoneNumber'         => str_replace([' ', '(', ')', '-'], "", $_POST['PhoneNumber']),
		'EMC'                 => $client_data['EMC'],
		'SelectedDateTime'    => str_replace(' ', 'T', $_POST['SelectedDateTime']),//'2020-07-01T16:30:00'
		'ReservationType'     => $_POST['ReservationType']
	);

	if (trim($_POST['Email']) != '') {
		$postfield['Email'] = trim($_POST['Email']);
	}
	if (trim($_POST['Comment']) != '') {
		$postfield['Comment'] = trim($_POST['Comment']);
	}


//  $ch = curl_init('https://api.mymedcabinet.com.ua/appointments/sendapprovalsmscode');
	$ch = curl_init(API_URL_SERVER.'/appointments/sendapprovalsmscode');
//  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfield));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"Authorization: Bearer " . $token,
		"Organization: " . $organization
	));

	$response = json_decode(curl_exec($ch), true);

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
		getUpdateToken();

		wp_send_json_error(curl_error($ch));
	}

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {

		wp_send_json_error(curl_error($ch));
		//{"success":false,"data":"The requested URL returned error: 401 Unauthorized"}
		//wp_send_json_error(curl_error($ch));
	}

//  print_r(curl_getinfo($ch));
//  print_r(curl_error($ch));
//  print_r($response);
//  print_r($postfield);

	curl_close($ch);
	return $response;
}

add_action('wp_ajax_send_reserve', 'sendReserve');
add_action('wp_ajax_nopriv_send_reserve', 'sendReserve');
function sendReserve()
{
	global $wpdb;
	$table_t = $wpdb->prefix . 'api_data_cache_time';

	$PhoneNumber = str_replace([' ', '(', ')', '-'], "", $_POST['PhoneNumber']);

	$birthDate   = $_POST['birthDate'];
	$client_data = getIdentificationClient($PhoneNumber, $birthDate);
	if ($client_data['HasErrors'] == 1) {
		wp_send_json_success($client_data);
	}

	$token           = getToken();
	$organization    = getOrganizations();
	$organization_id = getOrganizationId();
	$evens           = getEvents();

	$postfield = [
		'PatientId'           => $client_data['Data']['Id'],
		'HealthcareServiceId' => $organization_id,
		'SpecialityId'        => $_POST['SpecialityId'],
		'PhysicianId'         => $_POST['PhysicianId'],
		'EventId'             => $evens[0]->api_id,
		'EventDuration'       => $evens[0]->Duration,
		'PhoneNumber'         => str_replace([' ', '(', ')', '-'], "", $_POST['PhoneNumber']),
		'EMC'                 => $client_data['Data']['EMC'],
		'SelectedDateTime'    => str_replace(' ', 'T', $_POST['SelectedDateTime']),//'2020-07-01T16:30:00'
		'ReservationType'     => $_POST['ReservationType']
	];

	if (trim($_POST['Email']) != '') {
		$postfield['Email'] = trim($_POST['Email']);
	}
	if (trim($_POST['Comment']) != '') {
		$postfield['Comment'] = trim($_POST['Comment']);
	}

//  $ch = curl_init('https://api.mymedcabinet.com.ua/Appointments/Reserve?approvalSmsCode=' . trim($_POST['SMSkod']));
	$ch = curl_init(API_URL_SERVER.'/Appointments/Reserve?approvalSmsCode=' . trim($_POST['SMSkod']));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfield));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"Authorization: Bearer " . $token,
		"Organization: " . $organization
	));


	$response = json_decode(curl_exec($ch), true);

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
		getUpdateToken();

		wp_send_json_error(curl_error($ch));
	}

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {

		wp_send_json_error(curl_error($ch));
		//{"success":false,"data":"The requested URL returned error: 401 Unauthorized"}
		//wp_send_json_error(curl_error($ch));
	}

	$wpdb->query($wpdb->prepare("UPDATE `$table_t` SET `Reserved` = 1
	                    WHERE `id_doctor` = " . $_POST['PhysicianId'] . " AND `StartTime` = '" . $_POST['SelectedDateTime'] . "'"));


	curl_close($ch);

	wp_send_json_success($response);
}

function reserveFromCabinet()
{
	global $wpdb;
	$table_t = $wpdb->prefix . 'api_data_cache_time';

	$user = new Cabinet_User();
	$user_data = $user->get_user_data();
	$token = $user->get_token();

	$organization = getOrganizations();
	$evens = getEvents();

	$postfield = [
		'PatientId'        => $user_data['Id'],
		'PhysicianId'      => $_POST['PhysicianId'],
		'EventId'          => $evens[0]->api_id,
		'EventDuration'    => $evens[0]->Duration,
		'SelectedDateTime' => str_replace(' ', 'T', $_POST['SelectedDateTime']),//'2020-07-01T16:30:00'
		'ReservationType'  => $_POST['ReservationType'],
	];

	if (trim($_POST['Comment']) != '') {
		$postfield['Comment'] = trim($_POST['Comment']);
	}

	$ch = curl_init(API_URL_SERVER . '/Appointments/ReserveFromPersonalArea');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfield));
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json",
		"Authorization: Bearer " . $token,
		"Organization: " . $organization,
	]);

	$response = json_decode(curl_exec($ch), true);

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
		wp_send_json_error(curl_error($ch));
	}

	if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
		wp_send_json_error(curl_error($ch));
		//{"success":false,"data":"The requested URL returned error: 401 Unauthorized"}
		//wp_send_json_error(curl_error($ch));
	}

	$wpdb->query($wpdb->prepare("
		UPDATE `$table_t`
		SET `Reserved` = 1
	   WHERE `id_doctor` = " . $_POST['PhysicianId'] . " AND `StartTime` = '" . $_POST['SelectedDateTime'] . "'"));

	_cancelAndUpdateAppointment();

	curl_close($ch);

	wp_send_json_success('reserveFromCabinet');
}

function _cancelAndUpdateAppointment()
{
	if (!empty($_POST['cancel_appointment_id'])
	    && $_POST['SpecialityId'] == $_POST['cancel_speciality_id']
	    && $_POST['PhysicianId'] == $_POST['cancel_api_id']
	    && $_POST['EmpId'] == $_POST['cancel_emp_id']
	) {
			Cabinet_Request_Logic::cancel_appointment($_POST['cancel_appointment_id']);

			Cabinet_Library::update_doctor_day_schedule($_POST['PhysicianId'], $_POST['cancel_appointment_date']);
	}
}

function getEmpIdDoctor($id)
{
	global $wpdb;
	$doctor_emp_id = $wpdb->get_results($wpdb->prepare("SELECT `EmpId` FROM `" . $wpdb->prefix . "api_data_cache_doctors` WHERE `api_id` = '" . $id . "'"));
	return $doctor_emp_id[0]->EmpId;
}


add_action('wp', 'litle_schedule_activation');
function litle_schedule_activation()
{
	if (!wp_next_scheduled('update_litle_schedule_hook_1')) {
		wp_schedule_event(time() + 600, 'hourly', 'update_litle_schedule_hook_1');
	}
}

add_action('update_litle_schedule_hook_1', 'getUpdateLitleSchedule');
function getUpdateLitleSchedule()
{
	global $wpdb;
	date_default_timezone_set('Europe/Kiev');
	$firstday_next_week = date('Y-m-d', strtotime("next monday"));
	$lastday_nex_week   = date('Y-m-d', strtotime("+6 day", strtotime($firstday_next_week)));

	$Monday    = $firstday_next_week;
	$Tuesday   = date('Y-m-d', strtotime("+1 day", strtotime($firstday_next_week)));
	$Wednesday = date('Y-m-d', strtotime("+2 day", strtotime($firstday_next_week)));
	$Thursday  = date('Y-m-d', strtotime("+3 day", strtotime($firstday_next_week)));
	$Friday    = date('Y-m-d', strtotime("+4 day", strtotime($firstday_next_week)));
	$Saturday  = date('Y-m-d', strtotime("+5 day", strtotime($firstday_next_week)));
	$Sunday    = $lastday_nex_week;

	$table_d  = $wpdb->prefix . 'api_data_cache_doctors';
	$table_da = $wpdb->prefix . 'api_data_cache_days';
	$table_t  = $wpdb->prefix . 'api_data_cache_time';
	$table_l  = $wpdb->prefix . 'api_data_cache_litle_schedule';

	// if (date('Y-m-d H:i:s', strtotime("now")) < date('Y-m-d H:i:s', strtotime("sunday"))) return '';



	$wpdb->query("TRUNCATE `$table_l`");

	$doctors = $wpdb->get_results($wpdb->prepare(
		"
		SELECT * FROM `$table_d`"
	));

	foreach ($doctors as $doctor) {
		$arr_res = array();

		$dates = $wpdb->get_results($wpdb->prepare(
			"
		    SELECT `date` FROM `$table_da` WHERE `id_doctor` = " . $doctor->api_id . " AND `date` BETWEEN '" . $firstday_next_week . "' AND '" . $lastday_nex_week . "' AND `enabled` = 1"
		));

		foreach ($dates as $date) {
			$times = $wpdb->get_results($wpdb->prepare(
				"
		    SELECT min(`StartTime`) m_t, max(`FinalTime`) ma_t FROM `$table_t` WHERE `id_doctor` = " . $doctor->api_id . " AND `date` LIKE '" . $date->date . "' GROUP BY `id_doctor`, `date`"
			));

			if (!empty($times[0]->m_t) && !empty($times[0]->ma_t)) {
				$arr_res[$date->date]['min'] = date('H:i', strtotime($times[0]->m_t));
				$arr_res[$date->date]['max'] = date('H:i', strtotime($times[0]->ma_t));
			}

		}

		if (false === $wpdb->insert($table_l, array(
				'id_doctor' => $doctor->api_id,
				'monday'    => $arr_res[$Monday]['min'] . ' - ' . $arr_res[$Monday]['max'],
				'tuesday'   => $arr_res[$Tuesday]['min'] . ' - ' . $arr_res[$Tuesday]['max'],
				'wednesday' => $arr_res[$Wednesday]['min'] . ' - ' . $arr_res[$Wednesday]['max'],
				'thursday'  => $arr_res[$Thursday]['min'] . ' - ' . $arr_res[$Thursday]['max'],
				'friday'    => $arr_res[$Friday]['min'] . ' - ' . $arr_res[$Friday]['max'],
				'saturday'  => $arr_res[$Saturday]['min'] . ' - ' . $arr_res[$Saturday]['max'],
				'sunday'    => $arr_res[$Sunday]['min'] . ' - ' . $arr_res[$Sunday]['max']
			))) {
			return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
		}

	}

}

add_action('wp_ajax_get_litle_schedule', 'getLitleSchedule');
add_action('wp_ajax_nopriv_get_litle_schedule', 'getLitleSchedule');
function getLitleSchedule()
{
	global $wpdb;
	$doctor_id = $_POST['doc_id'];
//  $this_day    = date('Y-m-d');
//  $this_sunday = date('Y-m-d', strtotime("sunday"));

	$table_l = $wpdb->prefix . 'api_data_cache_litle_schedule';

	$resp = $wpdb->get_results($wpdb->prepare(
		"
    SELECT * FROM `$table_l` WHERE `id_doctor` = '" . $doctor_id . "'"
	));

	wp_send_json_success($resp[0]);
}

add_action('wp_ajax_get_doctor_ids_bysite', 'getDoctorIdsBySite');
add_action('wp_ajax_nopriv_get_doctor_ids_bysite', 'getDoctorIdsBySite');
function getDoctorIdsBySite()
{
	global $wpdb;
	$table_d    = $wpdb->prefix . 'api_data_cache_doctors';
	$table_pm   = $wpdb->prefix . 'postmeta';
	$choose_doc = $_POST['choose_doc'];

	$resp = $wpdb->get_results($wpdb->prepare(
		"
    SELECT `meta_value` FROM `$table_pm` WHERE `meta_key` LIKE 'api_doctor_id' AND `post_id` = '" . $choose_doc . "'"
	));

	$resp2 = $wpdb->get_results($wpdb->prepare(
		"
    SELECT `speciality_id`, `api_id`, `EmpId` FROM `$table_d` WHERE `api_id` = '" . $resp[0]->meta_value . "'"
	));

	wp_send_json_success($resp2[0]);

}

//get_header_contacts
add_action('wp_ajax_get_header_contacts', 'getHeaderContacts');
add_action('wp_ajax_nopriv_get_header_contacts', 'getHeaderContacts');
function getHeaderContacts()
{
    $contacts = pods( 'header_contacts' );

    wp_send_json_success($contacts);
}

add_action('wp_ajax_get_post_id_by_api_doctor_id', 'getPostIdByApiDoctorId');
add_action('wp_ajax_nopriv_get_post_id_by_api_doctor_id', 'getPostIdByApiDoctorId');
function getPostIdByApiDoctorId()
{
    $api_doctor_id = $_POST['api_doctor_id'];


    $args = array(
        'meta_key' => 'api_doctor_id',
        'meta_value' => $api_doctor_id,
        'post_type' => 'doctor',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'fields' => 'ids',
    );
    $doctor_posts = get_posts($args);

    if($doctor_posts[0]){
        wp_send_json_success(get_permalink($doctor_posts[0]).'#make-an-appointment');
    } else {
        wp_send_json_success(get_permalink(1140));//все врачи
    }
}


add_action('wp_ajax_check_city_by_ip', 'checkCityByIp');
add_action('wp_ajax_nopriv_check_city_by_ip', 'checkCityByIp');
function checkCityByIp()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://api.geoiplookup.net/?query=' . $ip;

    $response = wp_remote_get($url);
    $body = wp_remote_retrieve_body($response);

    $data = simplexml_load_string($body);
    $city = (string) $data->results->result->city;

    if ($city === 'Poltava'){
        wp_send_json_success(true);
    }
}
