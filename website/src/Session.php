<?php 

namespace ldahinden;

class Session
{
	public function __construct()
	{
		session_start();
	}
	
	public function get($key)
	{
		if (!isset($_SESSION[$key]))
		{
			return "";
		}
		return $_SESSION[$key];
	}
	
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	public function unset()
	{
		unset($_SESSION["username"]);
	}
	
	public function generateToken()
	{
		$_SESSION["token"] = md5(random_bytes(1000));
	}
	
	public function compareToken($token)
	{
		if ($_SESSION["token"] == $token)
		{
			return true;
		}
		return false;
	}
	
	public function regenerateId()
	{
		session_regenerate_id();
	}
}