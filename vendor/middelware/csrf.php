<?php

class csrf
{

 	public static function input()
	{
		echo "<input type='hidden' name='_token' value='".$_SESSION['_token']."'>";
	}

	public static function _token()
	{	
		if (!isset($_SESSION['_token'])) {
			$_SESSION['_token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['_token'] ;
	}

	/*
	* One Time Token..
	*/
	public static function OTT()
	{
		session::_token() ? session::unset('_token') : null;
	}
}