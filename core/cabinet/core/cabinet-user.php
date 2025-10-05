<?php

if (!defined('CABINET_LOGIN')) {
	define('CABINET_LOGIN', 'cabinet_logged_in_' . COOKIEHASH);
}

class Cabinet_User
{
	private $_session;

	public function __construct()
	{
		$this->_session = new Cabinet_Session();
	}

	public function login($user_data, $token): void
	{
//		$token = md5(uniqid('', true));
		$token_hash = md5($token['access_token']);
		$expire = $token['expires_in'];
		$this->_session->set($token['access_token'], $user_data, $expire);
		setcookie(CABINET_LOGIN, $token_hash, $expire, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), false);
	}

	public function get_user_data()
	{
		return $this->_session->get($_COOKIE[CABINET_LOGIN]);
	}

	public function get_token()
	{
		return $this->_session->get_token($_COOKIE[CABINET_LOGIN]);
	}

	public function logout(): void
	{
		$this->_session->delete($_COOKIE[CABINET_LOGIN]);
		unset($_COOKIE[CABINET_LOGIN]);
		setcookie(CABINET_LOGIN, '', 0, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), false);
	}

	public function isLogin(): bool
	{
		return $this->_session->isValid($_COOKIE[CABINET_LOGIN]);
	}
}