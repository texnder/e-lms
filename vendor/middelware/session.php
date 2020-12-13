<?php

use src\session\persistent;
use src\session\userAutologin;

/**
 * 
 */
class session
{

	public static function message(string $message)
	{
		$_SESSION['message'] = $message;
	}

	public static function unset(string $key)
	{
		unset($_SESSION[$key]);
	}

	public static function isset(string $key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	public static function flash(string $key)
	{
		$message = self::isset($key);
		self::unset($key);
		return $message;
	}

	public static function _token()
	{
		if (isset($_REQUEST['_token'])) {
			if ($_REQUEST['_token'] === self::isset('_token')) {
				return true;
			}
		}
		throw new Exception("token is not valid!!");
	}

	public static function get(string $key)
	{
		return $_SESSION[$key];
	}

	public static function set(string $key,$val)
	{
		$_SESSION[$key] = $val;
	}


	public static function active()
	{
		// activating session start time..
		$_SESSION['active'] = time();
	}

}