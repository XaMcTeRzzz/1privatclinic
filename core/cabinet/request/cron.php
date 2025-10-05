<?php

add_action('wp', 'cleanup_cabinet_personal_data');
function cleanup_cabinet_personal_data()
{
	if (!wp_next_scheduled('cleanup_cabinet_personal_data_hook')) {
		wp_schedule_event(time(), 'daily', 'cleanup_cabinet_personal_data_hook');
	}
}

add_action('cleanup_cabinet_personal_data_hook', 'cabinet_cleanup_personal_data');
function cabinet_cleanup_personal_data()
{
	$cabinet_session = new Cabinet_Session();
	$expired = $cabinet_session->get_expired();

	foreach ($expired as $item) {
		$data = unserialize($item['data'], ['allowed_classes' => false]);
		foreach ($data as $key => &$value) {
			if ($key != 'Id' && $key != 'EMC') $value = '';
		}
		unset($value);
		$cabinet_session->update_by_cabinet_session_id($item['cabinet_session_id'], $data);
		_removeTempFolder($data['Id']);
	}
}

function _removeTempFolder($patientId)
{
	$temp_folder = ABSPATH . 'wp-content/themes/medzdrav/core/cabinet/temp/' . $patientId . '/';

	if (file_exists($temp_folder)) {
		$objects = scandir($temp_folder);
		foreach ($objects as $object) {
			if ($object == "." || $object == "..") {
				continue;
			}
			@unlink($temp_folder . $object);
		}

		@rmdir($temp_folder);
	}
}