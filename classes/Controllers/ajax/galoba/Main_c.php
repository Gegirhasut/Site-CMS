<?php
require_once('classes/Controllers/BaseController.php');
require_once('classes/Objects/Galoba.php');
require_once('helpers/Email.php');

class Main_c extends BaseController
{	
	function post() {
		$postHelper = $this->_loadPostHelper();
		$callback = new Galoba();
		
		$this->ParsePost($callback->_object);
		
		if ($this->CheckObject($callback->_object)) {
			$mail = new Email();
			$mail->LoadTemplate('new_galoba');
			$mail->SetValue('name', $callback->_object['fields']['name']['value']);
			$mail->SetValue('info', $callback->_object['fields']['info']['value']);
			$mail->SetValue('message', $callback->_object['fields']['message']['value']);
			
			//$mail->Send('max077@mail.ru', 'Жалоба с сайта АРКТИДА');
			$mail->Send('info@arktida-opt.ru', 'Жалоба с сайта АРКТИДА');
			echo 'success';
		} else {
			echo $callback->_object['check_error'];
		}
		exit;
	}

	function display($uniquePageValue = 'callback')
	{
	}
}