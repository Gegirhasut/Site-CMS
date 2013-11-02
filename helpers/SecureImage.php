<?php
class SecureImage
{
	function __construct()
	{		
		include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
	}
	
	public function Check()
	{		
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			return false;
		}
		
		return true;
	}
}