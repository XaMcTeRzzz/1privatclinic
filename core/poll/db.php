<?php

class Poll_Db
{
	private static $_db_instance;
	private static $table;

	public static function init()
	{
		global $wpdb;
		self::$_db_instance = $wpdb;
		self::$table = self::$_db_instance->prefix . "poll";
	}

	public static function savePollData($poll_id, $date, $data)
	{
		self::init();

		if (false === self::$_db_instance->insert(self::$table, [
				'poll_id' => $poll_id,
				'date'    => $date,
				'data'    => $data,//serialize()
			])
		) {
			return new WP_Error('db_insert_error',
				__('Could not insert data into the database.', 'mz'),
				self::$_db_instance->last_error
			);
		}
	}
}