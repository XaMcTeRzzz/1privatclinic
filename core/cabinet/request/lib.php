<?php

class Cabinet_Library
{
	public static function get_doctor_data_by_name($doctor_name)
	{
		global $wpdb;

		$table = $wpdb->prefix . 'api_data_cache_doctors';
		return $wpdb->get_results(
			$wpdb->prepare("
				SELECT speciality_id, api_id, EmpId, Speciality
				FROM " . $table . "
				WHERE Name LIKE '" . $doctor_name . "'
				LIMIT 1
				"), ARRAY_A);
	}

	public static function update_doctor_day_schedule($doctor_id, $appointment_date)
	{
		global $wpdb;

		if (empty($doctor_id) || empty($appointment_date)) return false;

		$table = $wpdb->prefix . 'api_data_cache_time';
		$r = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM " . $table . "
				WHERE id_doctor = " . $doctor_id . " AND `date` = '" . $appointment_date . "'
				"), ARRAY_A);

		if (empty($r[0]['eventDuration'])) return false;

		$token = Cabinet_Request_Logic::get_token();

		if (empty($token)) return false;

		$ch = curl_init();
		$endpoint = API_URL_SERVER . '/Physicians/' . $doctor_id . '/DaySchedule';
		$params = ['selectedDate'  => $appointment_date,
		           'eventDuration' => $r[0]['eventDuration']];
		$url = $endpoint . '?' . http_build_query($params);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer " . $token,
			"Organization: " . ORGANIZATION_ID,
		]);
		$response = json_decode(curl_exec($ch), true);

		if (empty($response['Data']['Appointments'])) return false;

		$appointments = $response['Data']['Appointments'];

		foreach ($appointments as $appointment) {
			if (empty($appointment['StartTime']) || empty($appointment['FinalTime'])) continue;

			if (false === $wpdb->update($table, [
					'Reserved' => $appointment['Reserved'],
				], [
					'id_doctor'     => $doctor_id,
					'date'          => $appointment_date,
					'eventDuration' => $r[0]['eventDuration'],
					'StartTime'     => $appointment['StartTime'],
					'FinalTime'     => $appointment['FinalTime'],
				])
			) {
				return new WP_Error('db_update_error',
					__('Could not update data into the database.', 'mz'),
					$wpdb->last_error
				);
			}
		}

		return true;
	}

	public static function send_login_notification_to_crm($emc)
	{
		$url = API_URL_CRM . '/AuthPersonalCabinet';
		$ch = curl_init();

		$params = json_encode(['emc' => $emc]);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"X-Api-Key: a1dc44a0cf0e09c8551a328e331b7bbc",
			"Content-Type: application/json",
		]);

		curl_exec($ch);
	}

    public static function send_doctor_month_schedule($data, $schedule_id)
    {
        $url = API_URL_CRM . '/DoctorMonthSchedule';

        $ch = curl_init();

        $patient_info = (new Cabinet_User())->get_user_data();

        $params = [
            'name' => 'График ' . $patient_info['LastName'] . ' ' . $patient_info['FirstName'] . ' ' . $patient_info['MiddleName'],
            'month' => $data['common']['month'],
            'year' => $data['common']['year'],
            'empId' => $data['common']['emp_id'],
        ];

        foreach ($data['month_schedule'] as $day => $value){
            $dayName = $day < 10 ? 'day0' . $day : 'day' . $day;
            $params[$dayName] = [];
            if(is_array($value)){
                foreach ($value as $item){
                    if($item['type'] != 'undefined') {
                        if($item == 'Vacation'){
                            $params[$dayName] = ['Vacation'];
                        } else {
                            array_push($params[$dayName], json_encode($item));
                        }
                    } else {
                        array_push($params[$dayName], '');
                    }
                }
            }
        }

        if ($schedule_id){//если id есть тогда просто обновляем запись
            $url .= '/' . $schedule_id;
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Api-Key: " . API_X_API_KEY_CRM,
            "Content-Type: application/json",
        ]);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $response;
    }

    public static function check_doctor_month_schedule($data)
    {
        $url = API_URL_CRM . '/DoctorMonthSchedule';
        $ch = curl_init();

        $params = [
            'where[0][type]' => 'equals',
            'where[0][attribute]' => 'month',
            'where[0][value]' => $data['common']['month'],
            'where[1][type]' => 'equals',
            'where[1][attribute]' => 'empId',
            'where[1][value]' => $data['common']['emp_id'],
        ];

        $url = $url . '?' . http_build_query($params);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Api-Key: " . API_X_API_KEY_CRM,
            "Content-Type: application/json",
        ]);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $response;
    }

    public static function get_doctor_month_schedule($emp_id)
    {
        $url = API_URL_CRM . '/DoctorMonthSchedule';
        $ch = curl_init();

        $params = [
            'where[0][type]' => 'equals',
            'where[0][attribute]' => 'empId',
            'where[0][value]' => $emp_id,
            'orderBy' => 'createdAt',
            'order' => 'desc',
            'maxSize' => 1
        ];

        $url = $url . '?' . http_build_query($params);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Api-Key: " . API_X_API_KEY_CRM,
            "Content-Type: application/json",
        ]);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $response;
    }
}