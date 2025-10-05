<?php

class Cabinet_Session
{

	private $_db_instance;
	private $table;

	public function __construct()
	{
		global $wpdb;
		$this->_db_instance = $wpdb;
		$this->table = $this->_db_instance->prefix . "cabinet_session";
	}

	public function get($token)
	{
		$data = $this->_db_instance->get_var(
			$this->_db_instance->prepare("
				SELECT data
				FROM " . $this->table . "
				WHERE token_hash = '" . $token . "'
				"));

		return unserialize($data, ['allowed_classes' => false]);
	}

	public function set($token, $data, $expires)
	{
		if (false === $this->_db_instance->insert($this->table, [
				'token'      => $token,
				'token_hash' => md5($token),
				'data'       => serialize($data),
				'expires'    => $expires,
			])
		) {
			return new WP_Error('db_insert_error',
				__('Could not insert data into the database.', 'mz'),
				$this->_db_instance->last_error
			);
		}
	}

	public function update($token, $data, $expires)
	{
		if (false === $this->_db_instance->update($this->table, [
				'data'    => serialize($data),
				'expires' => $expires,
			], ['token_hash' => $token])
		) {
			return new WP_Error('db_update_error',
				__('Could not update data into the database.', 'mz'),
				$this->_db_instance->last_error
			);
		}
	}

	public function delete($token)
	{
		if (false === $this->_db_instance->delete($this->table, ['token_hash' => $token])
		) {
			return new WP_Error('db_delete_error',
				__('Could not delete data into the database.', 'mz'),
				$this->_db_instance->last_error
			);
		}
	}

	public function get_token($token_hash)
	{
		return $this->_db_instance->get_var(
			$this->_db_instance->prepare("
				SELECT token
				FROM " . $this->table . "
				WHERE token_hash = '" . $token_hash . "'
				"));
	}

	public function get_expired()
	{
		return $this->_db_instance->get_results(
			$this->_db_instance->prepare("
				SELECT cabinet_session_id, data
				FROM " . $this->table . "
				WHERE expires < '" . time() . "'
				"), ARRAY_A);
	}

	public function update_by_cabinet_session_id($cabinet_session_id, $data)
	{
		if (false === $this->_db_instance->update($this->table, [
				'data' => serialize($data),
			], ['cabinet_session_id' => $cabinet_session_id])
		) {
			return new WP_Error('db_update_error',
				__('Could not update data into the database.', 'mz'),
				$this->_db_instance->last_error
			);
		}
	}

	public function isValid($token): bool
	{
		$expires = $this->_db_instance->get_var(
			$this->_db_instance->prepare("
				SELECT expires
				FROM " . $this->table . "
				WHERE token_hash = '" . $token . "'
				"));

		return $expires > time();
	}
}