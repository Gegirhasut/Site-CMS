<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Subscriber.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'unsub')
	{
		$subscriber = new Subscriber();
		$postHelper = $this->_loadPostHelper();
		$email = $postHelper->GetFromGet('email');
		
		$adminModel = $this->_getModelByName('AdminBase');
		$adminModel->delete($subscriber->_tableName, "where email='$email'");
		
		$mail = $this->_loadEmail();
	
		$mail->LoadTemplate('unsubscribe');
		$mail->SetValue('email', $email);
		
		$mail->Send('89139008447@ngs.ru', 'Отписались от рассылки', "info@arktida-opt.ru", false);
		
		header('location: /?unsubscribe=1');
	}
}