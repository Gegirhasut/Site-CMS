<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('helpers/Email.php');

class Main_c extends BaseAppController
{
	function post () {
		require_once('classes/Objects/User.php');
		$user = new User();
		$postHelper = $this->_loadPostHelper();
		
		$this->ParsePost($user->_object);
		
		if ($this->CheckObject($user->_object)) {
			$user->_object['fields']['state']['value'] = 1;
			$u_id = $this->_adminModel->add($user->_object, $user->_tableName, false);
			$user = $this->_adminModel->get($user->_tableName, "u_id = $u_id");
			
			if (!empty($user)) {
				$_SESSION['user'] = $user[0];
				
				if (isset($_POST['opt'])) {
					require_once('classes/Objects/Subscriber.php');
					$subscriber = new Subscriber();
					$this->ParsePost($subscriber->_object);
					if ($this->CheckObject($subscriber->_object)) {
						$this->_adminModel->add($subscriber->_object, $subscriber->_tableName, false);
					}
				}
				
				$mail = new Email();
				$mail->LoadTemplate('register_thanx');
				$mail->SetValue('login', $user[0]['login']);
				$mail->SetValue('password', $user[0]['password']);
				//print_r($user[0]);
				//echo $user[0]['email'];
				$mail->Send($user[0]['email'], 'Регистрация на сайте Арктида ОПТ');
				
				$mail->LoadTemplate('new_registration');
				$mail->SetValue('login', $user[0]['login']);
				$mail->SetValue('password', $user[0]['password']);
				$mail->SetValue('fio', $user[0]['fio']);
				$mail->SetValue('organisation', $user[0]['organisation']);
				$mail->SetValue('phone', $user[0]['phone']);
				$mail->SetValue('email', $user[0]['email']);
				$mail->SetValue('city', $user[0]['city']);
				
				if ($user[0]['email'] == 'max077@mail.ru') {
					$GLOBALS['db_config']['manager'] = 'max077@mail.ru';
				}
				
				$mail->Send($GLOBALS['db_config']['manager'], 'Новый пользователь зарегистрировался в оптовом разделе сайта');
				
				
			}
			header('location: /arktida-price-list/');
			exit;
		} else {
			$this->assign('error', $user->_object['check_error']);
		}
		
	}
	
	function display($uniquePageValue = 'registration')
	{
		$this->assign('content_page', 'registration');
		
		parent::display($uniquePageValue, false);
	}
}