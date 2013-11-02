<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function post () {
	}
	
	function display($uniquePageValue = 'success')
	{
		if (isset($_GET['MNT_TRANSACTION_ID'])) {
			$this->assign('order_id', (int) $_GET['MNT_TRANSACTION_ID']);
		}
		
		$this->assign('content_page', 'checkout_success');
		$this->assign('clean_cart', 1);
		
		parent::display($uniquePageValue);
	}
}