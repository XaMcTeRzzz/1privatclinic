<?php

require_once('cabinet-cache/Lite.php');

class Cabinet_Cache
{
	private $_cache_instance;

	public function __construct()
	{
		$options = [
			'cacheDir' => get_template_directory() . '/core/cabinet/core/cabinet-cache/tmp/',
			'lifeTime' => 86400,
		];
		$this->_cache_instance = new Cache_Lite($options);
	}

	public function get($cache_id)
	{
		return $this->_cache_instance->get($cache_id);
	}

	public function set($cache_data, $cache_id)
	{
		return $this->_cache_instance->save($cache_data, $cache_id);
	}
}