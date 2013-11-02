<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class Main_c extends BaseAdminSecurity
{	
    protected $_adminModel;

    function post() {
    	$postHelper = $this->_loadPostHelper();
    	    	
    	$theme = $postHelper->GetFromPost('theme');
    	$body = $postHelper->GetFromPost('body');
    	
    	$_SESSION['theme'] = $theme;
	    $_POST['body'] = str_replace("\\\"", "\"", $_POST['body']);
    	$_SESSION['body'] = $_POST['body'];
	    echo 1;
    	exit();
    }
    
    function __construct() {
      $this->_adminModel = $this->_getModelByName('AdminBase');
    }
  
	function display($uniquePageValue = 'load') 
	{
    	$postHelper = $this->_loadPostHelper();
    	if (!isset($_SESSION['theme'])) {
    		echo "failed";
    		exit();
    	}
    	
    	$files = $this->GetLastFiles('rassilka');
    	
		$theme = $_SESSION['theme'];
    	$body = $_SESSION['body'];
    	
    	$fio = $postHelper->getFromGet('fio');
		if ($fio == null) {
	    	$fio = '';
	    } else {
		    if (mb_detect_encoding($fio, array('UTF-8', 'Windows-1251')) == 'Windows-1251') {
		      $fio = iconv('Windows-1251', 'UTF-8', $fio);
		    }
	    	$fio = ', ' . $fio;
	    }
	    $email = $postHelper->getFromGet('email');
	    
	    $mail = $this->_loadEmail();
	
		$mail->LoadTemplate('native_letter_subscribers');
		$mail->SetValue('body', $body);
		$mail->SetValue('fio', $fio);
		$mail->SetValue('email', $email);
		
		if (empty($files)) {
			$mail->Send($email, $theme, "info@arktida-opt.ru", false);
		} else {
			$mail->SendWithAttachments($email, $theme, $files, "info@arktida-opt.ru", false);
		}
		
		echo "success";
		exit();
	}
}