<?php
require_once('classes/Controllers/BaseController.php');
require_once('classes/Objects/Callback.php');
require_once('helpers/Email.php');

class Main_c extends BaseController
{	
	function post() {
		$postHelper = $this->_loadPostHelper();
		$callback = new Callback();
		
		$this->ParsePost($callback->_object);
		
		if ($this->CheckObject($callback->_object)) {
			$mail = new Email();
			$mail->LoadTemplate('new_callback');
			$mail->SetValue('name', $callback->_object['fields']['name']['value']);
			$mail->SetValue('phone', $callback->_object['fields']['phone']['value']);
			$mail->SetValue('type', $callback->_object['fields']['type']['value']);
			$mail->SetValue('message', $callback->_object['fields']['message']['value']);
			
			//$mail->Send('max077@mail.ru', 'Заказана услуга обратный звонок через сайт');
			$mail->Send('irina@arktida-opt.ru', 'Заказана услуга обратный звонок через сайт');
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