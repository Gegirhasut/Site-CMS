<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function post () {
		print_r($_POST);
	}
	
	function display($uniquePageValue = 'check')
	{
		echo "check URL";
		
		$this->assign('content_page', 'checkout_success');
		$this->assign('clean_cart', 1);
		
		parent::display($uniquePageValue);
	}
}