<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');
require_once('classes/Objects/Subscriber.php');

class Main_c extends BaseAdminSecurity
{	
    protected $_adminModel;

    function __construct() {
      $this->_adminModel = $this->_getModelByName('AdminBase');
    }
  
	function display($uniquePageValue = 'load') 
	{
    	$postHelper = $this->_loadPostHelper();
    	$subscribers = $postHelper->GetFromGet('subscribers');
    	
    	if ($subscribers == '1') {
    		$subscriber = new Subscriber();
    		$emails = $this->_adminModel->get($subscriber->_tableName);
    	}
    	
    	require_once('helpers/json.php');
		$result_array = array('emails' => $emails, 'subscribers' => $subscribers);
		echo arrayToJson($result_array);
		exit();
	}
}