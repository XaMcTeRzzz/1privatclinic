<?php
global $wp;

require_once 'login.php';
require_once 'registration.php';
require_once 'sms-code.php';
require_once 'successful.php';

if (in_array($wp->request, ['cabinet', 'cabinet/appointments', 'cabinet/analysis', 'cabinet/patient'])) {
	require_once 'inside/move-appointment.php';
	require_once 'inside/cancel-appointment.php';
	require_once 'inside/exit.php';
	require_once 'inside/send-document.php';
}