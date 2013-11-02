<?php
class PostHelper
{
	public function GetFromPost($name)
	{
		if (!isset($_POST[$name]))
			return null;
			
		if (ini_get('magic_quotes_gpc') == 'Off') {
			return mysql_escape_string($_POST[$name]);
		} else {
			return $_POST[$name];
		}
	}
	
	public function GetFromPostByMask($mask, $remove = false)
	{
		$result = array();

		foreach($_POST as $key => $value)
		{
			if (strpos($key, $mask) !== false) {
				if ($remove) {
					$key = str_replace($mask, "", $key);
				}
				$result[$key] = $value;
			}
		}
		
		return $result;
	}
	
	public function GetFromGet($name)
	{
		if (!isset($_GET[$name]))
			return null;
		return mysql_escape_string($_GET[$name]);
	}
	
	public function IsUrl($url)
	{
		if (strpos($url, 'http') !== false) {
			return true;
			// pattern = @"((https?):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)"
 			//return fopen($url, 'r');
		}
		
		return false;
	}
	
	public function ReregisterPost($smarty)
	{
		foreach($_POST as $key => $value) {
			$smarty->assign($key, $value);
		}
	}
}