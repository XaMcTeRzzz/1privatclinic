<?php

add_action('init', function () {
	add_rewrite_endpoint('cabinet', EP_ROOT);
	$rewrite_rules = get_option('rewrite_rules');
	if (!empty($rewrite_rules) && !array_key_exists('cabinet(/(.*))?/?$', $rewrite_rules)) {
		flush_rewrite_rules(false);
	}
});

add_action('template_redirect', function () {
	if (!session_id()) {
		session_start();
	}

	$machinesUrl = get_query_var('cabinet');

	if ($machinesUrl) {
		if (!in_array($machinesUrl, ['index', 'appointments', 'analysis', 'patient', 'doctor-shedule'])) {
			status_header(404);
			include get_404_template();
			exit;
		}

		$user = new Cabinet_User();
		$is_login = $user->isLogin();

		if (!$is_login) {
			$user->logout();
			wp_safe_redirect(home_url());
			exit;
		}

		// var_dump($machinesUrl, $_GET);
		// $machinesURl contains the url part after example.com/cabinet
		// e.g. if url is example.com/cabinet/some/thing/else
		// then $machinesUrl == 'some/thing/else'
		// and params can be retrieved via $_GET

		// after parsing url and calling api, it's just a matter of loading a template:
		locate_template('core/cabinet/view/cabinet.php', true, true, ['route' => $machinesUrl]);

		// then stop processing
		exit;
	}
});

add_filter('request', function ($vars = []) {
	if (isset($vars['cabinet']) && empty($vars['cabinet'])) {
		$vars['cabinet'] = 'index';
	}
	return $vars;
});

//callback to print a simple input field
function cabinet_custom_field_callback()
{
	echo '<input
	name="cabinet_manager_email"
	id="cabinet_manager_email"
	type="text"
	class="regular-text ltr"
	value="' . get_option('cabinet_manager_email') . '" />';
}

function add_cabinet_custom_section_to_settings()
{
	//register setting to save the data
	register_setting('general', 'cabinet_manager_email');

	//add the section to general page in admin panel
	add_settings_section(
		'cabinet_id_for_settings_section',
		'Настройки кабинета',
		'',
		'general'
	);

	//add a sample field to this section.
	add_settings_field(
		'cabinet_manager_email',
		'E-mail менеджера',
		'cabinet_custom_field_callback',
		'general',
		//put the id of custom section here:
		'cabinet_id_for_settings_section'
	);
}

add_action('admin_init', 'add_cabinet_custom_section_to_settings');
