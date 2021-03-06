<?php
/* SVN FILE: $Id: memcache.php 5318 2007-06-20 09:01:21Z phpnut $ */
/**
 * Memcache storage engine for cache
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake.libs.cache
 * @since			CakePHP(tm) v 1.2.0.4933
 * @version			$Revision: 5318 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-06-20 04:01:21 -0500 (Wed, 20 Jun 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Memcache storage engine for cache
 *
 * @package		cake
 * @subpackage	cake.cake.libs.cache
 */
class MemcacheEngine extends CacheEngine {
/**
 * Memcache wrapper.
 *
 * @var object
 * @access private
 */
	var $__Memcache = null;
/**
 * Memcache compress status.
 *
 * @var int
 * @access private
 */
	var $_compress = 0;
/**
 * Set up the cache engine
 *
 * Called automatically by the cache frontend
 *
 * @param array $params Associative array of parameters for the engine
 * @return boolean True if the engine has been succesfully initialized, false if not
 * @access public
 */
	function init(&$params) {
		if (!class_exists('Memcache')) {
			return false;
		}
		$servers = array('127.0.0.1');
		$compress = false;
		extract($params);

		if ($compress) {
			$this->_compress = MEMCACHE_COMPRESSED;
		} else {
			$this->_compress = 0;
		}

		if (!is_array($servers)) {
			$servers = array($servers);
		}
		$this->__Memcache =& new Memcache();
		$connected = false;

		foreach ($servers as $server) {
			$parts = explode(':', $server);
			$host = $parts[0];
			$port = isset($parts[1]) ? $parts[1] : 11211;

			if ($this->__Memcache->addServer($host, $port)) {
				$connected = true;
			}
		}
		return $connected;
	}
/**
 * Write a value in the cache
 *
 * @param string $key Identifier for the data
 * @param mixed $value Data to be cached
 * @param int $duration How long to cache the data, in seconds
 * @return boolean True if the data was succesfully cached, false on failure
 * @access public
 */
	function write($key, &$value, $duration = CACHE_DEFAULT_DURATION) {
		return $this->__Memcache->set($key, $value, $this->_compress, $duration);
	}
/**
 * Read a value from the cache
 *
 * @param string $key Identifier for the data
 * @return mixed The cached data, or false if the data doesn't exist, has expired, or if there was an error fetching it
 * @access public
 */
	function read($key) {
		return $this->__Memcache->get($key);
	}
/**
 * Delete a value from the cache
 *
 * @param string $key Identifier for the data
 * @return boolean True if the value was succesfully deleted, false if it didn't exist or couldn't be removed
 * @access public
 */
	function delete($key) {
		return $this->__Memcache->delete($key);
	}
/**
 * Delete all values from the cache
 *
 * @return boolean True if the cache was succesfully cleared, false otherwise
 * @access public
 */
	function clear() {
		return $this->__Memcache->flush();
	}
/**
 * Return the settings for this cache engine
 *
 * @return array list of settings for this engine
 * @access public
 */
	function settings() {
		return array('class' => get_class($this),
						'compress' => $this->_compress);
	}
}
?>