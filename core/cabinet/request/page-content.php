<?php

if (!defined('ABSPATH')) {
	die('-1');
}

class Cabinet_Request_Page_Content
{
	public static function get_page_content($page)
	{
        $user = new Cabinet_User();
        $user_data = $user->get_user_data();
//        $is_doctor = !empty($user_data['EmpPosId']);
        $is_doctor = false;

        if ($is_doctor) {
            if (!in_array($page, ['cabinet', 'cabinet/patient', 'cabinet/doctor-shedule'])) {
                return __('У нас немає такої сторінки для лікаря :(', 'mz');
            }
        } else {
            if (!in_array($page, ['cabinet', 'cabinet/appointments', 'cabinet/analysis', 'cabinet/patient'])) {
                return __('У нас немає такої сторінки для пацієнта :(', 'mz');
            }
        }

		switch ($page) {
			case 'cabinet':
				$data = (new Cabinet_User())->get_user_data();//Cabinet_Request_Logic::get_patient_info_by_emc();
				if (is_wp_error($data)) {
					return $data;
				}

				ob_start();
				get_template_part('core/cabinet/view/parts/index', null, ['data' => $data]);
				return ob_get_clean();
			case 'cabinet/appointments':
				$data = Cabinet_Request_Logic::get_appointments();

				if (empty($_SESSION['archive_appointments_start_date']) && empty($_SESSION['archive_appointments_end_date'])) {
					$_SESSION['archive_appointments_start_date'] = date('d. m. Y', strtotime('01.01.2018'));
					$_SESSION['archive_appointments_end_date'] = date('d. m. Y');
				}
				$data_archive = Cabinet_Request_Logic::get_appointments(
					date('Y-m-d', strtotime(str_replace('. ', '-', $_SESSION['archive_appointments_start_date']))),
					date('Y-m-d', strtotime(str_replace('. ', '-', $_SESSION['archive_appointments_end_date'])))
				);

				if (is_wp_error($data)) {
					return $data;
				}

				if (is_wp_error($data_archive)) {
					return $data_archive;
				}

				ob_start();
				echo '<div class="c-appointments-wrap">';
				$appointments = Cabinet_Request_Logic::get_future_appointments($data);
				$appointments_archive = Cabinet_Request_Logic::get_past_appointments($data_archive);
				get_template_part('core/cabinet/view/parts/appointments', null, ['data' => $appointments]);
				get_template_part('core/cabinet/view/parts/appointments-archive', null, ['data' => $appointments_archive]);
				echo '</div>';
				return ob_get_clean();
			case 'cabinet/analysis':
				if (empty($_SESSION['documents_start_date']) && empty($_SESSION['documents_end_date'])) {
					$_SESSION['documents_start_date'] = date('d. m. Y', strtotime('01.01.2022'));
					$_SESSION['documents_end_date'] = date('d. m. Y');
				}

				$data = Cabinet_Request_Logic::get_documents(
					date('Y-m-d', strtotime(str_replace('. ', '-', $_SESSION['documents_start_date']))),
					date('Y-m-d', strtotime(str_replace('. ', '-', $_SESSION['documents_end_date'])))
				);

				if (is_wp_error($data)) {
					return $data;
				}

				ob_start();
				get_template_part('core/cabinet/view/parts/analysis', null, ['data' => $data]);
				return ob_get_clean();
			case 'cabinet/patient':
				$data = Cabinet_Request_Logic::get_patient_info_by_emc();

				if (is_wp_error($data)) {
					return $data;
				}

				ob_start();
				get_template_part('core/cabinet/view/parts/patient', null, ['data' => $data]);
				return ob_get_clean();
            case 'cabinet/doctor-shedule':
                echo '<div class="c-doctor-shedule">';
                get_template_part('core/cabinet/view/parts/doctor-shedule');
                echo '</div>';
                return ob_get_clean();
			default:
				return __('У нас немає такої сторінки :(', 'mz');
		}
	}
}